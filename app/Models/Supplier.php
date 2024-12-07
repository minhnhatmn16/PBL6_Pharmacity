<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $primaryKey='supplier_id';
    const CREATED_AT = 'supplier_created_at';
    const UPDATED_AT = 'supplier_updated_at';
    protected $fillable = [
        'supplier_id',
        'supplier_name',
        'contact_person',
        'supplier_phone',
        'supplier_email',
        'supplier_address',
        'supplier_is_delete',
        'supplier_created_at',
        'supplier_updated_at',
    ];
    public function imports(){
        return $this->hasMany(Import::class);
    }
}
