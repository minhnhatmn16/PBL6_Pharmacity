<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    use HasFactory;

    protected $primaryKey = 'review_id';
    const CREATED_AT = 'review_created_at';
    const UPDATED_AT = 'review_updated_at';
    protected $fillable = [
        'review_id',
        'user_id',
        'order_id',
        'product_id',
        'review_rating',
        'review_images',
        'review_comment',
        'is_approved',
        'review_created_at',
        'review_updated_at',
    ];
    protected $casts = [
        'review_images' => 'array',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
