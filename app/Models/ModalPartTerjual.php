<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalPartTerjual extends Model
{

    use HasFactory;

    protected $table = 'modal_part_terjual';
    protected $primaryKey = 'id';

    protected $fillable = [
        'noinv', 
        'part_no',
        'tanggal_invoice',
        'qty_awal',
        'qty_terjual',
        'qty_akhir',
        'modal',
        'nominal_modal',
        'status',
        'create_at',
        'update_at',
        'created_by', 
        'updated_by'
    ];
}
