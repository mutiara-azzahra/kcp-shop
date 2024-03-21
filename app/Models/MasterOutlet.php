<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterOutlet extends Model
{
    use HasFactory;

    protected $table = 'master_outlet';

    protected $fillable = [
        'kd_outlet', 'nm_pemilik', 'nm_outlet', 'almt_outlet', 'almt_pengiriman', 'kode_prp', 'kode_kab', 'flag_2w', 'area_group_2w', 'flag_4w', 
        'area_group_4w', 'type_toko', 'tlpn', 'email', 'flag_npwp', 'no_npwp', 'flag_pkp', 'kode_bank', 'nm_bank', 'no_rek', 'jth_tempo', 'expedisi', 
        'nik', 'status', 'crea_date', 'crea_by', 'modi_date', 'modi_by'
    ];

    public function area()
    {
        return $this->hasOne(MasterArea::class, 'kode_kab', 'kode_kab');
    }

    public function area_outlet()
    {
        return $this->hasOne(MasterAreaOutlet::class, 'kode_kab', 'kode_kab');
    }

    public function kode_area()
    {
        return $this->belongsTo(MasterKodeArea::class, 'kode_kab', 'kode_kab');
    }

    public function lkh()
    {
        return $this->hasMany(TransaksiLKHDetails::class, 'kd_outlet', 'kd_outlet');
    }

    public function plafond()
    {
        return $this->hasOne(TransaksiPlafond::class, 'kd_outlet', 'kd_outlet');
    }

    public function area_sales()
    {
        return $this->belongsTo(MasterAreaSales::class, 'kode_kabupaten', 'kode_kab');
    }

}
