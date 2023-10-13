<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPerkiraan extends Model
{
    use HasFactory;

    protected $table = 'master_perkiraan';
    protected $primaryKey = 'id';


    protected $fillable = [
        'nm_perkiraan', 'perkiraan', 'nm_sub_perkiraan', 'sub_perkiraan', 'flag_head', 
        'head_kategori', 'kategori', 'keterangan', 'saldo', 'sts_perkiraan', 'status', 
        'crea_date', 'crea_by', 'modi_date', 'modi_by'
    ];
}
