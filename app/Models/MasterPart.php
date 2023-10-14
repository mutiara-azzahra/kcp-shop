<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPart extends Model
{
    use HasFactory;

    protected $table = 'master_part';
    protected $primaryKey = 'id';

    protected $fillable = [
        'part_no', 'part_nama', 'het', 'satuan_dus', 'id_grup', 'id_rak', 'status', 
        'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
