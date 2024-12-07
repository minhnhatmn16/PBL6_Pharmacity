<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    use HasFactory;
    protected $primaryKey = 'delivery_method_id';
    protected $fillable = [
        'delivery_method_id',
        'delivery_method_name',
        'delivery_fee',
        'delivery_method_description',
        'delivery_method_logo',
        'delivery_is_active',
    ];
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'delivery_method_id');
    }
}
