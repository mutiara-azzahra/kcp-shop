<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiInvoiceDetails extends Model
{
    use HasFactory;

    protected $table = 'transaksi_invoice_details';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'noinv', 'area_inv', 'kd_outlet', 'part_no', 'nm_part', 'qty', 'hrg_pcs', 'disc', 'nominal', 'nominal_disc', 'nominal_disc_ppn',
        'nominal_total', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function nama_part()
    {
        return $this->hasOne(MasterPart::class, 'part_no', 'part_no');
    }

    public function header()
    {
        return $this->hasOne(TransaksiInvoiceHeader::class, 'noinv', 'noinv');
    }

    public function nama_outlet()
    {
        return $this->hasOne(MasterOutlet::class, 'kd_outlet', 'kd_outlet');
    }

}
