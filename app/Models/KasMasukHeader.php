<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasukHeader extends Model
{
    use HasFactory;

    protected $table = 'kas_masuk_header';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'no_kas_masuk',
        'no_piutang',
        'id_transfer',
        'tanggal_rincian_tagihan',
        'kd_area',
        'kd_outlet',
        'nominal',
        'pembayaran_via',
        'no_bg',
        'jatuh_tempo_bg',
        'flag_transfer_masuk',
        'bank',
        'flag_potong_bonus',
        'nominal_bonus',
        'flag_kas_manual',
        'terima_dari',
        'keterangan',
        'status',
        'flag_batal',
        'trx_date',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public static function no_kas_masuk()
    {
        $now            = Carbon::now();
        $currentYear    = $now->year;
        $currentMonth   = $now->format('m');

        $latestRecord = static::orderBy('no_kas_masuk', 'desc')->first();

        if ($latestRecord) {
            $lastCustomId   = $latestRecord->no_kas_masuk;
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

        $newCustomId = 'KAS-' . $currentYear . $currentMonth . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newCustomId;
    }

    public function harga_het()
    {
        return $this->belongsTo(MasterPartNon::class, 'part_no', 'part_no');
    }

    public function details()
    {
        return $this->hasMany(KasMasukDetails::class, 'no_kas_masuk', 'no_kas_masuk');
    }

    public function outlet()
    {
        return $this->hasOne(MasterOutlet::class, 'kd_outlet', 'kd_outlet');
    }

    public function jurnal_header()
    {
        return $this->belongsTo(TransaksiAkuntansiJurnalHeader::class, 'no_kas_masuk', 'trx_from');
    }
}
