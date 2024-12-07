<?php
namespace App\Repositories;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderInterface{
    public function getModel(){
        return Order::class;
    }
    public static function getDetailOrder($id){
        $orderDetail = (new self)->model->selectRaw('order_details.*,products.*')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->where('orders.order_id', $id)
            ->select('order_details.*', 'products.product_name','products.product_images')
            ->get();
        return $orderDetail;
    }
    public static function getAll($filter){
        $filter = (object) $filter;
        $data = (new self)->model->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('users', 'orders.user_id', '=', 'users.user_id')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->join('receiver_addresses', 'orders.receiver_address_id', '=', 'receiver_addresses.receiver_address_id')
            ->join('provinces', 'receiver_addresses.province_id', '=', 'provinces.id')
            ->join('districts', 'receiver_addresses.district_id', '=', 'districts.id')
            ->join('wards', 'receiver_addresses.ward_id', '=', 'wards.id')
            ->join('payments', 'orders.order_id', '=', 'payments.order_id')
            ->join('deliveries', 'orders.order_id', '=', 'deliveries.order_id')
            ->join('delivery_methods', 'deliveries.delivery_method_id', '=', 'delivery_methods.delivery_method_id')
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.payment_method_id')
            ->select(
                'orders.*',
                'users.user_fullname','users.user_avatar',
                'payment_methods.payment_method_name',
                'delivery_methods.delivery_method_name',
                'payments.payment_status','payments.payment_id',
                'deliveries.delivery_status','deliveries.delivery_id',
                'receiver_addresses.*',
                'provinces.name as province_name',
                'districts.name as district_name',
                'wards.name as ward_name',
                )
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('product_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('payment_method', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('delivery_method', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('order_status', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('payment_status', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('order_total_amount', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(!empty($filter->user_id), function ($query) use ($filter) {
                return $query->where('orders.user_id', '=', $filter->user_id);
            })
            ->when(!empty($filter->order_status), function ($query) use ($filter) {
                return $query->where('orders.order_status', '=', $filter->order_status);
            })
            ->when(!empty($filter->from_date) || !empty($filter->to_date), function ($query) use ($filter) {
                if (!empty($filter->from_date) && empty($filter->to_date)) {
                    return $query->whereDate('order_created_at', '>=', $filter->from_date);
                } elseif (empty($filter->from_date) && !empty($filter->to_date)) {
                    return $query->whereDate('order_created_at', '<=', $filter->to_date);
                } else {
                    return $query->whereBetween('order_created_at', [$filter->from_date, $filter->to_date]);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy('orders.' . $filter->orderBy, $filter->orderDirection); // Explicitly specify the table name
            })
            ->when(!empty($filter->order_id), function ($query) use ($filter) {
                $query->where('orders.order_id' , $filter->order_id);
            });
            
        
        return $data;
    }
}