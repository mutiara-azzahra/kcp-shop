<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransaksiPembayaranPiutang extends Model
{

    use HasFactory;

    protected $table        = 'transaksi_pembayaran_piutang';
    protected $primaryKey   = 'id';

    protected $fillable = [ 
    'noinv', 'no_piutang', 'kd_outlet', 'nm_outlet', 'nominal', 'pembayaran_via', 'keterangan', 
    'no_bg', 'jatuh_tempo_bg', 'id_bank', 'flag_cetak_kwitansi', 'flag_cetak_kwitansi_date', 
    'no_kas_masuk', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function invoice()
    {
        return $this->hasOne(TransaksiInvoiceHeader::class, 'noinv', 'noinv');
    }

}
