<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDisease extends Model
{
    use HasFactory;
    protected $primaryKey='category_disease_id';
    public $timestamps = false;
    protected $fillable = [
        'category_id',
        'disease_id',
        'disease_name',
        'disease_thumbnail'
    ];
}
