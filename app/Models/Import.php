<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;
    protected $primaryKey='import_id';
    const CREATED_AT = 'import_created_at';
    const UPDATED_AT = 'import_updated_at';
    protected $fillable = [
        'import_id',
        'supplier_id',
        'import_date',
        'import_total_amount',
        'import_created_at',
        'import_updated_at',
    ];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function importDetails(){
        return $this->hasMany(ImportDetail::class);
    }
}
