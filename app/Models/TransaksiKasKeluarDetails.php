<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKasKeluarDetails extends Model
{
    use HasFactory;

    protected $table = 'transaksi_kas_keluar_details';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [ 
        'no_keluar', 'perkiraan', 'akuntansi_to', 'total', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function details_perkiraan()
    {
        return $this->belongsTo(MasterPerkiraan::class, 'perkiraan', 'id_perkiraan');
    }

    public function header_keluar()
    {
        return $this->hasOne(TransaksiKasKeluarHeader::class, 'no_keluar', 'no_keluar');
    }

}
