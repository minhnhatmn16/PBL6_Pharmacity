<?php

namespace App\Services;

use App\Http\Requests\RequestAddPaymentMethod;
use App\Http\Requests\RequestUpdatePaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentInterface;
use App\Repositories\PaymentMethodRepository;
use App\Traits\APIResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PayOS\PayOS;
use Throwable;

class PaymentService
{
    protected PayOSService $payOSService;
    protected PaymentInterface $paymentRepository;
    public function __construct(PayOSService $payOSService, PaymentInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->payOSService = $payOSService;
    }
    use APIResponse;
    public function add(RequestAddPaymentMethod $request){
        DB::beginTransaction();
        try{
            $data = $request->all();
            if ($request->hasFile('payment_method_logo')) {
                $image = $request->file('payment_method_logo');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/thumbnail/brand_logo',
                    'resource_type' => 'auto'
                ]);
                $url = $uploadFile->getSecurePath();
                // Gán logo vào dữ liệu
                $data['payment_method_logo'] = $url;
                $data['created_at'] = now();
            }
            $payment_method=PaymentMethod::create($data);
            DB::commit();
            $data=$payment_method;
            return $this->responseSuccessWithData($data, "Thêm mới phương thức thành công!", 200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getPaymentMethod(Request $request, $id){
        try{
            $data=PaymentMethod::where('payment_method_id',$id)->first();
            if(!$data){
                return $this->responseError("Không tìm thấy phương thức thanh toán!", 404);
            }
            return $this->responseSuccessWithData($data, "Lấy thông tin phương thức thanh toán thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function update(RequestUpdatePaymentMethod $request, $id){
        DB::beginTransaction();
        try{
            $payment_method=PaymentMethod::find($id);
            if(!$payment_method){
                return $this->responseError("Không tìm thấy phương thức thanh toán!", 404);
            }
            if ($request->hasFile('payment_method_logo')) {
                if ($payment_method->payment_method_logo) {
                    $id_file = explode('.', implode('/', array_slice(explode('/', $payment_method->payment_method_logo), 7)))[0];
                    Cloudinary::destroy($id_file);
                }
                $image = $request->file('payment_method_logo');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/thumbnail/brand_logo',
                    'resource_type' => 'auto'
                ]);
                $url = $uploadFile->getSecurePath();
                $data = array_merge($request->all(), ['payment_method_logo' => $url, 'updated_at' => now()]);
                $payment_method->update($data);
            } else {
                $request['payment_method_logo'] = $payment_method->payment_method_logo;
                $request['updated_at'] = now();
                $payment_method->update($request->all());
            }
            DB::commit();
            $data=$payment_method;
            return $this->responseSuccessWithData($data, "Cập nhật phương thức thanh toán thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function delete(Request $request, $id){
        DB::beginTransaction();
        try{
            $payment_method=PaymentMethod::find($id);
            if(!$payment_method){
                return $this->responseError("Không tìm thấy phương thức thanh toán!", 404);
            }
            $status =!$payment_method->payment_is_active;
            $payment_method->update(['payment_is_active'=>$status,'updated_at'=>now()]);
            $message = $status ? "Khôi phục phương thức thanh toán thành công!" : "Xóa phương thức thanh toán thành công!";
            DB::commit();
            return $this->responseSuccess($message, 200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getPaymentMethods(Request $request)
    {
        $orderBy = $request->typesort ?? 'payment_method_id';
        switch ($orderBy) {
            case 'payment_method_name':
                $orderBy = 'payment_method_name';
                break;
            case 'new':
                $orderBy = "payment_method_id";
                break;
            default:
                $orderBy = 'payment_method_id';
                break;
        }
        $orderDirection = $request->sortlatest ?? 'true';
        switch ($orderDirection) {
            case 'true':
                $orderDirection = 'DESC';
                break;
            default:
                $orderDirection = 'ASC';
                break;
        }
        $filter = (object) [
            'search' => $request->search ?? '',
            'payment_is_active' => $request->payment_is_active ?? 'all',
            'orderBy' => $orderBy,
            'orderDirection' => $orderDirection,
        ];
        $paymentMethods = PaymentMethodRepository::getAll($filter);
        if (!(empty($request->paginate))) {
            $paymentMethods = $paymentMethods->paginate($request->paginate);
        } else {
            $paymentMethods = $paymentMethods->get();
        }
        return $paymentMethods;
    }
    public function getAllPaymentMethodByUser(Request $request){
        try{
            $data=$this->getPaymentMethods($request)->where('payment_is_active',1)->values();
            return $this->responseSuccessWithData($data, "Lấy danh sách phương thức thanh toán thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function getAllPaymentMethodByAdmin(Request $request){
        try{
            $data=$this->getPaymentMethods($request)->values();
            return $this->responseSuccessWithData($data, "Lấy danh sách phương thức thanh toán thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $orderBy = $request->typesort ?? 'payment_id';
            switch ($orderBy) {
                case 'payment_method_name':
                    $orderBy = 'payment_method_name';
                    break;
                case 'payment_status':
                    $orderBy = 'payment_status';
                    break;
                case 'new':
                    $orderBy = "payment_id";
                    break;
                default:
                    $orderBy = 'payment_method_id';
                    break;
            }
            $orderDirection = $request->sortlatest ?? 'true';
            switch ($orderDirection) {
                case 'true':
                    $orderDirection = 'DESC';
                    break;
                default:
                    $orderDirection = 'ASC';
                    break;
            }
            $filter = (object) [
                'search' => $request->search ?? '',
                'payment_status' => $request->payment_status ?? 'all',
                'payment_method_name' => $request->payment_method_name ?? '',
                'payment_method_id' => $request->payment_method_id ?? '',
                'order_id' => $request->order_id ?? '',
                'start_date' => $request->start_date ?? '',
                'end_date' => $request->end_date ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
            ];
            $payments=$this->paymentRepository->getAll($filter);
            if (!(empty($request->paginate))) {
                $payments = $payments->paginate($request->paginate);
            } else {
                $payments = $payments->get();
            }
            $data=$payments;
            return $this->responseSuccessWithData($data, "Quản lý hoá đơn của các đơn hàng", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function updateStatus(Request $request, $id){
        DB::beginTransaction();
        try{
            $payment=Payment::where('payment_id',$id)->first();
            if(!$payment){
                return $this->responseError("Không tìm thấy hoá đơn thanh toán!", 404);
            }
            $order=OrderRepository::getAll((object)(['order_id'=>$payment->order_id]))->first();
            if(!$order){
                return $this->responseError("Không tìm thấy đơn hàng!", 404);
            }
            $order_status=$order->order_status;
           
            if($payment->payment_method_id ==1){
                if ($order_status == "delivered" && strtolower($request->payment_status) == "completed") {
                    $payment->update(['payment_status' => 'completed','payment_at'=>now(),'payment_updated_at'=>now()]);
                    $message = "Cập nhật trạng thái thanh toán thành công!";
                }
                else if($order_status == "delivered" && strtolower($request->payment_status) == "failed"){
                    return $this->responseError("Đơn hàng đã được giao, không thể cập nhật trạng thái thanh toán!", 404);
                } else if ($order_status == "cancelled" && strtolower($request->payment_status) == "failed") {
                    $payment->update(['payment_status' => 'failed','payment_updated_at'=>now()]);
                    $message = "Thanh toán thất bại!";
                }
                else{
                    return $this->responseError("Đơn hàng đang được xử lý, không thể cập nhật trạng thái thanh toán!", 404);
                }
            }
            else{
                $payment->update(['payment_status'=>$request->payment_status,'payment_updated_at'=>now()]);
                $message = "Cập nhật trạng thái thanh toán thành công!";
            }
            DB::commit();
            return $this->responseSuccess($message, 200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getPayment(Request $request, $id){
        try{
             $payment=$this->paymentRepository->getAll((object)['payment_id'=>$id])->first();  
            if(!$payment){
                return $this->responseError("Không tìm thấy hoá đơn thanh toán!", 404);
            }
            $data =OrderRepository::getAll((object)['order_id'=>$payment->order_id])->first();
            $data['order_details']=OrderRepository::getDetailOrder($data->order_id);
            return $this->responseSuccessWithData($data, "Lấy thông tin hoá đơn thanh toán thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
   
    public function handlePayOSWebhook(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        Log::info("payos: " , $body);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                "error" => 1,
                "message" => "Invalid JSON payload"
            ], 400);
        }

        if (in_array($body["data"]["description"], ["Ma giao dich thu nghiem", "VQRIO123"])) {
            return response()->json([
                "error" => 0,
                "message" => "Ok",
                "data" => $body["data"]
            ]);
        }

        try {
            $this->payOSService->verifyWebhook($body);

        } catch (\Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Invalid webhook data",
                "details" => $e->getMessage()
            ], 400);
        }

        // Process webhook data

        $order_id = $body["data"]["orderCode"];
        $order = Order::where("order_id", $order_id)->first();
        $payment = Payment::where("order_id",$order_id)->first();
        if (!$order) {
            return response()->json([
                "error" => 1,
                "message" => "Order not found"
            ], 404);
        }
        $status = $body["data"]["code"];
        if($status =="00"){
            $payment->update([
                "payment_status" => "completed"
            ]);
        }
        else{
            $payment->update([
                "payment_status" => "failed"
            ]);
        }
        $data=$payment;
        return $this->responseSuccessWithData($data, "Cập nhật trạng thái thanh toán thành công!", 200);
        
    }
    
    public function vnPayReturn(Request $request)
    {
        try {
            $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $vnp_HashSecret = "J7HVWBXWWJMPSMAU02WU365SX7E4KOXJ";
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            if ($secureHash == $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                    $orderId=$_GET['vnp_TxnRef'];
                    $paymentAt=$_GET['vnp_PayDate'];
                    $payment=Payment::where('order_id',$orderId)->first();
                    $payment->update(['payment_status' => 'completed','payment_at'=>$paymentAt,'payment_updated_at'=>now()]);

                    return $this->responseSuccess("Thanh toán thành công!", 200);
                } else {
                    $orderId=$_GET['vnp_TxnRef'];
                    $payment=Payment::where('order_id',$orderId)->first();
                    $payment->update(['payment_status' => 'failed','payment_updated_at'=>now()]);
                    $order=Order::where('order_id',$orderId)->first();
                    $order->update(['order_status' => 'cancelled','order_updated_at'=>now()]);
                    $delivery=Delivery::where('order_id',$orderId)->first();
                    $delivery->update(['delivery_status' => 'cancelled','delivery_updated_at'=>now()]);
                    return $this->responseError("Thanh toán thất bại!", 400);
                    // echo "GD Khong thanh cong";
                }
            } else {
                $orderId = $_GET['vnp_TxnRef'];
                $payment = Payment::where('order_id', $orderId)->first();
                $payment->update(['payment_status' => 'failed', 'payment_updated_at' => now()]);
                $order = Order::where('order_id', $orderId)->first();
                $order->update(['order_status' => 'cancelled', 'order_updated_at' => now()]);
                $delivery = Delivery::where('order_id', $orderId)->first();
                $delivery->update(['delivery_status' => 'cancelled', 'delivery_updated_at' => now()]);
                return $this->responseError("Chữ ký không hợp lệ", 400);
            }
            
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    } 

}

//  {"code":"00","desc":"success","success":true,"data":{"accountNumber":"56010001731721","amount":2000,"description":"CSED51ZGP85 Thanh toan don hang 52","reference":"1f9d6038-f851-4f4b-aa6d-9c941a104606","transactionDateTime":"2024-11-10 15:36:52","virtualAccountNumber":"V3CAS56010001731721","counterAccountBankId":"","counterAccountBankName":"","counterAccountName":null,"counterAccountNumber":null,"virtualAccountName":"","currency":"VND","orderCode":52,"paymentLinkId":"f517f07e1d064fe998244b35d871a9bc","code":"00","desc":"success"},"signature":"b1c7d143c8407619b6a211c9d71de75e67ce9fbd115db2b963d88bbb0eb14369"} 
// [2024-11-10 08:37:54] local.ERROR: Undefined array key "order_code" {"exception":"[object] (ErrorException(code: 0): Undefined array key \"order_code\" at C:\\laragon\\www\\PBL6-BE\\app\\Services\\PaymentService.php:143)
// [stacktrace]
        // Handle webhook test
 // public function handlePayOSWebhook(Request $request)
    // {
    //     // Decode the JSON payload
    //     $body = json_decode($request->getContent(), true);
    //     // dd($body);
    //     // Log the incoming webhook payload for debugging
    //     Log::info("PayOS Webhook: ", $body);

    //     // Check for JSON decoding errors
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         return response()->json([
    //             "error" => 1,
    //             "message" => "Invalid JSON payload"
    //         ], 400);
    //     }

    //     // Validate if the necessary data exists in the request body
    //     if (!isset($body['data']) || !isset($body['data']['description'])) {
    //         return response()->json([
    //             "error" => 1,
    //             "message" => "Missing required data fields"
    //         ], 400);
    //     }
    //     // Verify webhook data
    //     try {
    //         $this->payOSService->verifyWebhook($body);
    //     } catch (\Exception $e) {
    //         // Log the exception message for debugging
    //         Log::error("PayOS Webhook verification failed: " . $e->getMessage());

    //         return response()->json([
    //             "error" => 1,
    //             "message" => "Invalid webhook data",
    //             "details" => $e->getMessage()
    //         ], 400);
    //     }
    //     if (!isset($body['data']['orderCode'])) {
    //         Log::error("Missing orderCode in webhook payload");
    //         return response()->json([
    //             "error" => 1,
    //             "message" => "orderCode not found"
    //         ], 400);
    //     }
    //     // Process the webhook data and find the associated order
    //     $order = Order::where("order_id", $body['data']['orderCode'])->first();
    //     if (!$order) {
    //         return response()->json([
    //             "error" => 1,
    //             "message" => "Order not found"
    //         ], 404);
    //     }

    //     // Handle payment status based on the code received
    //     $status = $body["data"]["code"];
    //     switch ($status) {
    //         case "00":
    //             $order->update([
    //                 "payment_status" => "completed"
    //             ]);
    //             break;
    //         case "20":
    //             $order->update([
    //                 "payment_status" => "failed"
    //             ]);
    //             break;
    //         default:
    //             $order->update([
    //                 "payment_status" => "failed"
    //             ]);
    //             break;
    //     }

    //     // Return success response with order data
    //     return response()->json([
    //         "error" => 0,
    //         "message" => "Webhook processed successfully",
    //         "data" => $order
    //     ]);
    // }
