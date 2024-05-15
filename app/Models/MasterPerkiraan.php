<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPerkiraan extends Model
{
    use HasFactory;

    protected $table        = 'master_perkiraan';
    protected $primaryKey   = 'id';

    protected $fillable = [
        'nm_perkiraan', 'id_perkiraan', 'perkiraan', 'nm_sub_perkiraan', 'sub_perkiraan', 'flag_head', 
        'head_kategori', 'kategori', 'keterangan', 'saldo', 'sts_perkiraan', 'status', 
        'created_at', 'created_by', 'updated_at', 'updated_by'
        
    ];

    public function details_keluar()
    {
        return $this->hasMany(TransaksiKasKeluarDetails::class, 'id_perkiraan', 'perkiraan');
    }
}
