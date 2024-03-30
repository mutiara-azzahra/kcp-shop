<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPartModal;
use App\Models\TransaksiInvoiceDetails;
use App\Models\ModalPartTerjual;
use App\Models\MasterDiskonDbp;

class ModalDbpController extends Controller
{
    public function index(){

    $getModalDbp = ModalPartTerjual::all();

    return view('modal.index', compact('getModalDbp'));

    }

    public function store(Request $request){

        $request->validate([
            'bulan'         => 'required',
            'tahun'         => 'required',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $getTerjual = TransaksiInvoiceDetails::where('created_at', '>=', $tahun.'-'.$bulan.'-01')
            ->where('created_at', '<=', $tahun.'-'.$bulan.'-'.Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('d'))
            ->get();

        foreach($getTerjual as $i){

            $getDiskonDbp = MasterDiskonDbp::where('part_no', $i->part_no)->value('diskon_dbp');

            $value = [
                'noinv'         => $i->noinv,
                'tanggal_invoice' => $i->created_at,
                'part_no'       => $i->part_no,
                'qty_terjual'   => $i->qty,
                'modal'         => $i->hrg_pcs,
                'nominal_modal' => $i->qty * $i->hrg_pcs * $getDiskonDbp / 100,
                'status'        => 'A',
            ];

            $created = ModalPartTerjual::create($value);

        }

        return redirect()->route('modal.index')->with('success','Data Modal baru berhasil ditambahkan!');
    }

}
