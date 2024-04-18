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

        $kode_produk = [
            1 => 'ICHIDAI',
            2 => 'BRIO',
            3 => 'LIQUID',
            4 => 'ALL PRODUK',
        ];

        $nama_produk = '';

        if($produk == 1){

            $partIchidai   = MasterPart::where('level_2', 'IC2')->pluck('part_no')->toArray();
            $flattened  = collect($partIchidai)->flatten()->toArray();

            $groupIchidai  = MasterSubProduk::where('kode_produk', 'ICH')->pluck('sub_produk')->toArray();
            $flattenedGroup  = collect($groupIchidai)->flatten()->toArray();

            $invoicesIchidai = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();

            $groupedInvoices = $invoicesIchidai->groupBy(function ($invoice) use ($flattenedGroup) {
                    $part = MasterPart::where('part_no', $invoice->part_no)->first();
                    return in_array($part->level_4, $flattenedGroup) ? $part->level_4 : 'Other';
                });

        }else if($produk == 2){

            $partBrio   = MasterPart::where('level_2', 'BP2')->pluck('part_no')->toArray();
            $flattened  = collect($partBrio)->flatten()->toArray();

            $groupBrio  = MasterSubProduk::where('kode_produk', 'BRI')->pluck('sub_produk')->toArray();
            $flattenedGroup  = collect($groupBrio)->flatten()->toArray();

            $invoicesBrio = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();

            $groupedInvoices= $invoicesBrio->groupBy(function ($invoice) use ($flattenedGroup) {
                    $part = MasterPart::where('part_no', $invoice->part_no)->first();
                    return in_array($part->level_4, $flattenedGroup) ? $part->level_4 : 'Other';
                });

        }else if($produk == 3){
            $partLiquid   = MasterPart::where('level_2', 'LQ2')->pluck('part_no')->toArray();
            $flattened  = collect($partLiquid)->flatten()->toArray();

            $groupLiquid  = MasterSubProduk::where('kode_produk', 'LIQ')->pluck('sub_produk')->toArray();
            $flattenedGroup  = collect($groupLiquid)->flatten()->toArray();

            $invoicesLiquid = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('part_no', $flattened)
                ->get();

            $groupedInvoicesBrio = $invoicesLiquid->groupBy(function ($invoice) use ($flattenedGroup) {
                    $part = MasterPart::where('part_no', $invoice->part_no)->first();
                    return in_array($part->level_4, $flattenedGroup) ? $part->level_4 : 'Other';
                });

        }else if($produk == 4){

        }
        

        

        return view('laporan-penjualan-produk.view', compact('groupedInvoicesBrio' ,'tanggal_awal', 'tanggal_akhir'));
    }
}
