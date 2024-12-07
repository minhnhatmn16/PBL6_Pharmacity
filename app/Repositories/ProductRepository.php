<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductInterface{
    public function getModel()
    {
       return  Product::class;
    }
    public static function getAll($filter){
        $filter = (object) $filter;
        $data = (new self)->model->selectRaw('products.*,categories.category_name,brands.brand_name,parents.category_name as parent_category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.category_id')
            ->leftJoin('categories as parents', 'categories.category_parent_id', '=', 'parents.category_id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.brand_id')
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('product_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('categories.category_name','LIKE', '%' . $filter->search . '%')
                        ->orWhere('parents.category_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('parents.category_slug', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('categories.category_slug', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('brands.brand_slug', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('brand_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('product_uses', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(!empty($filter->category_parent_name), function ($query) use ($filter) {
                return $query->where('parents.category_name', '=', $filter->category_parent_name);
            })
            ->when(!empty($filter->category_name), function ($query) use ($filter) {
                return $query->where('categories.category_name', '=', $filter->category_name);
            })
            ->when(!empty($filter->category_id), function ($query) use ($filter) {
                return $query->where('categories.category_id', '=', $filter->category_id);
            })
            ->when(!empty($filter->brand_names), function ($query) use ($filter) {
                return $query->whereIn('brands.brand_name', $filter->brand_names);
            })
            ->when(!empty($filter->brand_id), function ($query) use ($filter) {
                return $query->whereIn('brands.brand_id', $filter->brand_id);
            })
            ->when(!empty($filter->price_from) || !empty($filter->price_to), function ($query) use ($filter) {
                if (!empty($filter->price_from) && empty($filter->price_to)) {
                    return $query->where('product_price', '>=', $filter->price_from);
                } elseif (empty($filter->price_from) && !empty($filter->price_to)) {
                    return $query->where('product_price', '<=', $filter->price_to);
                } else {
                    return $query->whereBetween('product_price', [$filter->price_from, $filter->price_to]);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(isset($filter->product_is_delete), function ($query) use ($filter) {
                if ($filter->product_is_delete === 'all') {
                } else {
                    $query->where('products.product_is_delete', $filter->product_is_delete);
                }
            })
            ->when(!empty($filter->product_id), function ($query) use ($filter) {
                $query->where('products.product_id', '=', $filter->product_id);
            });
        return $data;
    }
}