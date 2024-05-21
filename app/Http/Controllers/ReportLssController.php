<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPart;
use App\Models\MasterLevel4;
use App\Models\MasterProduk;
use App\Models\InvoiceNonHeader;
use App\Models\InvoiceNonDetails;
use App\Models\TransaksiInvoiceDetails;
use App\Models\ModalPartTerjual;
use App\Models\LSS;
use App\Models\LssStok;

class ReportLssController extends Controller
{
    public function index(){

        return view('report-lss.index');
    }

    public function store(Request $request){
        //1 Stok, 2 Nilai
        if($request->laporan == 1){

            $request->validate([
                'bulan' => 'required',
                'tahun' => 'required',
            ]);
    
            $bulan          = $request->bulan;
            $tahun          = $request->tahun;
            $next_bulan     = $bulan+1;
            $next_tahun     = $tahun+1;
            $date           = Carbon::create(null, $bulan, 1, 0, 0, 0);
            $previousMonth  = $date->subMonth()->month;
            $previousYear   = $tahun - 1;

            $lss = LssStok::where('bulan', $bulan)->where('tahun', $tahun)->first();

            if($lss == null){
        
                $getProduk = MasterLevel4::where('status', 'A')->get();
        
                foreach($getProduk as $i){

                    if($bulan == 12){

                        $getBeli = InvoiceNonHeader::whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $next_tahun.'-01-01'])->get();
                        $getHpp  = TransaksiInvoiceDetails::where('status', 'Y')->whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $next_tahun.'-01-01'])->get();
                        $getJual = ModalPartTerjual::whereBetween('tanggal_invoice', [$tahun.'-'.$bulan.'-01', $next_tahun.'-01-01'])->get();

                    } else {

                        $getBeli = InvoiceNonHeader::whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $tahun.'-'.$next_bulan.'-01'])->get();
                        $getHpp  = TransaksiInvoiceDetails::where('status', 'Y')->whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $tahun.'-'.$next_bulan.'-01'])->get();
                        $getJual = ModalPartTerjual::whereBetween('tanggal_invoice', [$tahun.'-'.$bulan.'-01', $tahun.'-'.$next_bulan.'-01'])->get();

                    }
        
                    $part       = MasterPart::where('level_2', $i->id_level_2)->where('level_4', $i->level_4)->pluck('part_no')->toArray();
                    $flattened  = collect($part)->flatten()->toArray();

                    $beli = 0;

                    foreach($getBeli as $b){
                        $beli += $b->details_pembelian->whereIn('part_no', $flattened)->sum('qty');
                    }

                    $jualByPart = [];

                    foreach ($getHpp as $s) {
                        if (in_array($s->part_no, $flattened)) {
                            if (!isset($jualByPart[$s->part_no])) {
                                $jualByPart[$s->part_no] = 0;
                            }
                            $jualByPart[$s->part_no] += $s->qty;
                        }
                    }

                    $jual = array_sum($jualByPart);

                    if($bulan == 01){

                        $stok_last_month = LssStok::where('bulan', $previousMonth)->where('tahun', $previousYear)->first();

                        if(isset($stok_last_month)){
                            $awal_amount = LssStok::where('bulan', $previousMonth)
                                ->where('tahun', $previousYear)
                                ->where('sub_kelompok_part', $i->level_4)
                                ->where('produk_part', $i->id_level_2)
                                ->value('akhir_stok');

                        } else{

                            $awal_amount = 0;
                        }
            
                        //INSERT LSS TO DB
                        $value = [
                            'bulan'                 => $bulan,
                            'tahun'                 => $tahun,
                            'sub_kelompok_part'     => $i->level_4,
                            'produk_part'           => $i->id_level_2,
                            'awal_stok'             => $awal_amount,
                            'beli'                  => $beli,
                            'jual'                  => $jual,
                            'akhir_stok'            => $awal_amount + $beli - $jual,
                            'status'                => 'A',
                            'created_at'            => NOW(),
                            'created_by'            => Auth::user()->nama_user,
                        ];
            
                        $created = LssStok::create($value);
        
                    } else {

                        $stok_last_month = LssStok::where('bulan', $previousMonth)->where('tahun', $tahun)->first();

                        if(isset($stok_last_month)){
                            $awal_amount = LssStok::where('bulan', $previousMonth)
                                ->where('tahun', $tahun)
                                ->where('sub_kelompok_part', $i->level_4)
                                ->where('produk_part', $i->id_level_2)
                                ->value('akhir_stok');
                        } else{

                            $awal_amount = 0;
                        }
            
                        //INSERT LSS TO DB
                        $value = [
                            'bulan'                 => $bulan,
                            'tahun'                 => $tahun,
                            'sub_kelompok_part'     => $i->level_4,
                            'produk_part'           => $i->id_level_2,
                            'awal_stok'             => $awal_amount,
                            'beli'                  => $beli,
                            'jual'                  => $jual,
                            'akhir_stok'            => $awal_amount + $beli - $jual,
                            'status'                => 'A',
                            'created_at'            => NOW(),
                            'created_by'            => Auth::user()->nama_user,
                        ];
            
                        $created = LssStok::create($value);

                    }
                }
            }

            $data = LssStok::where('bulan', $bulan)->where('tahun', $tahun)->get();

            return view('report-lss.view-stok', compact('data', 'bulan', 'tahun'));

        } elseif($request->laporan == 2){

            $request->validate([
                'bulan'         => 'required',
                'tahun'         => 'required',
            ]);
    
            $bulan              = $request->bulan;
            $tahun              = $request->tahun;
            $next_bulan         = $bulan+1;
            $next_tahun         = $tahun+1;
            $date               = Carbon::create(null, $bulan, 1, 0, 0, 0);
            $previousYear       = $tahun - 1;
            $previousMonth      = $date->subMonth()->month;

            $lss = LSS::where('bulan', $bulan)->where('tahun', $tahun)->first();

            if($lss == null){
                $getProduk = MasterLevel4::where('status', 'A')->get();
        
                foreach($getProduk as $i){

                    if($bulan == 12){

                        $getHpp          = TransaksiInvoiceDetails::where('status', 'Y')->whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $next_tahun.'-01-01'])->get();
                        $getBeli         = InvoiceNonHeader::whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $next_tahun.'-01-01'])->get();
                        $getModalTerjual = ModalPartTerjual::whereBetween('tanggal_invoice', [$tahun.'-'.$bulan.'-01', $next_tahun.'-01-01'])->get();

                    } else {

                        $getHpp          = TransaksiInvoiceDetails::where('status', 'Y')->whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $tahun.'-'.$next_bulan.'-01'])->get();
                        $getBeli         = InvoiceNonHeader::whereBetween('created_at', [$tahun.'-'.$bulan.'-01', $tahun.'-'.$next_bulan.'-01'])->get();
                        $getModalTerjual = ModalPartTerjual::whereBetween('tanggal_invoice', [$tahun.'-'.$bulan.'-01', $tahun.'-'.$next_bulan.'-01'])->get();

                    }

                    $part       = MasterPart::where('level_2', $i->id_level_2)->where('level_4', $i->level_4)->pluck('part_no')->toArray();
                    $flattened  = collect($part)->flatten()->toArray();
        
                    $beli = 0;
        
                    foreach($getBeli as $s){
                        $beli += $s->details_pembelian->whereIn('part_no', $flattened)->value('total_amount');
                    }
        
                    $hpp     = $getHpp->whereIn('part_no', $flattened)->sum('nominal_total')/1.11;
                    $jual    = $getModalTerjual->whereIn('part_no', $flattened)->sum('nominal_modal')/1.11;

                    if($bulan == 01){

                        $amount_last_month = LSS::where('bulan', $previousMonth)->where('tahun', $previousYear)->first();

                        if(isset($amount_last_month)){

                            $awal_amount = LSS::where('bulan', $previousMonth)
                                ->where('tahun', $previousYear)
                                ->where('sub_kelompok_part', $i->level_4)
                                ->where('produk_part', $i->id_level_2)
                                ->value('akhir_amount');
                        } else{

                            $awal_amount = 0;
                        }
            
                        //INSERT LSS TO DB
                        $value = [
                            'bulan'                 => $bulan,
                            'tahun'                 => $tahun,
                            'sub_kelompok_part'     => $i->level_4,
                            'produk_part'           => $i->id_level_2,
                            'awal_amount'           => $awal_amount,
                            'beli'                  => $beli,
                            'jual_rbp'              => $hpp,
                            'jual_dbp'              => $jual,
                            'akhir_amount'          => $awal_amount + $beli - $jual,
                            'status'                => 'A',
                            'created_at'            => NOW(),
                            'created_by'            => Auth::user()->nama_user,
                        ]; 
            
                        $created = LSS::create($value);


                    } else {

                        $amount_last_month = LSS::where('bulan', $previousMonth)->where('tahun', $tahun)->first();


                        if(isset($amount_last_month)){

                            $awal_amount = LSS::where('bulan', $previousMonth)
                                ->where('tahun', $tahun)
                                ->where('sub_kelompok_part', $i->level_4)
                                ->where('produk_part', $i->id_level_2)
                                ->value('akhir_amount');

                        } else{

                            $awal_amount = 0;
                        }
            
                        //INSERT LSS TO DB
                        $value = [
                            'bulan'                 => $bulan,
                            'tahun'                 => $tahun,
                            'sub_kelompok_part'     => $i->level_4,
                            'produk_part'           => $i->id_level_2,
                            'awal_amount'           => $awal_amount,
                            'beli'                  => $beli,
                            'jual_rbp'              => $hpp,
                            'jual_dbp'              => $jual,
                            'akhir_amount'          => ($awal_amount + $beli) - $jual,
                            'status'                => 'A',
                            'created_at'            => NOW(),
                            'created_by'            => Auth::user()->nama_user,
                        ];
            
                        $created = LSS::create($value);
                    }
                }
            }

            $data = LSS::where('bulan', $bulan)->where('tahun', $tahun)->get();

            return view('report-lss.view', compact('data', 'bulan', 'tahun'));
        }
    }
}
