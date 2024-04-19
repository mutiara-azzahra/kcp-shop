<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterProduk;
use App\Models\MasterPart;
use App\Models\MasterSubProduk;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiInvoiceDetails;

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
        $level_2            = $request->kode_produk;
        $level_4            = $request->sub_produk;

        $date               = Carbon::parse($tanggal_akhir_req);
        $tanggal_akhir      = $date->addDay()->toDateString();

        $invoices = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();

        $nama_produk    = '';
        $sub_produk     = MasterSubProduk::where('sub_produk', $level_4)->value('keterangan');

        if($level_2 == 'ICH'){
            $nama_produk = 'ICHIDAI';

            $part   = MasterPart::where('level_2', 'IC2')->where('level_4', $level_4)->pluck('part_no')->toArray();
            $flattened  = collect($part)->flatten()->toArray();

            $invoicesIchidai = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();

            $partNumbers = [];

            foreach ($invoicesIchidai as $invoice) {
                $partNumbers[$invoice->part_no] = $invoice->sum('nominal_total');
            }
        } elseif($level_2 == 'BRI'){

            $nama_produk = 'BRIO';

            $part   = MasterPart::where('level_2', 'BP2')->where('level_4', $level_4)->pluck('part_no')->toArray();
            $flattened  = collect($part)->flatten()->toArray();

            $invoicesIchidai = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();

            $partNumbers = [];

            foreach ($invoicesIchidai as $invoice) {
                $partNumbers[$invoice->part_no] = $invoice->sum('nominal_total');
            }
        } elseif($level_2 == 'LIQ'){

            $nama_produk = 'LIQUID';

            $part   = MasterPart::where('level_2', 'LQ2')->where('level_4', $level_4)->pluck('part_no')->toArray();
            $flattened  = collect($part)->flatten()->toArray();

            $invoicesIchidai = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();

            $partNumbers = [];

            foreach ($invoicesIchidai as $invoice) {
                $partNumbers[$invoice->part_no] = $invoice->sum('nominal_total');
            }
        }

        return view('laporan-kelompok-produk.view', compact('partNumbers','nama_produk','invoicesIchidai', 'flattened'));
    }
}
