<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterProduk;
use App\Models\MasterSubProduk;
use App\Models\TransaksiInvoiceHeader;

class LaporanPenjualanKelompokProdukController extends Controller
{
    public function index(){

        $all_produk = MasterProduk::where('status', 'A')->get();

        return view('laporan-kelompok-produk.index', compact('all_produk'));
    }

    public function api($id)
    {
        $data = MasterSubProduk::where('kode_produk', $id)->get();

        return $data;
    }

    public function view(Request $request){

        $sub_produk         = $request->sub_produk;
        $tanggal_awal       = $request->tanggal_awal;
        $tanggal_akhir_req  = $request->tanggal_akhir;

        $date               = Carbon::parse($tanggal_akhir_req);
        $tanggal_akhir      = $date->addDay()->toDateString();

        $invoices = TransaksiInvoiceHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();

        $map_invoice = $invoices->groupBy('kd_outlet');



        $amount_toko = $map_invoice->map(function ($outletInvoices) use ($sub_produk) {
            return $outletInvoices->sum(function ($invoice) use ($sub_produk) {
                return $invoice->details_invoice()->whereIn('part_no', function ($query) use ($sub_produk) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('level_4', $sub_produk);
                })->sum('nominal_total');
            });
        });

        $nama_sub_produk = MasterSubProduk::where('sub_produk', $sub_produk)->first();


        return view('laporan-kelompok-produk.view', compact('amount_toko', 'map_invoice', 'nama_sub_produk','tanggal_awal', 'tanggal_akhir'));
    }
}
