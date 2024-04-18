<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubProduk extends Model
{
    use HasFactory;

    protected $table = 'master_sub_produk_part';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sub_produk',
        'keterangan',
        'kode_produk',
        'status',
        'created_at',
        'updated_at',
        'created_by', 
        'updated_by'
    ];

    public function produk(){
        return $this->belongsTo(MasterProduk::class, 'kode_produk', 'kode_produk');
    }

    public function part(){
        return $this->hasMany(MasterPart::class, 'sub_produk', 'level_4');
    }

}
