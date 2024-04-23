<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupPerkiraan extends Model
{
    use HasFactory;

    protected $table = 'setup_perkiraan';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'tahun', 'bulan', 'id_perkiraan', 'saldo', 'status','created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
