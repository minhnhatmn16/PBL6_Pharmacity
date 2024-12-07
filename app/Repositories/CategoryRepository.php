<?php
namespace App\Repositories;

use App\Models\Category;
class CategoryRepository extends BaseRepository implements CategoryInterface{
    public function getModel(){
        return Category::class;
    }
    public static function getCategory($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model
            ->when(!empty($filter->id), function ($q) use ($filter) {
                $q->where('category_id', $filter->id);
            })
            ->when(!empty($filter->ids_category), function ($q) use ($filter) {
                $q->whereIn('category_id', $filter->ids_category);
            });

        return $data;
    }
    public static function getAll($filter)
    {
        $filter = (object) $filter;

        $data = (new self)->model
            ->from('categories as category')
            ->leftJoin('categories as category_parent', 'category.category_parent_id', '=', 'category_parent.category_id') // Self join
            ->selectRaw(
                'category.*, category_parent.*,category.category_id as category_id,category.category_thumbnail as category_thumbnail,category.category_name as category_name,
                category.category_slug as category_slug,category.category_type as category_type, 
                category.category_description as category_description,category.category_parent_id as parent_id, category.category_is_delete as category_is_delete,
                category_parent.category_id as category_parent_id,category.category_thumbnail as parent_thumbnail, category_parent.category_name as parent_name, category_parent.category_slug as parent_slug,
                category.category_parent_id as grand_parent_id,
                category_parent.category_type as parent_type, category_parent.category_description as parent_description, category_parent.category_is_delete as parent_is_delete'
            )
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('category.category_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('category_parent.category_name', 'LIKE', '%' . $filter->search . '%')
                         ->orWhere('category.category_slug', 'LIKE', '%' . $filter->search . '%')
                         ->orWhere('category_parent.category_slug', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('category.category_type', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(isset($filter->category_is_delete), function ($query) use ($filter) {
                if ($filter->category_is_delete !== 'all') {
                    $query->where('category.category_is_delete', $filter->category_is_delete);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy('category.' . $filter->orderBy, $filter->orderDirection);
            });

        return $data;
    }
}