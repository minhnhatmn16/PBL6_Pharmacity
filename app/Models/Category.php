<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';
    const CREATED_AT = 'category_created_at';
    const UPDATED_AT = 'category_updated_at';
    protected $fillable = [
        'category_name',
        'category_slug',
        'category_thumbnail',
        'category_parent_id',
        'category_type',
        'category_description',
        'category_is_delete',
        'category_created_at',
        'category_updated_at',
    ];
    //Quan hệ vớI Product
    public function products(){
        return $this->hasMany(Product::class);
    }
    //Quan hệ n-n với Disease
    public function diseases(){
        return $this->belongsToMany(Disease::class);
    }
    //Quan hệ với bảng Category(lấy danh mục cha)
    public function parentCategory(){
        return $this->belongsTo(Category::class,'category_parent_id');
    }
    //Quan hệ với bảng Category(lấy danh mục con)
    public function childCategories(){
        return $this->hasMany(Category::class,'category_parent_id');
    }

}
