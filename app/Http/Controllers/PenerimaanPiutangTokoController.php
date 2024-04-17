<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use PDF;
use App\Models\TransaksiPembayaranPiutangHeader;

class PenerimaanPiutangTokoController extends Controller
{
    public function index(){

        $piutang_header      = TransaksiPembayaranPiutangHeader::all();

        return view('penerimaan-piutang-toko.index', compact('piutang_header'));
    }

    public function cetak($no_piutang)
    {
        $data               = TransaksiPembayaranPiutangHeader::where('no_piutang', $no_piutang)->first();
        $pdf                = PDF::loadView('reports.bukti-terima-piutang', ['data'=>$data]);
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream('penerimaan-piutang.pdf');
    }
    
    
}
