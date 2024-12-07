<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;
    protected $primaryKey = 'disease_id';
    const CREATED_AT = 'disease_created_at';
    const UPDATED_AT = 'disease_updated_at';
    protected $fillable = [
        'disease_name',
        'disease_thumbnail',
        'general_overview',
        'symptoms',
        'cause',
        'risk_subjects',
        'diagnosis',
        'prevention',
        'treatment_method',
        'disease_is_delete',
        'disease_is_show',
    ];
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
