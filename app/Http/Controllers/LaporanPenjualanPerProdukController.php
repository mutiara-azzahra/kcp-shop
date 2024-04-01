<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TransaksiInvoiceHeader;

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

        $invoices = TransaksiInvoiceHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
        ->get();

        $getAmountIchidai = 0;
        $getAmountBrio    = 0;
        $getAmountLiquid  = 0;

        //ICHIDAI
        foreach ($invoices as $i) {
            $getAmountIchidai += $i->details_invoice()->whereIn('part_no', function ($query) {
                $query->select('part_no')
                    ->from('master_part')
                    ->where('level_2', 'IC2');
                })->sum('nominal_total');
        }
        
        //BRIO
        foreach ($invoices as $i) {
            $getAmountBrio += $i->details_invoice()->whereIn('part_no', function ($query) {
                $query->select('part_no')
                    ->from('master_part')
                    ->where('level_2', 'BP2');
                })->sum('nominal_total');
        }

        //LIQUID
        foreach ($invoices as $i) {
            $getAmountLiquid += $i->details_invoice()->whereIn('part_no', function ($query) {
                $query->select('part_no')
                    ->from('master_part')
                    ->where('level_2', 'LQ2');
                })->sum('nominal_total');
        }

        return view('laporan-penjualan-produk.view', compact('getAmountIchidai','getAmountBrio', 'getAmountLiquid', 'tanggal_awal', 'tanggal_akhir'));
    }
}
