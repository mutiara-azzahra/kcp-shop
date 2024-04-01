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

        $produkNames = [
            1 => 'ICHIDAI',
            2 => 'BRIO',
            3 => 'LIQUID',
            4 => 'ALL PRODUK',
        ];
        
        $nama_produk = $produkNames[$produk] ?? 'Unknown';

        $map_invoice = $invoices->groupBy('kd_outlet');

        if($produk == 1){

            $amount_toko = $map_invoice->map(function ($outletInvoices) {
                return $outletInvoices->sum(function ($invoice) {
                    return $invoice->details_invoice()->whereIn('part_no', function ($query) {
                        $query->select('part_no')
                            ->from('master_part')
                            ->where('level_2', 'IC2');
                    })->sum('nominal_total');
                });
            });

        } elseif($produk == 2) {

            $amount_toko = $map_invoice->map(function ($outletInvoices) {
                return $outletInvoices->sum(function ($invoice) {
                    return $invoice->details_invoice()->whereIn('part_no', function ($query) {
                        $query->select('part_no')
                            ->from('master_part')
                            ->where('level_2', 'BP2');
                    })->value('nominal_total');
                });
            });

        } elseif($produk == 3){

            $amount_toko = $map_invoice->map(function ($outletInvoices) {
                return $outletInvoices->sum(function ($invoice) {
                    return $invoice->details_invoice()->whereIn('part_no', function ($query) {
                        $query->select('part_no')
                            ->from('master_part')
                            ->where('level_2', 'LQ2');
                    })->value('nominal_total');
                });
            });

        } elseif($produk == 4){

            $amount_toko = $map_invoice->map(function ($outletInvoices) {
                return $outletInvoices->sum(function ($invoice) {
                    return $invoice->details_invoice()->value('nominal_total');
                });
            });

        }

        return view('laporan-penjualan-produk.view', compact('amount_toko', 'map_invoice', 'nama_produk' ,'tanggal_awal', 'tanggal_akhir'));
    }
}
