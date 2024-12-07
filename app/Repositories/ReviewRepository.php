<?php

namespace App\Repositories;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

/**
 * Interface ExampleRepository.
 */
class ReviewRepository extends BaseRepository implements ReviewInterface
{
    public function getModel()
    {
        return Review::class;
    }
    public static function getAll($filter)
    {
        
        $filter = (object) $filter;
        $data = DB::table('reviews')
            ->select(
                'reviews.*',
                'products.product_name',
                'products.product_images',
                'users.user_fullname',
                'users.user_avatar'
            )
            ->leftJoin('products', 'products.product_id', '=', 'reviews.product_id')
            ->leftJoin('users', 'users.user_id', '=', 'reviews.user_id')
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('review_comment', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(isset($filter->is_approved), function ($query) use ($filter) {
                if ($filter->is_approved !== 'all') {
                    $query->where('is_approved', $filter->is_approved);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            })
            ->when(!empty($filter->product_id), function ($query) use ($filter) {
                $query->where('reviews.product_id', $filter->product_id);
            })
            ->when(!empty($filter->user_id), function ($query) use ($filter) {
                $query->where('reviews.user_id', $filter->user_id);
            })
            ->when(!empty($filter->order_id), function ($query) use ($filter) {
                $query->where('reviews.order_id', $filter->order_id);
            })
            ->when(!empty($filter->review_id), function ($query) use ($filter) {
                $query->where('review_id', $filter->review_id);
            });

        return $data;
    }
}
