<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProdukNon extends Model
{
    use HasFactory;

    protected $table = 'master_produk';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_part',
        'status',
        'create_at',
        'update_at',
        'created_by', 
        'updated_by'
    ];
}
