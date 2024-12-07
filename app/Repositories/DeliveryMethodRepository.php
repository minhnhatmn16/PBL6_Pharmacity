<?php

namespace App\Repositories;
use App\Models\DeliveryMethod;

class DeliveryMethodRepository extends BaseRepository implements DeliveryMethodInterface
{
    public function getModel()
    {
        return DeliveryMethod::class;
    }
    public static function getAll($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('delivery_method_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('delivery_method_description', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(isset($filter->delivery_is_active), function ($query) use ($filter) {
                if ($filter->delivery_is_active !== 'all') {
                    $query->where('delivery_methods.delivery_is_active', $filter->delivery_is_active);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(!empty($filter->delivery_method_id), function ($q) use ($filter) {
                $q->where('delivery_method_id', $filter->delivery_method_id);
            });
        return $data;
    }
}