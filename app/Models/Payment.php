<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'payment_id';
    const CREATED_AT = 'payment_created_at';
    const UPDATED_AT = 'payment_updated_at';
    protected $fillable = [
        'payment_id',
        'order_id',
        'payment_method_id',
        'payment_amount',
        'payment_status',
        'payment_at',
        'payment_created_at',
        'payment_updated_at',
    ];
    public $timestamps = false;
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }
}
