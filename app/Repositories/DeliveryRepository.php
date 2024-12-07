<?php

namespace App\Repositories;

use App\Models\Delivery;

class DeliveryRepository extends BaseRepository implements DeliveryInterface
{
    public function getModel()
    {
        return Delivery::class;
    }
    public static function getAll($filter)
    {

        $filter = (object) $filter;
        $data = (new self)->model->join('orders', 'deliveries.order_id', '=', 'orders.order_id')
        ->join('users', 'orders.user_id', '=', 'users.user_id')
        ->join('delivery_methods', 'deliveries.delivery_method_id', '=', 'delivery_methods.delivery_method_id')
        ->select('deliveries.*', 'users.user_fullname', 'users.user_avatar', 'users.user_phone', 'delivery_methods.delivery_method_name')
        ->when(!empty($filter->search), function ($q) use ($filter) {
            $q->where(function ($query) use ($filter) {
                $query->where('delivery_methods.delivery_method_name', 'LIKE', '%' . $filter->search . '%')
                    ->orWhere('users.user_fullname', 'LIKE', '%' . $filter->search . '%');
            });
        })
            ->when(!empty($filter->delivery_status), function ($query) use ($filter) {
                if ($filter->delivery_status !== 'all') {
                    $query->where('deliveries.delivery_status', $filter->delivery_status);
                }
            })
            ->when(!empty($filter->start_date) || !empty($filter->end_date), function ($query) use ($filter) {
                if (!empty($filter->start_date) && empty($filter->end_date)) {
                    return $query->where('deliveries.delivery_created_at', '>=', $filter->start_date);
                } elseif (empty($filter->start_date) && !empty($filter->end_date)) {
                    return $query->where('deliveries.delivery_created_at', '<=', $filter->end_date);
                } else {
                    return $query->whereBetween('deliveries.delivery_created_at', [$filter->start_date, $filter->end_date]);
                }
            })
            ->when(!empty($filter->delivery_method_name), function ($query) use ($filter) {
                return $query->where('delivery_methods.delivery_method_name', '=', $filter->delivery_method_name);
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(!empty($filter->delivery_id), function ($q) use ($filter) {
                $q->where('delivery_id', $filter->delivery_id);
            });
        return $data;
    }
}