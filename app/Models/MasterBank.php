<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBank extends Model
{

    use HasFactory;

    protected $table = 'master_bank';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_bank',
        'nama_bank', 
        'status',
        'create_at',
        'update_at',
        'created_by', 
        'updated_by'
    ];
}
