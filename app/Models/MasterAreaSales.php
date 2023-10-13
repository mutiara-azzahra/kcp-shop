<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAreaSales extends Model
{
    use HasFactory;

    //kode_kabupaten`, `id_sales


    protected $table = 'master_area_sales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kabupaten',
        'id_sales',
        'status', 
        'create_at',
        'update_at',
        'created_by', 
        'updated_by'
    ];

    public function area()
    {
        return $this->belongsTo(MasterArea::class, 'kode_kabupaten', 'kode_kabupaten');
    }

    public function area_sales()
    {
        return $this->hasOne(MasterSales::class, 'id', 'id_sales');
    }
}
