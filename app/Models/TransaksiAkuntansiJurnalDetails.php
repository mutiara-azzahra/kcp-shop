<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAkuntansiJurnalDetails extends Model
{
    use HasFactory;

    protected $table = 'transaksi_akuntansi_jurnal_details';
    public $primaryKey = 'id';

    protected $fillable = [
        'id_header', 
        'perkiraan',
        'debet',
        'kredit',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function details_perkiraan()
    {
        return $this->belongsTo(MasterPerkiraan::class, 'perkiraan', 'id_perkiraan');
    }

}
