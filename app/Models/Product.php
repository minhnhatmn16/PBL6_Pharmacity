<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';
    protected $fillable = [
        'product_id',
        'brand_id',
        'category_id',
        'product_name',
        'product_slug',
        'product_price',
        'product_discount',
        'product_images',
        'product_quantity',
        'product_sold',
        'product_package',
        'product_ingredients',
        'dosage_form',
        'product_uses',
        'specification',
        'product_notes',
        'place_of_manufacture',
        'manufacturer',
        'product_description',
        'product_is_delete',
        'product_created_at',
        'product_updated_at',
    ];
    protected $casts = [
        'product_images' => 'array',
    ];
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
    public function carts(){
        return $this->hasMany(Cart::class);
    }
    public function importDetails(){
        return $this->hasMany(ImportDetail::class);
    }
}
