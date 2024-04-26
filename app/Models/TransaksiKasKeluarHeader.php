<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKasKeluarHeader extends Model
{
    use HasFactory;

    protected $table = 'transaksi_kas_keluar_header';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'no_keluar',
        'divisi',
        'pembayaran',
        'keterangan',
        'amount_total',
        'flag_cetak',
        'flag_batal',
        'trx_date',
        'status', 
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public static function no_keluar()
    {
        $now            = Carbon::now();
        $currentYear    = $now->year;
        $currentMonth   = $now->format('m');

        $latestRecord = static::orderBy('no_keluar', 'desc')->first();

        if ($latestRecord) {
            $lastCustomId   = $latestRecord->no_keluar;
            $lastYear       = substr($lastCustomId, 4, 4);
            $lastMonth      = substr($lastCustomId, 8, 2);
            $lastNumber     = (int)substr($lastCustomId, -5);

            if ($lastYear == $currentYear && $lastMonth == $currentMonth) {
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
        } else {
            $newNumber = 1;
        }

        $newCustomId = 'KLR-' . $currentYear . $currentMonth . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newCustomId;
    }

    public function details_keluar()
    {
        return $this->hasMany(TransaksiKasKeluarDetails::class, 'no_keluar', 'no_keluar');
    }

    public function jurnal_header()
    {
        return $this->hasOne(TransaksiAkuntansiJurnalHeader::class, 'trx_from', 'no_keluar');
    }
}
