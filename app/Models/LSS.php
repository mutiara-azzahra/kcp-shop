<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LSS extends Model
{
    use HasFactory;

    protected $table = 'lss';
    protected $primaryKey = 'id';

    protected $fillable = [
        'bulan',
        'tahun',
        'sub_kelompok_part',
        'produk_part',
        'awal_amount',
        'beli',
        'jual_rbp',
        'jual_dbp',
        'akhir_amount',
        'status', 
        'create_at',
        'update_at',
        'created_by', 
        'updated_by'
    ];

    public function level_4()
    {
        return $this->hasOne(MasterLevel4::class, 'level_4', 'sub_kelompok_part');
    }
}
