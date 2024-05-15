<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterPerkiraan;
use App\Models\TransaksiAkuntansiJurnalHeader;

class BukuBesarController extends Controller
{
    public function index(){

        $perkiraan = MasterPerkiraan::where('status', 'AKTIF')->get();

        return view('buku-besar.index', compact('perkiraan'));
    }

    public function store(Request $request){

        $tanggal_awal   = $request->tanggal_awal;
        $tanggal_akhir  = $request->tanggal_akhir;
        $perkiraan      = $request->id_perkiraan;

        return redirect()->route('buku-besar.view', ['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 
            'perkiraan' => $perkiraan]);
    }

    public function view($tanggal_awal, $tanggal_akhir, $perkiraan){

        $header_perkiraan = TransaksiAkuntansiJurnalDetail::where('id_perkiraan', $perkiraan)
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();

        return view('buku-besar.index', compact('perkiraan'));
    }

}
