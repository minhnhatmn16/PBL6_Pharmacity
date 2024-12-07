<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository implements PaymentInterface
{
    public function getModel()
    {
        return Payment::class;
    }
    public static function getAll($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model->join('orders', 'payments.order_id', '=', 'orders.order_id')
            ->join('users', 'orders.user_id', '=', 'users.user_id')
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.payment_method_id')
            ->select('payments.*','users.user_fullname','users.user_avatar','users.user_phone','payment_methods.payment_method_name')
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('payment_methods.payment_method_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('users.user_fullname', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(!empty($filter->payment_status), function ($query) use ($filter) {
                if ($filter->payment_status !== 'all') {
                    $query->where('payments.payment_status', $filter->payment_status);
                }
            })
            ->when(!empty($filter->start_date) || !empty($filter->end_date), function ($query) use ($filter) {
                if (!empty($filter->start_date) && empty($filter->end_date)) {
                    return $query->where('payments.payment_created_at', '>=', $filter->start_date);
                } elseif (empty($filter->start_date) && !empty($filter->end_date)) {
                    return $query->where('payments.payment_created_at', '<=', $filter->end_date);
                } else {
                    return $query->whereBetween('payments.payment_created_at', [$filter->start_date, $filter->end_date]);
                }
            })
            ->when(!empty($filter->payment_method_name), function ($query) use ($filter) {
                return $query->where('payment_methods.payment_method_name', '=', $filter->payment_method_name);
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(!empty($filter->payment_id), function ($q) use ($filter) {
                $q->where('payment_id', $filter->payment_id);
            });
        return $data;
    }
}
