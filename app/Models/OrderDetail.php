<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_detail_id';
    protected $fillable = [
        'order_detail_id',
        'order_id',
        'product_id',
        'import_detail_id',
        'order_quantity',
        'order_price',
        'order_price_discount',
        'order_total_price'
    ];
    public $timestamps = false;
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function importDetail(){
        return $this->belongsTo(ImportDetail::class);
    }
}
