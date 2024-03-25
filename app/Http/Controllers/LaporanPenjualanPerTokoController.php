<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;
use App\Models\TransaksiInvoiceHeader;

class LaporanPenjualanPerTokoController extends Controller
{
    public function index(){

        $all_toko = MasterOutlet::where('status', 'Y')->get();

        return view('laporan-penjualan-toko.index', compact('all_toko'));
    }

    public function view(Request $request){

        $tanggal_awal       = $request->tanggal_awal;
        $tanggal_akhir_req  = $request->tanggal_akhir;

        $date               = Carbon::parse($tanggal_akhir_req);
        $tanggal_akhir      = $date->addDay()->toDateString();

        // $invoices = TransaksiInvoiceHeader::where('kd_outlet', $request->kd_outlet)->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
        //     ->get()
        //     ->groupBy(function($invoice) {
        //         return Carbon::parse($invoice->created_at)->format('Y-m');
        //     });


        $invoices = TransaksiInvoiceHeader::where('kd_outlet', $request->kd_outlet)
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get()
            ->groupBy(function($invoice) {
                return Carbon::parse($invoice->created_at)->format('Y-m');
            })
            ->map(function ($invoicesInMonth) {
                return $invoicesInMonth->sum(function ($invoice) {
                    return $invoice->details_invoice->sum('nominal_total');
                });
            });

            // dd($invoices);


        return view('laporan-penjualan-toko.view', compact('invoices'));
    }
}
