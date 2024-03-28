<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDiskonDbp extends Model
{
    use HasFactory;

    protected $table = 'master_diskon_dbp';
    protected $primaryKey = 'id';

    protected $fillable = [
        'part_no', 'diskon_dbp', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}