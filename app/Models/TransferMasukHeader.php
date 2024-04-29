<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferMasukHeader extends Model
{
    use HasFactory;

    protected $table = 'trns_transfer_header';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id_transfer',
        'status_transfer',
        'tanggal_bank',
        'bank',
        'kd_outlet',
        'keterangan',
        'flag_by_toko',
        'catatan',
        'status',
        'flag_kas_ar',
        'flag_batal',
        'flag_batal_date',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public static function id_transfer()
    {
        $now            = Carbon::now();
        $currentYear    = $now->year;
        $currentMonth   = $now->format('m');

        $latestRecord = static::orderBy('id_transfer', 'desc')->first();

        if ($latestRecord) {
            $lastCustomId   = $latestRecord->id_transfer;
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

        $newCustomId = 'TRF-' . $currentYear . $currentMonth . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newCustomId;
    }

    public function details()
    {
        return $this->hasMany(TransferMasukDetails::class, 'id_transfer', 'id_transfer');
    }

    public function kas_masuk()
    {
        return $this->hasOne(KasMasukHeader::class, 'id_transfer', 'id_transfer');
    }

    public function jurnal_header()
    {
        return $this->belongsTo(TransaksiAkuntansiJurnalHeader::class, 'no_keluar', 'trx_from');
    }

    public function outlet()
    {
        return $this->belongsTo(MasterOutlet::class, 'keterangan', 'ke');
    }
}
