<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $primaryKey = 'brand_id';
    const CREATED_AT = 'brand_created_at';
    const UPDATED_AT = 'brand_updated_at';
    protected $fillable = [
        'brand_id',
        'brand_name',
        'brand_slug',
        'brand_logo',
        'brand_description',
        'brand_is_delete',
        'brand_created_at',
        'brand_updated_at',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
