<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiInvoiceDetails;

class LaporanPenjualanPerTokoController extends Controller
{
    public function index(){

        $all_toko = MasterOutlet::where('status', 'Y')->get();

        return view('laporan-penjualan-toko.index', compact('all_toko'));
    }

    public function view(Request $request){

        $produk             = $request->produk;
        $tanggal_awal       = $request->tanggal_awal;
        $tanggal_akhir_req  = $request->tanggal_akhir;

        $date               = Carbon::parse($tanggal_akhir_req);    
        $tanggal_akhir      = $date->addDay()->toDateString();

        $produkNames = [
            1 => 'ICHIDAI',
            2 => 'BRIO',
            3 => 'LIQUID',
            4 => 'ALL PRODUK',
        ];

        $invoices = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();

        $uniqueMonths = [];

        foreach ($nominal_perbulan as $invoicesByMonth) {
            foreach ($invoicesByMonth as $month => $invoices) {
                $uniqueMonths[$month] = \Carbon\Carbon::parse($month)->format('M Y');
            }
        }

        return view('laporan-penjualan-toko.view',  compact('uniqueMonths', 'nominal_perbulan', 'produk',
            'map_invoice', 'invoices', 'produk',  'nominal_perbulan'));
    }
}
