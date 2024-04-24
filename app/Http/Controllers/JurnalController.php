<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAkuntansiJurnalHeader;
use App\Models\TransaksiAkuntansiJurnalDetails;

class JurnalController extends Controller
{
    public function index(){

        return view('jurnal.index');
    }

    public function store(Request $request){

        $tanggal_awal   = $request->tanggal_awal;
        $tanggal_akhir  = $request->tanggal_akhir;

        $jurnal_header  = TransaksiAkuntansiJurnalHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();

        return view('jurnal.view', compact('jurnal_header'));
    }
}
