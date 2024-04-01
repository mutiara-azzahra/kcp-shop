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

        if($produk == 1){

            $getAmount = 0;

            //ICHIDAI
            foreach ($invoices as $i) {
                $getAmount += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('level_2', 'IC2');
                    })->sum('nominal_total');
            }

        } elseif($produk == 2) {

            $getAmount    = 0;
        
            //BRIO
            foreach ($invoices as $i) {
                $getAmount += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('level_2', 'BP2');
                    })->sum('nominal_total');
            }
        } elseif($produk == 3){

            $getAmount  = 0;
        
            //LIQUID
            foreach ($invoices as $i) {
                $getAmount += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('level_2', 'LQ2');
                    })->sum('nominal_total');
            }
        } elseif($produk == 4){

            $getAmount  = 0;
        
            //LIQUID
            foreach ($invoices as $i) {
                $getAmount += $i->details_invoice()->sum('nominal_total');
            }

        }

        return view('laporan-penjualan-produk.view', compact('getAmount', 'tanggal_awal', 'tanggal_akhir'));
    }
}
