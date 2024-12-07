<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_id';
    const CREATED_AT = 'order_created_at';
    const UPDATED_AT = 'order_updated_at';
    protected $fillable = [
        'order_id',
        'user_id',
        'receiver_address_id',
        'order_total_amount',
        'order_status',
        'order_note',
        'order_created_at',
        'order_updated_at',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function receiverAddress(){
        return $this->belongsTo(ReceiverAddress::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
    public function delivery(){
        return $this->hasOne(Delivery::class);
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
