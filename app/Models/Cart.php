<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'cart_id';
    const CREATED_AT = 'cart_created_at';
    const UPDATED_AT = 'cart_updated_at';
    protected $fillable = [
        'cart_id',
        'user_id',
        'product_id',
        'cart_quantity',
        'cart_created_at',
        'cart_updated_at',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
