<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLevel4 extends Model
{
    use HasFactory;
    protected $table = 'master_level_4';
    protected $primaryKey = 'id';

    protected $fillable = [
        'level_4', 
        'keterangan',
        'id_level_2',
        'create_at',
        'update_at',
        'created_by', 
        'updated_by'
    ];

}
