<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository extends BaseRepository implements BrandInterface
{
    public function getModel()
    {
        return Brand::class;
    }
    public static function  getAll($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('brand_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('brand_description', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(isset($filter->brand_is_delete), function ($query) use ($filter) {
                if ($filter->brand_is_delete !== 'all') {
                    $query->where('brands.brand_is_delete', $filter->brand_is_delete);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(!empty($filter->brand_id), function ($query) use ($filter) {
                $query->where('brand_id',$filter->brand_id);
            });
        return $data;
    }
}
