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
use App\Models\InvoiceNonHeader;

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

        $date  = Carbon::parse($awal);
        $bulan = $date->format('m');
        $tahun = $date->format('Y');

        $check = ModalPartTerjual::where('bulan', $bulan)->where('tahun', $tahun)->first();

        if(isset($check)){

             return redirect()->route('modal.index')->with('warning','Data modal bulan '. $bulan.'-'. $tahun.' sudah ada.');

        } else {

            $tanggal_awal   = Carbon::parse($awal);
            $tanggal_akhir  = Carbon::parse($akhir)->addDays(1);

            $getTerjual = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->get();

            foreach($getTerjual as $i){

                $getDiskonDbp = MasterDiskonDbp::where('part_no', $i->part_no)->value('diskon_dbp');
                
                $value = [
                    'bulan'           => $bulan,
                    'tahun'           => $tahun,
                    'noinv'           => $i->noinv,
                    'tanggal_invoice' => $i->created_at,
                    'part_no'         => $i->part_no,
                    'qty_terjual'     => $i->qty,
                    'modal'           => $i->hrg_pcs * (100 - $getDiskonDbp) / 100,
                    'nominal_modal'   => $i->qty * $i->hrg_pcs * (100 - $getDiskonDbp) / 100,
                    'status'          => 'A',
                    'created_by'      => Auth::user()->nama_user,
                ];

                $created = ModalPartTerjual::create($value);

            }

            return redirect()->route('modal.index')->with('success','Data Modal baru berhasil ditambahkan!');

        }

    }
}
