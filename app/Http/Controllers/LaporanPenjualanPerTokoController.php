<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\TransaksiInvoiceHeader;

class LaporanPenjualanPerTokoController extends Controller
{
    public function index(){

        return view('laporan-penjualan-toko.index');
    }

    public function view(Request $request){

        $tanggal_awal       = $request->tanggal_awal;
        $tanggal_akhir_req  = $request->tanggal_akhir;

        $date               = Carbon::parse($tanggal_akhir_req);
        $tanggal_akhir      = $date->addDay()->toDateString();

        $invoice = TransaksiInvoiceHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
        
        dd($tanggal_akhir);

        return view('laporan-penjualan-toko.index', compact('invoice'));
    }
}
