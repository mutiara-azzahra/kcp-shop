<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAreaOutlet extends Model
{
    use HasFactory;

    protected $table      = 'master_area_outlet';
    public $timestamps    = false;

    protected $fillable = [
        'kode_prp',
        'kode_kab',
        'nm_area',
        'status', 
        'crea_date',
        'modi_date',
        'crea_by', 
        'modi_by'
    ];

}
