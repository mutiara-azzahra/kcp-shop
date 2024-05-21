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
            'tanggal_awal'  => 'required',
            'tanggal_akhir' => 'required',
        ]);

        $awal   = $request->tanggal_awal;
        $akhir  = $request->tanggal_akhir;

        $tanggal_awal   = Carbon::parse($awal);
        $tanggal_akhir  = Carbon::parse($akhir)->addDays(1);

        $getTerjual = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();

        foreach($getTerjual as $i){

            $getDiskonDbp = MasterDiskonDbp::where('part_no', $i->part_no)->value('diskon_dbp');
            

            $value = [
                'noinv'           => $i->noinv,
                'tanggal_invoice' => $i->created_at,
                'part_no'         => $i->part_no,
                'qty_terjual'     => $i->qty,
                'modal'           => $i->hrg_pcs,
                'nominal_modal'   => $i->qty * $i->hrg_pcs * (100 - $getDiskonDbp) / 100,
                'status'          => 'A',
                'created_by'      => Auth::user()->nama_user,
            ];

            $created = ModalPartTerjual::create($value);

        }

        return redirect()->route('modal.index')->with('success','Data Modal baru berhasil ditambahkan!');
    }
}
