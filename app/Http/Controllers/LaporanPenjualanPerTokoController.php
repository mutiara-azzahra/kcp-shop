<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;
use App\Models\MasterPart;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiInvoiceDetails;

class LaporanPenjualanPerTokoController extends Controller
{
    public function index(){

        $all_toko = MasterOutlet::where('status', 'Y')->get();

        return view('laporan-penjualan-toko.index', compact('all_toko'));
    }

    public function view(Request $request){

        $produk         = $request->produk;
        $tanggal_awal   = $request->tanggal_awal;
        $tanggal_akhir  = $request->tanggal_akhir;

        // $date               = Carbon::parse($tanggal_akhir_req);    
        // $tanggal_akhir      = $date->addDay()->toDateString();

        $kode_produk = [
            1 => 'ICHIDAI',
            2 => 'BRIO',
            3 => 'LIQUID',
            4 => 'ALL PRODUK',
        ];

        $nama_produk = '';

        if($produk == 1){
            $nama_produk = 'ICHIDAI';

            $partIchidai  = MasterPart::where('level_2', 'IC2')->pluck('part_no')->toArray();
            $flattened    = collect($partIchidai)->flatten()->toArray();

            $invoicesIchidai = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                    ->whereIn('part_no', $flattened)
                    ->get();

            $invoicesIchidaiGrouped = $invoicesIchidai->groupBy('kd_outlet');

            $sumNominal = [];

            foreach ($invoicesIchidaiGrouped as $kd_outlet => $details) {
                $detailsByMonth = $details->groupBy(function ($item) {
                    return $item->created_at->format('Y-m');
                });
            
                $sumNominal[$kd_outlet] = $detailsByMonth->map(function ($monthDetails) {
                    return $monthDetails->sum('nominal_total');
                });
            }

        }elseif($produk == 2){
            $nama_produk = 'BRIO';

            $partBrio  = MasterPart::where('level_2', 'BP2')->pluck('part_no')->toArray();
            $flattened    = collect($partBrio)->flatten()->toArray();

            $invoicesBrio = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                    ->whereIn('part_no', $flattened)
                    ->get();

            $invoicesBrioGrouped = $invoicesBrio->groupBy('kd_outlet');

            $sumNominal = [];

            foreach ($invoicesBrioGrouped as $kd_outlet => $details) {
                $detailsByMonth = $details->groupBy(function ($item) {
                    return $item->created_at->format('Y-m');
                });
            
                $sumNominal[$kd_outlet] = $detailsByMonth->map(function ($monthDetails) {
                    return $monthDetails->sum('nominal_total');
                });
            }

        }elseif($produk == 3){
            $nama_produk = 'LIQUID';

            $partLiquid  = MasterPart::where('level_2', 'LQ2')->pluck('part_no')->toArray();
            $flattened    = collect($partLiquid)->flatten()->toArray();

            $invoicesLiquid = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                    ->whereIn('part_no', $flattened)
                    ->get();

            $invoicesLiquidGrouped = $invoicesLiquid->groupBy('kd_outlet');

            $sumNominal = [];

            foreach ($invoicesLiquidGrouped as $kd_outlet => $details) {
                $detailsByMonth = $details->groupBy(function ($item) {
                    return $item->created_at->format('Y-m');
                });
            
                $sumNominal[$kd_outlet] = $detailsByMonth->map(function ($monthDetails) {
                    return $monthDetails->sum('nominal_total');
                });
            }

        }elseif($produk == 4){
            $nama_produk = 'ALL PRODUK';

            $invoicesLiquid = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                    ->get();

            $invoicesLiquidGrouped = $invoicesLiquid->groupBy('kd_outlet');

            $sumNominal = [];

            foreach ($invoicesLiquidGrouped as $kd_outlet => $details) {
                $detailsByMonth = $details->groupBy(function ($item) {
                    return $item->created_at->format('Y-m');
                });
            
                $sumNominal[$kd_outlet] = $detailsByMonth->map(function ($monthDetails) {
                    return $monthDetails->sum('nominal_total');
                });
            }
        }

        return view('laporan-penjualan-toko.view',  compact('sumNominal' ,'nama_produk', 'produk', 'tanggal_awal', 'tanggal_akhir'));
    }
}
