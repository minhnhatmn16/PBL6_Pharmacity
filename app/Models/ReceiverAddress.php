<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverAddress extends Model
{
    use HasFactory;
    protected $primaryKey = 'receiver_address_id';
    const CREATED_AT = 'receiver_created_at';
    const UPDATED_AT = 'receiver_updated_at';
    protected $fillable = [
        'receiver_address_id',
        'user_id',
        'receiver_name',
        'receiver_phone',
        'province_id',
        'district_id',
        'ward_id',
        'receiver_address',
        'receiver_created_at',
        'receiver_updated_at',
        'receiver_addresses_delete',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function province(){
        return $this->belongsTo(Province::class);
    }
    public function district(){
        return $this->belongsTo(District::class);
    }
    public function ward(){
        return $this->belongsTo(Ward::class);
    }
}
