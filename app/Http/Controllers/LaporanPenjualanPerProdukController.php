<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TransaksiInvoiceDetails;
use App\Models\MasterSubProduk;
use App\Models\MasterPart;

class LaporanPenjualanPerProdukController extends Controller
{
    public function index(){

        return view('laporan-penjualan-produk.index');
    }

    public function view(Request $request){

        $produk             = $request->produk;
        $tanggal_awal       = $request->tanggal_awal;
        $tanggal_akhir_req  = $request->tanggal_akhir;

        $date               = Carbon::parse($tanggal_akhir_req);
        $tanggal_akhir      = $date->addDay()->toDateString();

        $invoices = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();

        $produkNames = [
            1 => 'ICHIDAI',
            2 => 'BRIO',
            3 => 'LIQUID',
            4 => 'ALL PRODUK',
        ];
        

        $partBrio   = MasterPart::where('level_2', 'BP2')->pluck('part_no')->toArray();
        $flattened  = collect($partBrio)->flatten()->toArray();

        $groupBrio  = MasterSubProduk::where('kode_produk', 'BRI')->pluck('sub_produk')->toArray();
        $flattenedGroup  = collect($groupBrio)->flatten()->toArray();

        $invoicesBrio = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();
        
        
        

        dd($amount_toko);

        return view('laporan-penjualan-produk.view', compact('amount_toko', 'map_invoice', 'nama_produk' ,'tanggal_awal', 'tanggal_akhir'));
    }
}
