<?php

namespace App\Repositories;

use App\Models\PaymentMethod;



class PaymentMethodRepository extends BaseRepository implements PaymentMethodInterface
{
    public function getModel()
    {
        return PaymentMethod::class;
    }
    public static function getAll($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('payment_method_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('payment_method_description', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(isset($filter->payment_is_active), function ($query) use ($filter) {
                if ($filter->payment_is_active !== 'all') {
                    $query->where('payment_methods.payment_is_active', $filter->payment_is_active);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(!empty($filter->Payment_method_id), function ($q) use ($filter) {
                $q->where('payment_method_id', $filter->payment_method_id);
            });
        return $data;
    }
}
