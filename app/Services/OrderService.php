<?php

namespace App\Services;

use App\Enums\UserEnum;
use App\Http\Requests\RequestUserBuyProduct;
use App\Http\Requests\RequestUserCheckoutCart;
use App\Jobs\CancelOrderJob;
use App\Jobs\SendMailNotify;
use App\Models\Cart;
use App\Models\Delivery;
use App\Models\DeliveryMethod;
use App\Models\ImportDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderInterface;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use PayOS\PayOS;
use Throwable;

class OrderService
{
    use APIResponse;
    protected OrderInterface $orderRepository;
    protected PayOSService $payOSService;
    protected VnpayService $vnpayService;
    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->payOSService = new PayOSService();
        $this->vnpayService = new VnpayService();
    }
    public function getImportDetailsForOrder($productId, $orderQuantity)
    {
        $remainingQuantity = $orderQuantity;
        $importDetailsToSell = [];

        // Lấy các lô nhập theo thứ tự FIFO
        $importDetails = ImportDetail::where('product_id', $productId)
            ->where('retaining_quantity', '>', 0)
            ->orderBy('entry_date', 'asc')
            ->get();

        // Duyệt qua các lô nhập để lấy sản phẩm theo FIFO
        foreach ($importDetails as $importDetail) {
            if ($remainingQuantity <= 0) {
                break;
            }

            // Số lượng có thể lấy từ lô này
            $availableQuantity = $importDetail->retaining_quantity;

            if ($remainingQuantity <= $availableQuantity) {
                // Nếu số lượng cần bán <= số lượng còn lại trong lô
                $importDetailsToSell[] = [
                    'import_detail_id' => $importDetail->import_detail_id,
                    'quantity' => $remainingQuantity,
                    'price' => $importDetail->import_price,
                ];

                // Cập nhật số lượng còn lại trong lô
                $importDetail->retaining_quantity -= $remainingQuantity;
                $importDetail->save();

                // Đã đủ số lượng cần bán
                $remainingQuantity = 0;
            } else {
                // Nếu số lượng cần bán > số lượng còn lại trong lô
                $importDetailsToSell[] = [
                    'import_detail_id' => $importDetail->import_detail_id,
                    'quantity' => $availableQuantity,
                    'price' => $importDetail->import_price,
                ];

                // Bán hết lô này
                $remainingQuantity -= $availableQuantity;
                $importDetail->retaining_quantity = 0;
                $importDetail->save();
            }
        }

        // Trả về danh sách các lô sản phẩm sẽ bán
        return $importDetailsToSell;
    }
    private function createOrderDetail($order, $product, $quantity)
    {
        $product=(object)$product;
        $product_id = $product->product_id;
        $product_price=$product->product_price;
        $orderDetails=[];
        $total_amount = 0;
        $importDetails = $this->getImportDetailsForOrder($product_id, $quantity);
        foreach ($importDetails as $importDetail) {
            $import_quantity = $importDetail['quantity'];
            $orderDetailData = [
                'order_id' => $order->order_id,
                'product_id' => $product_id,
                'order_quantity' => $import_quantity,
                'order_price' => $product_price,
                'order_total_price' => $product_price *  $import_quantity,
                'import_detail_id' => $importDetail['import_detail_id'],
            ];
            $orderDetails[] = OrderDetail::create($orderDetailData);
            $total_amount += $product_price *  $import_quantity;
        }
        $order->update(['order_total_amount' => ($order->order_total_amount+ $total_amount),'order_updated_at' => now()]);
        // dump($order);
        return $orderDetails;
    }
    private function updateProductQuantityAndSold($product, $quantity)
    {
        $product->update([
            'product_quantity' => $product->product_quantity - $quantity,
            'product_sold' => $product->product_sold + $quantity,
            'product_updated_at' => now(),
        ]);
    }
  
    public function buyNow(RequestUserBuyProduct $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::where('product_id', $request->product_id)->first();
            $user = auth('user_api')->user();

            if (empty($product)) {
                return $this->responseError('Sản phẩm không tồn tại!', 404);
            }
            if ($product->product_quantity < $request->quantity) {
                return $this->responseError('Số lượng sản phẩm trong kho không đủ!', 400);
            }
            $delivery_fee=DeliveryMethod::where('delivery_method_id',$request->delivery_id)->first()->delivery_fee;
            //Tạo đơn hàng
            $data = [
                'user_id' => $user->user_id,
                'receiver_address_id' => $request->receiver_address_id,
                'order_total_amount' => $delivery_fee,
                'order_created_at' => now(),
            ];
            $order = $this->orderRepository->create($data);
            //Tạo chi tiết đơn hàng

            $orderDetail = $this->createOrderDetail($order, $product, $request->quantity);
           
            $payment_method_id=$request->payment_id;
            $this->updateProductQuantityAndSold($product, $request->quantity);
            $this->createPaymentRecord($order, $payment_method_id);
            $order_total_amount=$order->order_total_amount;
            if ($payment_method_id == 1) {
                $delivery_fee = $order_total_amount;
            }
            else if ($payment_method_id == 2 || $payment_method_id == 3 ) {
               $delivery_fee=0;
            }
            $this->createDeliveriesRecord($order, $request->delivery_id, $delivery_fee);
            DB::commit();
            $this->sendOrderConfirmationEmail($user, $order, $orderDetail);

            if ($payment_method_id == 2) {
                CancelOrderJob::dispatch($order)->delay(now()->addMinutes(5));
                $order_id=$order->order_id;
                return $this->handlePayOSPayment($order_id, $order_total_amount);
            }
            else if($payment_method_id == 3){
                $order_id=$order->order_id;
                CancelOrderJob::dispatch($order)->delay(now()->addMinutes(5));
                return $this->vnpayService->createVnPayPayment($order_id, $order_total_amount);
            }
            $order['order_detail'] = $this->groupOrderDetailByProductId($orderDetail);
            $data = $order;
            return $this->responseSuccessWithData($data, 'Đặt hàng thành công!', 200);
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->responseError($th->getMessage(), 400);
        }
    }
    private function handlePayOSPayment($orderId, $totalAmount)
    {
        $YOUR_DOMAIN = UserEnum::URL_CLIENT;
        $paymentData = [
            "orderCode" => $orderId,
            "amount" => $totalAmount,
            "description" => "Thanh toán đơn hàng #" . $orderId,
            "returnUrl" => $YOUR_DOMAIN . "/success",
            "cancelUrl" => $YOUR_DOMAIN . "/cancel",
        ];
        $response = $this->payOSService->createPaymentLink($paymentData);
        $data = $response['checkoutUrl'];
        return $this->responseSuccessWithData($data, 'Vui lòng thanh toán hoá đơn!', 200);
    }
    public function checkoutCart(RequestUserCheckoutCart $request)
    {
        DB::beginTransaction();
        try {
            $user = auth('user_api')->user();
            $ids_cart = $request->ids_cart;
            $carts = Cart::whereIn('cart_id', $ids_cart)->get();
            //Check số lượng sản phẩm còn không?
         
            if ($carts->isEmpty()) {
                return $this->responseError('Giỏ hàng rỗng!', 404);
            }
            foreach ($carts as $cart) {
                $product = Product::where('product_id', $cart->product_id)->where('product_is_delete', '0')->first();
                if (empty($product)) {
                    return $this->responseError('Sản phẩm không tồn tại!', 404);
                }
                if ($product->product_quantity < $cart->cart_quantity) {
                    return $this->responseError('Số lượng sản phẩm '.$product->product_name.' trong kho không đủ!', 400);
                }
            }
            $delivery_fee = DeliveryMethod::where('delivery_method_id', $request->delivery_id)->first()->delivery_fee;
            $data =[
                'user_id' => $user->user_id,
                'receiver_address_id' => $request->receiver_address_id,
                'order_total_amount' => $delivery_fee,
                'order_created_at' => now(),
            ];
            $order = $this->orderRepository->create($data);

            foreach ($carts as $cart) {
                $product = Product::where('product_id', $cart->product_id)->where('product_is_delete','0')->first();
                $quantity = $cart->cart_quantity;
                $orderDetails[] = $this->createOrderDetail($order, $product,  $quantity);
                $this->updateProductQuantityAndSold($product,  $quantity);
                // $order_details = $orderDetail;
            }
            
            Cart::whereIn('cart_id', $ids_cart)->delete();
            $payment_method_id = $request->payment_id;
            $this->createPaymentRecord($order, $payment_method_id);
            $order_total_amount = $order->order_total_amount;
            if ($payment_method_id == 1) {
                $delivery_fee = $order_total_amount;
            } else if ($payment_method_id == 2 || $payment_method_id == 3) {
                $delivery_fee = 0;
            } 
            $this->createDeliveriesRecord($order, $request->delivery_id, $delivery_fee);
            $order = Order::where('order_id', $order->order_id)->first();
            $order['order_status'] = $order->order_status;
            foreach($orderDetails as $order_detail){
                $detail = $this->groupOrderDetailByProductId($order_detail);
                $details[]= array_merge(...$detail);
            }
            
            $order['order_detail'] = $details;
            $data = $order;
            // return $this->responseSuccessWithData($orderDetails[0], 'Đặt hàng thành công!', 200);
            $this->sendOrderConfirmationEmail($user, $order, $orderDetails[0]);
             DB::commit();
            
           
            if ($request->payment_id == 2) {
                $orderId=$order->order_id;
                CancelOrderJob::dispatch($order)->delay(now()->addMinutes(5));
                return $this->handlePayOSPayment($orderId, $order_total_amount);
            } else if ($payment_method_id == 3) {
                $order_id = $order->order_id;
                CancelOrderJob::dispatch($order)->delay(now()->addMinutes(5));
                return $this->vnpayService->createVnPayPayment($order_id, $order_total_amount);
            }
           $data=$order;
            return $this->responseSuccessWithData($data, 'Đặt hàng thành công!', 200);
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->responseError($th->getMessage(), 500);
        }
    }
    public function groupOrderDetailByProductId($orderDetails){
        // Tạo mảng để nhóm các chi tiết đơn hàng theo product_id mà không sử dụng khóa product_id
        $groupedDetails = [];
        foreach ($orderDetails as $detail) {
            // Nếu chưa có thông tin sản phẩm, thêm mới vào mảng
            $found = false;
            foreach ($groupedDetails as &$group) {
                if ($group['product_id'] == $detail->product_id) {
                    // Nếu sản phẩm đã có, cộng dồn số lượng và giá trị
                    $group['order_quantity'] += $detail->order_quantity;
                    $group['order_total_price'] += $detail->order_total_price;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                // Nếu chưa có, thêm sản phẩm mới vào mảng
                $groupedDetails[] = [
                    'product_id' => $detail->product_id,
                    'order_quantity' => $detail->order_quantity,
                    'order_price' => $detail->order_price,
                    'order_total_price' => $detail->order_total_price
                ];
            }
        }
        return $groupedDetails;
    }
    private function sendOrderConfirmationEmail($user, $order, $orderDetails)
    {
        $groupedDetails = $this->groupOrderDetailByProductId($orderDetails);
        // Tạo nội dung email
        $content = '
    <p>Đặt hàng thành công! Đơn hàng của bạn là:</p>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;"> 
        <tr>
            <th colspan="2">Thông tin đơn hàng</th>
        </tr>
        <tr>
            <td>Mã đơn hàng</td>
            <td>' . $order->order_id . '</td>
        </tr>
        <tr>
            <td>Tổng tiền</td>
            <td>' . number_format($order->order_total_amount, 0, ',', '.') . ' VND</td>
        </tr>
        <tr>
            <td>Ngày tạo</td>
            <td>' . $order->order_created_at . '</td>
        </tr>
        <tr>
            <th colspan="2">Chi tiết đơn hàng</th>';

        // Duyệt qua mảng groupedDetails để hiển thị thông tin các sản phẩm
        foreach ($groupedDetails as $detail) {
            $content .= '
        <tr>
            <td>Mã sản phẩm</td>
            <td>' . $detail['product_id'] . '</td>
        </tr>
        <tr>
            <td>Số lượng</td>
            <td>' . $detail['order_quantity'] . '</td>
        </tr>
        <tr>
            <td>Giá</td>
            <td>' . number_format($detail['order_price'], 0, ',', '.') . ' VND</td>
        </tr>
        <tr>
            <td>Tổng giá</td>
            <td>' . number_format($detail['order_total_price'], 0, ',', '.') . ' VND</td>
        </tr>';
        }

        $content .= '</table>';
        // dd($content);
        // Đẩy email vào queue để gửi
        Queue::push(new SendMailNotify($user->email, $content));
    }
    public function createPaymentRecord($order, $payment_method_id)
    {
        $data = [
            'order_id' => $order->order_id,
            'payment_method_id' => $payment_method_id,
            'payment_amount' => $order->order_total_amount,
            'payment_status' => 'pending',
            'payment_created_at' => now(),
        ];
        return Payment::create($data);
    }
        public function createDeliveriesRecord($order, $delivery_method_id, $delivery_fee = 0)
    {
        $data = [
            'order_id' => $order->order_id,
            'delivery_method_id' => $delivery_method_id,
            'delivery_fee' => $delivery_fee,
            'delivery_status' => 'pending',
            'delivery_created_at' => now(),
        ];
        // dump($data);
        return Delivery::create($data);
    }

 
    public function getOrderDetail(Request $request, $id)
    {
        try {
            $user = auth('user_api')->user();
            $order = $this->orderRepository->getAll((object)['order_id' => $id, 'user_id' => $user->user_id])->first();
            if (empty($order)) {
                return $this->responseError('Order not found!', 404);
            }
            $order_details = $this->orderRepository->getDetailOrder($id);
            $order['order_detail'] = $order_details;
            $data=$order;
            return $this->responseSuccessWithData($data, 'Lấy thông tin đơn hàng thành công!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function cancelOrder(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = auth('user_api')->user();
            $order = Order::where('order_id', $id)->where('user_id', $user->user_id)->first();
            if (empty($order)) {
                return $this->responseError('Không tìm thấy đơn hàng của bạn!', 404);
            }
            if ($order->order_status == "shipped") {
                return $this->responseError('Đơn hàng đang được giao, không thể hủy!', 400);
            }
            if ($order->order_status == "delivered") {
                return $this->responseError('Đơn hàng đã được giao, không thể hủy!', 400);
            }
            if ($order->order_status == "cancelled") {
                return $this->responseError('Đơn hàng đã bị hủy!', 400);
            }
            $order->update([
                'order_status' => "cancelled",
                'order_updated_at' => now(),
            ]);
            $delivery=Delivery::where('order_id',$id)->first();
            $delivery->update([
                'delivery_status' => "cancelled",
                'delivery_updated_at' => now(),
            ]);
            $payment=Payment::where('order_id',$id)->first();
            $payment->update([
                'payment_status' => "failed",
                'payment_updated_at' => now(),
            ]);
            $order_details = $this->orderRepository->getDetailOrder($id);
            $this->updateQuantityImportDetailAndProduct($id);
            $order['order_detail'] = $order_details;
            DB::commit();
            $data = $order;
            return $this->responseSuccessWithData($data, 'Hủy đơn hàng thành công!', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getOrderHistory(Request $request)
    {
        try {
            $user = auth('user_api')->user();
            $user_id = $user->user_id;
            $order_status = $request->order_status;
            $orders = $this->orderRepository->getAll((object)['user_id' => $user_id, 'order_status' => $order_status,
                                                    'orderBy'=>'order_id','orderDirection'=>'DESC'])->distinct();
            if ($orders->get()->isEmpty()) {
                return $this->responseSuccess('Không có đơn hàng!', 200);
            }
            if (!empty($request->paginate)) {
                $orders = $orders->paginate($request->paginate);
            } else {
                $orders = $orders->get();
            }
            foreach($orders as $order){
                $order['order_detail'] =$this->orderRepository->getDetailOrder($order->order_id);
            }
            $data=$orders;
            return $this->responseSuccessWithData($data, 'Lấy lịch sử đơn hàng thành công!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getAll(Request $request)
    {
        try {
            $orderBy = $request->typesort ?? 'order_id';
            switch ($orderBy) {
                case 'order_total_amount':
                    $orderBy = 'order_total_amount';
                    break;
                case 'new':
                    $orderBy = 'order_id';
                    break;
                case 'order_status':
                    $orderBy = 'order_status';
                    break;
                case 'payment_status':
                    $orderBy = 'payment_status';
                    break;
                case 'delivery_status':
                    $orderBy = 'delivery_status';
                    break;
                case 'order_id':
                    $orderBy = 'order_id';
                    break;
                default:
                    $orderBy = 'order_id';
                    break;
            }
            $orderDirection = $request->sortlatest == 'true' ? 'DESC' : 'ASC';

            $filter = (object)[
                'search' => $request->search ?? '',
                'user_id' => $request->user_id ?? '',
                'payment_status' => $request->payment_status ?? '',
                'delivery_status' => $request->delivery_status ?? '',
                'payment_method_id' => $request->payment_method_id ?? '',
                'delivery_method_id' => $request->delivery_method_id ?? '',
                'order_id' => $request->order_id ?? '',
                'payment_method_name' => $request->payment_method_name ?? '',
                'delivery_method_name' => $request->delivery_method_name ?? '',
                'order_status' => $request->order_status ?? 'pending',
                'to_date' => $request->to_date ?? '',
                'from_date' => $request->from_date ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
            ];
            $orders = $this->orderRepository->getAll($filter)->distinct();
            if (!empty($request->paginate)) {
                $orders = $orders->paginate($request->paginate);
            } else {
                $orders = $orders->get();
            }
            if ($orders->isEmpty()) {
                return $this->responseSuccess('Không có đơn hàng!', 200);
            }
            foreach ($orders as $order) {
                $order['order_detail']= $this->orderRepository->getDetailOrder($order->order_id)->values();
                 
            }
            $data = $orders;
            return $this->responseSuccessWithData($data, 'Lấy danh sách đơn hàng thành công!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getDetailOrder(Request $request, $id)
    {
        try {
            // $order = Order::find($id);
            $order = $this->orderRepository->getAll((object)['order_id' => $id])->first();
            if (empty($order)) {
                return $this->responseError('Đơn hàng không tồn tại!', 404);
            }
            $order['order_details'] = $this->orderRepository->getDetailOrder($id);
            $data = $order;
            return $this->responseSuccessWithData($data, 'Lấy thông tin chi tiết đơn hàng thành công!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($id);
            if (empty($order)) {
                return $this->responseError('Không tìm thấy đơn hàng!', 404);
            }

            // Trường hợp đơn hàng đã bị hủy hoặc đã giao
            if ($order->order_status == "cancelled") {
                return $this->responseError('Đơn hàng đã bị hủy!', 400);
            } else if ($order->order_status == "delivered") {
                return $this->responseError('Đơn hàng đã được giao!', 400);
            }

            // Kiểm tra nếu muốn hủy đơn hàng
            if ($request->input('status') == 'cancelled') {
                if ($order->order_status == "pending" || $order->order_status == "confirmed") {
                    $order->update([
                        'order_status' => 'cancelled',
                        'order_updated_at' => now(),
                    ]);
                    $delivery = Delivery::where('order_id', $id)->first();
                    if ($delivery) {
                        $delivery->update([
                            'delivery_status' => 'cancelled',
                            'delivery_updated_at' => now(),
                        ]);
                    }
                    $payment = Payment::where('order_id', $id)->first();
                    if ($payment) {
                        $payment->update([
                            'payment_status' => 'failed',
                            'payment_updated_at' => now(),
                        ]);
                    }
                    $this->updateQuantityImportDetailAndProduct($id);
                } else {
                    return $this->responseError('Không thể hủy đơn hàng ở trạng thái này!', 400);
                }
            }

            // Các trạng thái khác
            else if ($order->order_status == "pending") {
                // Xử lý thanh toán
                $payment = Payment::where('order_id', $id)->first();
                if ($payment && $payment->payment_method_id == 2) {
                    if ($payment->payment_status == 'pending') {
                        return $this->responseError('Đơn hàng chưa thanh toán!', 400);
                    } elseif ($payment->payment_status == 'failed') {
                        $order->update([
                            'order_status' => 'cancelled',
                            'order_updated_at' => now(),
                        ]);
                        $delivery = Delivery::where('order_id', $id)->first();
                        if ($delivery) {
                            $delivery->update([
                                'delivery_status' => 'cancelled',
                                'delivery_updated_at' => now(),
                            ]);
                        }
                        return $this->responseError('Đơn hàng thanh toán thất bại!', 400);
                    } else {
                        $order->update([
                            'order_status' => 'confirmed',
                            'order_updated_at' => now(),
                        ]);
                    }
                } else {
                    $order->update([
                        'order_status' => 'confirmed',
                        'order_updated_at' => now(),
                    ]);
                }
            } else if ($order->order_status == "confirmed") {
                $order->update([
                    'order_status' => 'shipped',
                    'order_updated_at' => now(),
                ]);
                $delivery = Delivery::where('order_id', $id)->first();
                if ($delivery) {
                    $delivery->update([
                        'delivery_status' => 'shipped',
                        'delivery_updated_at' => now(),
                    ]);
                }
            } else {
                $order->update([
                    'order_status' => 'delivered',
                    'order_updated_at' => now(),
                ]);
                $delivery = Delivery::where('order_id', $id)->first();
                if ($delivery) {
                    $delivery->update([
                        'delivery_status' => 'delivered',
                        'delivery_updated_at' => now(),
                    ]);
                }
                $payment = Payment::where('order_id', $id)->first();
                if ($payment) {
                    $payment->update([
                        'payment_status' => 'completed',
                        'payment_updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            // Gửi thông báo qua email
            $user_email = User::find($order->user_id)->email;
            $content = 'Đơn hàng của bạn có mã đơn hàng là ' . $id . ' đã được cập nhật trạng thái thành: ' . $order->order_status;
            Log::info("Thêm jobs vào hàng đợi, Email:$user_email");
            Queue::push(new SendMailNotify($user_email, $content));

            $data = Order::where('order_id', $id)->first();
            return $this->responseSuccessWithData($data, 'Cập nhật trạng thái đơn hàng thành ' . $order->order_status.' thành công!', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }

    public function getPaymentInfo($orderCode)
    {
        try {
            $data = $this->payOSService->getPaymentLink($orderCode);
            return $this->responseSuccess($data, 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function cancelPayment($orderCode)
    {
        try {
            $response = $this->payOSService->cancelPaymentLink($orderCode);
            $order = Order::where('order_id', $orderCode)->first();
            $order->update([
                'order_status' => 'cancelled',
                'order_updated_at' => now(),
            ]);
            $delivery = Delivery::where('order_id', $orderCode)->first();
            $delivery->update([
                'delivery_status' => 'cancelled',
                'delivery_updated_at' => now(),
            ]);
            $payment = Payment::where('order_id', $orderCode)->first();
            $payment->update([
                'payment_status' => 'failed',
                'payment_updated_at' => now(),
            ]);
            $order_details = $this->orderRepository->getDetailOrder($orderCode);
            $this->updateQuantityImportDetailAndProduct($orderCode);
            $order['order_detail'] = $order_details;
            $data=$order;
            $userEmail = User::find($order->user_id)->email;
            $content = 'Đơn hàng # ' . $order->order_id . ' của bạn đã bị hủy do không thanh toán trong thời gian quy định';
            Log::info("Huỷ đơn hàng tự động qua Job, Email: " . $userEmail);
            Queue::push(new SendMailNotify($userEmail, $content));
            return $this->responseSuccessWithData($data, "Đã huỷ đơn hàng!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function updateQuantityImportDetailAndProduct($orderId){
        $orderDetails = OrderDetail::where('order_id', $orderId)->get();
        foreach ($orderDetails as $orderDetail) {
            $product = Product::find($orderDetail->product_id);
            $product->update([
                'product_quantity' => $product->product_quantity + $orderDetail->order_quantity,
                'product_sold' => $product->product_sold - $orderDetail->order_quantity,
            ]);
            $importDetail = ImportDetail::where('product_id', $orderDetail->product_id)
                ->where('import_detail_id', $orderDetail->import_detail_id)->first();
            $importDetail->update([
                'retaining_quantity' => $importDetail->retaining_quantity + $orderDetail->order_quantity,
            ]);
        }
    }
}
