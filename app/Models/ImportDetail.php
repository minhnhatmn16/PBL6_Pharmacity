<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'import_detail_id';
    public $timestamps = false;
    protected $fillable = [
        'import_detail_id',
        'import_id',
        'product_id',
        'import_quantity',
        'retaining_quantity',
        'import_price',
        'product_total_price',
        'product_expiry_date',
        'entry_date'
    ];
    public function import(){
        return $this->belongsTo(Import::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }
}
