<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKodeRak extends Model
{
    use HasFactory;

    protected $table = 'kode_rak_lokasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_rak_lokasi', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
