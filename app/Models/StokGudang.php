<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokGudang extends Model
{
    use HasFactory;

    protected $table = 'stok_part';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'invoice_non', 'id_rak','part_no' ,'stok' ,'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

}