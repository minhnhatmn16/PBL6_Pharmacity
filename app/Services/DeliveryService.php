<?php
namespace App\Services;

use App\Http\Requests\RequestAddDeliveryMethod;
use App\Http\Requests\RequestUpdateDeliveryMethod;
use App\Models\Delivery;
use App\Models\DeliveryMethod;
use App\Models\Payment;
use App\Repositories\DeliveryInterface;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\OrderRepository;
use App\Traits\APIResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Throwable;

class DeliveryService{
    use APIResponse;
    protected DeliveryInterface $deliveryRepository;
    public function __construct(DeliveryInterface $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }
    public function add(RequestAddDeliveryMethod $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($request->hasFile('delivery_method_logo')) {
                $image = $request->file('delivery_method_logo');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/thumbnail/brand_logo',
                    'resource_type' => 'auto'
                ]);
                $url = $uploadFile->getSecurePath();
                // Gán logo vào dữ liệu
                $data['delivery_method_logo'] = $url;
                $data['created_at'] = now();
            }
            $delivery_method = DeliveryMethod::create($data);
            DB::commit();
            $data=$delivery_method;
            return $this->responseSuccessWithData($data, "Thêm mới phương thức thành công!", 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getDeliveryMethod(Request $request, $id)
    {
        try {
            $delivery_method = DeliveryMethod::find($id);
            if (!$delivery_method) {
                return $this->responseError("Không tìm thấy phương thức thanh toán!", 404);
            }
            $data=$delivery_method;
            return $this->responseSuccessWithData($data, "Lấy thông tin phương thức thanh toán thành công!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function update(RequestUpdateDeliveryMethod $request, $id)
    {
        DB::beginTransaction();
        try {
            $delivery_method = DeliveryMethod::find($id);
            if (!$delivery_method) {
                return $this->responseError("Không tìm thấy phương thức thanh toán!", 404);
            }
            if ($request->hasFile('delivery_method_logo')) {
                if ($delivery_method->delivery_method_logo) {
                    $id_file = explode('.', implode('/', array_slice(explode('/', $delivery_method->delivery_method_logo), 7)))[0];
                    Cloudinary::destroy($id_file);
                }
                $image = $request->file('delivery_method_logo');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/thumbnail/brand_logo',
                    'resource_type' => 'auto'
                ]);
                $url = $uploadFile->getSecurePath();
                $data = array_merge($request->all(), ['delivery_method_logo' => $url, 'updated_at' => now()]);
                $delivery_method->update($data);
            } else {
                $request['delivery_method_logo'] = $delivery_method->delivery_method_logo;
                $request['updated_at'] = now();
                $delivery_method->update($request->all());
            }
            DB::commit();
            $data=$delivery_method;
            return $this->responseSuccessWithData($data, "Cập nhật phương thức thanh toán thành công!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $delivery_method = DeliveryMethod::find($id);
            if (!$delivery_method) {
                return $this->responseError("Không tìm thấy phương thức thanh toán!", 404);
            }
            $status = !$delivery_method->delivery_is_active;
            $delivery_method->update(['delivery_is_active' => $status, 'updated_at' => now()]);
            $message = $status ? "Khôi phục phương thức thanh toán thành công!" : "Xóa phương thức thanh toán thành công!";
            DB::commit();
            return $this->responseSuccess($message, 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getDeliveryMethods(Request $request)
    {
        $orderBy = $request->typesort ?? 'delivery_method_id';
        switch ($orderBy) {
            case 'delivery_method_name':
                $orderBy = 'delivery_method_name';
                break;
            case 'new':
                $orderBy = "delivery_method_id";
                break;
            default:
                $orderBy = 'delivery_method_id';
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
            'delivery_is_active' => $request->delivery_is_active ?? 'all',
            'delivery_method_id' => $request->delivery_method_id ?? null,
            'orderBy' => $orderBy,
            'orderDirection' => $orderDirection,
        ];
        $deliveryMethods = DeliveryMethodRepository::getAll($filter);
        if (!(empty($request->paginate))) {
            $deliveryMethods = $deliveryMethods->paginate($request->paginate);
        } else {
            $deliveryMethods = $deliveryMethods->get();
        }
        return $deliveryMethods;
    }
    public function getAllDeliveryMethodByUser(Request $request)
    {
        try {
            $data = $this->getDeliveryMethods($request)->where('delivery_is_active', 1)->values();
            return $this->responseSuccessWithData($data, "Lấy danh sách phương thức thanh toán thành công!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getAllDeliveryMethodByAdmin(Request $request)
    {
        try {
            $data = $this->getDeliveryMethods($request)->values();
            return $this->responseSuccessWithData($data, "Lấy danh sách phương thức thanh toán thành công!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    //deliveries
    public function getAll(Request $request)
    {
        try {
            $orderBy = $request->typesort ?? 'delivery_id';
            switch ($orderBy) {
                case 'delivery_method_name':
                    $orderBy = 'delivery_method_name';
                    break;
                case 'delivery_status':
                    $orderBy = 'delivery_status';
                    break;
                case 'new':
                    $orderBy = "delivery_id";
                    break;
                default:
                    $orderBy = 'delivery_method_id';
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
                'delivery_status' => $request->delivery_status ?? 'all',
                'delivery_method_name' => $request->delivery_method_name ?? '',
                'delivery_method_id' => $request->delivery_method_id ?? '',
                'order_id' => $request->order_id ?? '',
                'start_date' => $request->start_date ?? '',
                'end_date' => $request->end_date ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
            ];
            $deliveries = $this->deliveryRepository->getAll($filter);
            if (!(empty($request->paginate))) {
                $deliveries = $deliveries->paginate($request->paginate);
            } else {
                $deliveries = $deliveries->get();
            }
            $data = $deliveries;
            return $this->responseSuccessWithData($data, "Quản lý hoá đơn của các đơn hàng", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $delivery = Delivery::where('delivery_id', $id)->first();
            if (!$delivery) {
                return $this->responseError("Không tìm thấy hoá đơn thanh toán!", 404);
            }
            $order = OrderRepository::getAll((object)['order_id' => $delivery->order_id])->first();
            $payment = Payment::where('order_id', $order->order_id)->first();
            $status = $request->delivery_status;
            if($order->order_status == 'canceled' || $order->order_status == 'delivered'){
                return $this->responseError("Không thể cập nhật trạng thái!", 400);
            }
            elseif($order->order_status =='pending'){
                return $this->responseError("Đơn hàng chưa được xác nhận!", 400);
            } elseif ($order->order_status == 'confirmed' && $status == 'shipped') {
                if ($payment->payment_method_id == 2) {
                    if ($payment->payment_status == 'pending') {
                        return $this->responseError("Đơn hàng này không được cập nhật vì chưa thanh toán bằng payos!", 400);
                    } elseif ($payment->payment_status == 'failed') {
                        return $this->responseError("Đơn hàng này không được cập nhật vì thanh toán bằng payos thất bại!", 400);
                    } else {
                        $order->update(['order_status' => $status, 'order_updated_at' => now()]);
                        $delivery->update(['delivery_status' => $status, 'delivery_updated_at' => now()]);
                    }
                } else {
                    $order->update(['order_status' => $status, 'order_updated_at' => now()]);
                    $delivery->update(['delivery_status' => $status, 'delivery_updated_at' => now()]);
                }
            }
            elseif($order->order_status == 'shipped' && $status == 'delivered'){
                $order->update(['order_status' => 'delivered','order_updated_at' => now()]);
                if($payment->payment_method_id == 1){
                    $payment->update(['payment_status' => 'completed',
                                     'payment_at' => now(),
                                    'payment_updated_at' => now()]);  
                }
                $delivery->update(['delivery_status' => $status,'delivery_updated_at' => now(),'delivery_at' => now()]);
            } else if ($status == 'canceled') {
                $order->update(['order_status' => 'canceled', 'order_updated_at' => now()]);
                if ($payment->payment_method_id == 1) {
                    $payment->update([
                        'payment_status' => 'failed',
                        'payment_at' => now(),
                        'payment_updated_at' => now()
                    ]);
                }
                $delivery->update(['delivery_status' => $status,'delivery_updated_at' => now(),'delivery_at' => now()]);
            }
            $message = "Cập nhật trạng thái giao hàng thành $delivery->delivery_status thành công!";
            DB::commit();
            $data=$delivery;
            return $this->responseSuccessWithData($data,$message, 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getDelivery(Request $request, $id)
    {
        try {
            $delivery = $this->deliveryRepository->getAll((object)['delivery_id' => $id])->first();
            if (!$delivery) {
                return $this->responseError("Không tìm thấy hoá đơn thanh toán!", 404);
            }
            $data = OrderRepository::getAll((object)['order_id' => $delivery->order_id])->first();
            $data['order_details'] = OrderRepository::getDetailOrder($data->order_id);
            return $this->responseSuccessWithData($data, "Lấy thông tin hoá đơn thanh toán thành công!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
   
}