<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $primaryKey = 'payment_method_id';
    protected $fillable = [
        'payment_method_id',
        'payment_method_name',
        'payment_method_description',
        'payment_method_logo',
        'payment_is_active',
    ];
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
