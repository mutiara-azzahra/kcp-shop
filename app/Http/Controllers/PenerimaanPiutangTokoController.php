<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenerimaanPiutangTokoController extends Controller
{
    public function index(){

        $piutang_header      = TransaksiPembayaranPiutangHeader::all();

        return view('penerimaan-piutang-toko.index', compact('piutang_header'));
    }
    
}
