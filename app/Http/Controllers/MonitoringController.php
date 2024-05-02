<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TargetSpv;
use App\Models\TargetSpvProduk;
use App\Models\TargetSales;
use App\Models\TargetSalesProduk;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiInvoiceDetails;
use App\Models\User;

class MonitoringController extends Controller
{
    public function index(){

        $username = User::where('id_role', 20)->where('status', 'A')->get();

        return view('monitoring.index', compact('username'));
    }

    //sales
    public function store(Request $request){

        $request->validate([
            'sales'         => 'required',
            'tanggal_awal'  => 'required', 
            'tanggal_akhir' => 'required',
        ]);
        
        $sales  = $request->sales;
        $awal   = $request->tanggal_awal;
        $akhir  = $request->tanggal_akhir;

        $tanggal_akhir  = Carbon::parse($akhir)->addDay();
        $tanggal_awal   = Carbon::parse($awal)->startOfDay();
        $bulan          = Carbon::parse($awal)->month;
        $tahun          = Carbon::parse($awal)->year;
        $next_tahun     = $tahun + 1;

        $monthName      = Carbon::parse($awal)->month($bulan)->format('F');

        $dataTargetTahun = TargetSales::where('tahun', $tahun)->where('bulan', 12)->first();

        if(isset($dataTargetTahun)){

            $target = 0;
            
            $getTargetBulanan = TransaksiInvoiceHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->where('user_sales', $sales)
                ->get();

            foreach ($getTargetBulanan as $invoice) {
                $target += $invoice->details_invoice()->sum('nominal_total');
            }
            
            //ACTUAL EACH MONTH
            $sum1 = 0;
            $sum2 = 0;
            $sum3 = 0;
            $sum4 = 0;
            $sum5 = 0;
            $sum6 = 0;
            $sum7 = 0;
            $sum8 = 0;
            $sum9 = 0;
            $sum10 = 0;
            $sum11 = 0;
            $sum12 = 0;

            $getActualSales1 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-01-01')
                ->where('created_at', '<=', $tahun.'-02-01')
                ->get();

            $getActualSales2 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-02-01')
                ->where('created_at', '<=', $tahun.'-03-01')
                ->get();
            
            $getActualSales3 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-03-01')
                ->where('created_at', '<=', $tahun.'-04-01')
                ->get();

            $getActualSales4 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-04-01')
                ->where('created_at', '<=', $tahun.'-05-01')
                ->get();

            $getActualSales5 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-05-01')
                ->where('created_at', '<=', $tahun.'-06-01')
                ->get();

            $getActualSales6 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-06-01')
                ->where('created_at', '<=', $tahun.'-07-01')
                ->get();
            
            $getActualSales7 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-07-01')
                ->where('created_at', '<=', $tahun.'-08-01')
                ->get();

            $getActualSales8 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-08-01')
                ->where('created_at', '<=', $tahun.'-09-01')
                ->get();

            $getActualSales9 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-09-01')
                ->where('created_at', '<=', $tahun.'-10-01')
                ->get();
            
            $getActualSales10 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-10-01')
                ->where('created_at', '<=', $tahun.'-11-01')
                ->get();

            $getActualSales11 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-11-01')
                ->where('created_at', '<=', $tahun.'-12-01')
                ->get();
            
            $getActualSales12 = TransaksiInvoiceHeader::where('user_sales', $sales)
                ->where('created_at', '>=', $tahun.'-12-01')
                ->where('created_at', '<=', $next_tahun.'-01-01')
                ->get();

            foreach ($getActualSales1 as $invoice) {
                $sum1 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales2 as $invoice) {
                $sum2 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales3 as $invoice) {
                $sum3 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales4 as $invoice) {
                $sum4 += $invoice->details_invoice->sum('nominal_total');
            }
            foreach ($getActualSales5 as $invoice) {
                $sum5 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales6 as $invoice) {
                $sum6 += $invoice->details_invoice()->sum('nominal_total');
            }

            foreach ($getActualSales7 as $invoice) {
                $sum7 += $invoice->details_invoice()->sum('nominal_total');
            }

            foreach ($getActualSales8 as $invoice) {
                $sum8 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales9 as $invoice) {
                $sum9 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales10 as $invoice) {
                $sum10 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales11 as $invoice) {
                $sum11 += $invoice->details_invoice()->sum('nominal_total');
            }
            foreach ($getActualSales12 as $invoice) {
                $sum12 += $invoice->details_invoice()->sum('nominal_total');
            }

            $jan = number_format($sum1, 0, ',', ',');
            $feb = number_format($sum2, 0, ',', ',');
            $mar = number_format($sum3, 0, ',', ',');
            $apr = number_format($sum4, 0, ',', ',');
            $may = number_format($sum5, 0, ',', ',');
            $jun = number_format($sum6, 0, ',', ',');
            $jul = number_format($sum7, 0, ',', ',');
            $agu = number_format($sum8, 0, ',', ',');
            $sep = number_format($sum9, 0, ',', ',');
            $oct = number_format($sum10, 0, ',', ',');
            $nov = number_format($sum11, 0, ',', ',');
            $dec = number_format($sum12, 0, ',', ',');


            $getTarget = TargetSales::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->where('sales', $sales)
                ->value('nominal');

            $getTargetActual  = TargetSales::where('sales', $sales)->get();

            // TARGET EACH MONTH
            $target_jan = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_feb = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_mar = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_apr = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_may = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_jun = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_jul = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_agu = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_sep = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_oct = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_nov = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_dec = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $selisih            = $target - $getTarget;
            $pencapaian_persen  = ($target / $getTarget) * 100;

            //DETAILS PENCAPAIAN PRODUK
            $getTargetProdukSales = TargetSalesProduk::where('sales', $sales)->get();

            // TARGET EACH MONTH, EACH PRODUCT SALES
            // TARGET_S -> target sales 
            $target_s_ich_jan = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_s_ich_feb = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_s_ich_mar = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_s_ich_apr = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_s_ich_may = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_s_ich_jun = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_s_ich_jul = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_s_ich_agu = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_s_ich_sep = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_s_ich_oct = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_s_ich_nov = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_s_ich_dec = number_format($getTargetProdukSales->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_s_bri_jan = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_s_bri_feb = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_s_bri_mar = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_s_bri_apr = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_s_bri_may = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_s_bri_jun = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_s_bri_jul = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_s_bri_agu = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_s_bri_sep = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_s_bri_oct = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_s_bri_nov = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_s_bri_dec = number_format($getTargetProdukSales->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_s_acc_jan = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_s_acc_feb = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_s_acc_mar = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_s_acc_apr = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_s_acc_may = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_s_acc_jun = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_s_acc_jul = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_s_acc_agu = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_s_acc_sep = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_s_acc_oct = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_s_acc_nov = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_s_acc_dec = number_format($getTargetProdukSales->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_s_pen_jan = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_s_pen_feb = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_s_pen_mar = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_s_pen_apr = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_s_pen_may = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_s_pen_jun = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_s_pen_jul = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_s_pen_agu = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_s_pen_sep = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_s_pen_oct = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_s_pen_nov = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_s_pen_dec = number_format($getTargetProdukSales->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_s_acl_jan = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_s_acl_feb = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_s_acl_mar = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_s_acl_apr = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_s_acl_may = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_s_acl_jun = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_s_acl_jul = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_s_acl_agu = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_s_acl_sep = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_s_acl_oct = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_s_acl_nov = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_s_acl_dec = number_format($getTargetProdukSales->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            //VIEW ACHIEVEMENT SALES BY PRODUK
            $ach_s_jan = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->get();
            $ach_s_feb = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->get();
            $ach_s_mar = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->get();
            $ach_s_apr = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->get();
            $ach_s_may = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->get();
            $ach_s_jun = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->get();
            $ach_s_jul = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->get();
            $ach_s_aug = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->get();
            $ach_s_sep = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->get();
            $ach_s_oct = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->get();
            $ach_s_nov = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->get();
            $ach_s_dec = TransaksiInvoiceHeader::where('user_sales', $sales)->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->get();

            //ACHIEVEMENT SALES ICHIDAI
            $achIchS01 = 0;
            $achIchS02 = 0;
            $achIchS03 = 0;
            $achIchS04 = 0;
            $achIchS05 = 0;
            $achIchS06 = 0;
            $achIchS07 = 0;
            $achIchS08 = 0;
            $achIchS09 = 0;
            $achIchS10 = 0;
            $achIchS11 = 0;
            $achIchS12 = 0;

            //achievement sales ichidai per bulan
            foreach ($ach_s_jan as $i) {
                $achIchS01 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_feb as $i) {
                $achIchS02 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_mar as $i) {
                $achIchS03 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_apr as $i) {
                $achIchS04 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_may as $i) {
                $achIchS05 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jun as $i) {
                $achIchS06 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jul as $i) {
                $achIchS07 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_aug as $i) {
                $achIchS08 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_sep as $i) {
                $achIchS09 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_oct as $i) {
                $achIchS10 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_nov as $i) {
                $achIchS11 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_dec as $i) {
                $achIchS12 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })->sum('nominal_total');
            }


            //ACHIEVEMENT SALES BRIO
            $achBriS01 = 0;
            $achBriS02 = 0;
            $achBriS03 = 0;
            $achBriS04 = 0;
            $achBriS05 = 0;
            $achBriS06 = 0;
            $achBriS07 = 0;
            $achBriS08 = 0;
            $achBriS09 = 0;
            $achBriS10 = 0;
            $achBriS11 = 0;
            $achBriS12 = 0;

            //achievement sales brio per bulan
            foreach ($ach_s_jan as $i) {
                $achBriS01 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_feb as $i) {
                $achBriS02 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_mar as $i) {
                $achBriS03 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_apr as $i) {
                $achBriS04 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_may as $i) {
                $achBriS05 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jun as $i) {
                $achBriS06 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jul as $i) {
                $achBriS07 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_aug as $i) {
                $achBriS08 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_sep as $i) {
                $achBriS09 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_oct as $i) {
                $achBriS10 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_nov as $i) {
                $achBriS11 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_dec as $i) {
                $achBriS12 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })->sum('nominal_total');
            }

            //ACHIEVEMENT SALES ACCU
            $achAccS01 = 0;
            $achAccS02 = 0;
            $achAccS03 = 0;
            $achAccS04 = 0;
            $achAccS05 = 0;
            $achAccS06 = 0;
            $achAccS07 = 0;
            $achAccS08 = 0;
            $achAccS09 = 0;
            $achAccS10 = 0;
            $achAccS11 = 0;
            $achAccS12 = 0;

            //achievement sales brio per bulan
            foreach ($ach_s_jan as $i) {
                $achAccS01 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_feb as $i) {
                $achAccS02 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_mar as $i) {
                $achAccS03 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_apr as $i) {
                $achAccS04 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_may as $i) {
                $achAccS05 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jun as $i) {
                $achAccS06 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jul as $i) {
                $achAccS07 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_aug as $i) {
                $achAccS08 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_sep as $i) {
                $achAccS09 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_oct as $i) {
                $achAccS10 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_nov as $i) {
                $achAccS11 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_dec as $i) {
                $achAccS12 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })->sum('nominal_total');
            }


            //ACHIEVEMENT SALES AIR COOLANT
            $achAclS01 = 0;
            $achAclS02 = 0;
            $achAclS03 = 0;
            $achAclS04 = 0;
            $achAclS05 = 0;
            $achAclS06 = 0;
            $achAclS07 = 0;
            $achAclS08 = 0;
            $achAclS09 = 0;
            $achAclS10 = 0;
            $achAclS11 = 0;
            $achAclS12 = 0;

            //achievement sales air coolant per bulan
            foreach ($ach_s_jan as $i) {
                $achAclS01 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_feb as $i) {
                $achAclS02 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_mar as $i) {
                $achAclS03 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_apr as $i) {
                $achAclS04 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_may as $i) {
                $achAclS05 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jun as $i) {
                $achAclS06 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jul as $i) {
                $achAclS07 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_aug as $i) {
                $achAclS08 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_sep as $i) {
                $achAclS09 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_oct as $i) {
                $achAclS10 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_nov as $i) {
                $achAclS11 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_dec as $i) {
                $achAclS12 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })->sum('nominal_total');
            }

            //ACHIEVEMENT SALES ACCU
            $achPenS01 = 0;
            $achPenS02 = 0;
            $achPenS03 = 0;
            $achPenS04 = 0;
            $achPenS05 = 0;
            $achPenS06 = 0;
            $achPenS07 = 0;
            $achPenS08 = 0;
            $achPenS09 = 0;
            $achPenS10 = 0;
            $achPenS11 = 0;
            $achPenS12 = 0;

            //achievement sales brio per bulan
            foreach ($ach_s_jan as $i) {
                $achPenS01 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_feb as $i) {
                $achPenS02 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_mar as $i) {
                $achPenS03 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_apr as $i) {
                $achPenS04 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_may as $i) {
                $achPenS05 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jun as $i) {
                $achPenS06 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_jul as $i) {
                $achPenS07 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_aug as $i) {
                $achPenS08 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_sep as $i) {
                $achPenS09 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_oct as $i) {
                $achPenS10 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_nov as $i) {
                $achPenS11 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }
            foreach ($ach_s_dec as $i) {
                $achPenS12 += $i->details_invoice()->whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })->sum('nominal_total');
            }

            return view('monitoring.spv', compact('target', 'monthName','sales', 'getTarget', 'getTargetActual', 'selisih', 'pencapaian_persen', 'tahun',
            'getTargetBulanan', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'agu', 'sep', 'oct', 'nov', 'dec', 'dataTargetTahun',
            'target_jan', 'target_feb', 'target_mar', 'target_apr', 'target_may', 'target_jun', 'target_jul', 'target_agu', 'target_sep', 'target_oct', 'target_nov', 'target_dec',
            'target_s_ich_jan', 'target_s_ich_feb', 'target_s_ich_mar', 'target_s_ich_apr', 'target_s_ich_may', 'target_s_ich_jun', 'target_s_ich_jul', 'target_s_ich_agu', 'target_s_ich_sep', 'target_s_ich_oct', 'target_s_ich_nov', 'target_s_ich_dec',
            'target_s_bri_jan', 'target_s_bri_feb', 'target_s_bri_mar', 'target_s_bri_apr', 'target_s_bri_may', 'target_s_bri_jun', 'target_s_bri_jul', 'target_s_bri_agu', 'target_s_bri_sep', 'target_s_bri_oct', 'target_s_bri_nov', 'target_s_bri_dec',
            'target_s_acc_jan', 'target_s_acc_feb', 'target_s_acc_mar', 'target_s_acc_apr', 'target_s_acc_may', 'target_s_acc_jun', 'target_s_acc_jul', 'target_s_acc_agu', 'target_s_acc_sep', 'target_s_acc_oct', 'target_s_acc_nov', 'target_s_acc_dec',
            'target_s_acl_jan', 'target_s_acl_feb', 'target_s_acl_mar', 'target_s_acl_apr', 'target_s_acl_may', 'target_s_acl_jun', 'target_s_acl_jul', 'target_s_acl_agu', 'target_s_acl_sep', 'target_s_acl_oct', 'target_s_acl_nov', 'target_s_acl_dec',
            'target_s_pen_jan', 'target_s_pen_feb', 'target_s_pen_mar', 'target_s_pen_apr', 'target_s_pen_may', 'target_s_pen_jun', 'target_s_pen_jul', 'target_s_pen_agu', 'target_s_pen_sep', 'target_s_pen_oct', 'target_s_pen_nov', 'target_s_pen_dec',
            'achIchS01','achIchS02','achIchS03','achIchS04','achIchS05','achIchS06','achIchS07','achIchS08','achIchS09','achIchS10','achIchS11','achIchS12',
            'achBriS01','achBriS02','achBriS03','achBriS04','achBriS05','achBriS06','achBriS07','achBriS08','achBriS09','achBriS10','achBriS11','achBriS12',
            'achAccS01','achAccS02','achAccS03','achAccS04','achAccS05','achAccS06','achAccS07','achAccS08','achAccS09','achAccS10','achAccS11','achAccS12',
            'achAclS01','achAclS02','achAclS03','achAclS04','achAclS05','achAclS06','achAclS07','achAclS08','achAclS09','achAclS10','achAclS11','achAclS12',
            'achPenS01','achPenS02','achPenS03','achPenS04','achPenS05','achPenS06','achPenS07','achPenS08','achPenS09','achPenS10','achPenS11','achPenS12'
            ));

        } else {

            return view('monitoring.spv', compact('dataTargetTahun', 'tahun'));

        }
    }

    //VIEW MONITORING SPV
    public function spv(){

        $username = User::where('id_role', 24)->get();

        return view('monitoring.monitoring-spv', compact('username'));
    }

    public function spv_store(Request $request){

        $request->validate([
            'spv'           => 'required',
            'tanggal_awal'  => 'required', 
            'tanggal_akhir' => 'required',
        ]);

        $spv    = $request->spv;
        $awal   = $request->tanggal_awal;
        $akhir  = $request->tanggal_akhir;

        $tanggal_awal   = Carbon::parse($awal)->startOfDay();
        $tanggal_akhir  = Carbon::parse($akhir)->endOfDay();
        $bulan          = Carbon::parse($awal)->month;
        $tahun          = Carbon::parse($awal)->year;
        $monthName      = Carbon::parse($awal)->month($bulan)->format('F');

        $targetSpv = TargetSpv::where('tahun', $tahun)->where('bulan', 12)->first();

        if(isset($targetSpv)){

            $getTargetBulanan = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->get();

            $getTarget = TargetSpv::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->where('spv', $spv)
                ->first();
        
                $target             = $getTargetBulanan->sum('nominal_total');
                $selisih            = $target - $getTarget->nominal;
                $pencapaian_persen  = ($target / $getTarget->nominal)/ 100;


            $getActual = TransaksiInvoiceDetails::all();

            $getTargetActual = TargetSpv::where('spv', $spv)->get();

            // TARGET EACH MONTH
            $target_jan = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_feb = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_mar = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_apr = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_may = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_jun = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_jul = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_agu = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_sep = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_oct = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_nov = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_dec = number_format($getTargetActual->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            //ACTUAL EACH MONTH
            $jan = number_format($getActual->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->sum('nominal_total'), 0, ',', ',');
            $feb = number_format($getActual->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->sum('nominal_total'), 0, ',', ',');
            $mar = number_format($getActual->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->sum('nominal_total'), 0, ',', ',');
            $apr = number_format($getActual->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->sum('nominal_total'), 0, ',', ',');
            $may = number_format($getActual->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->sum('nominal_total'), 0, ',', ',');
            $jun = number_format($getActual->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->sum('nominal_total'), 0, ',', ',');
            $jul = number_format($getActual->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->sum('nominal_total'), 0, ',', ',');
            $agu = number_format($getActual->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->sum('nominal_total'), 0, ',', ',');
            $sep = number_format($getActual->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->sum('nominal_total'), 0, ',', ',');
            $oct = number_format($getActual->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->sum('nominal_total'), 0, ',', ',');
            $nov = number_format($getActual->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->sum('nominal_total'), 0, ',', ',');
            $dec = number_format($getActual->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->sum('nominal_total'), 0, ',', ','); 
            
            $getTargetProduk = TargetSpvProduk::where('spv', $spv)->get();

            // TARGET EACH MONTH, EACH PRODUCT
            $target_ich_jan = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_ich_feb = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_ich_mar = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_ich_apr = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_ich_may = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_ich_jun = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_ich_jul = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_ich_agu = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_ich_sep = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_ich_oct = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_ich_nov = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_ich_dec = number_format($getTargetProduk->where('kode_produk', 'ICH')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_bri_jan = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_bri_feb = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_bri_mar = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_bri_apr = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_bri_may = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_bri_jun = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_bri_jul = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_bri_agu = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_bri_sep = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_bri_oct = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_bri_nov = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_bri_dec = number_format($getTargetProduk->where('kode_produk', 'BRI')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_acc_jan = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_acc_feb = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_acc_mar = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_acc_apr = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_acc_may = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_acc_jun = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_acc_jul = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_acc_agu = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_acc_sep = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_acc_oct = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_acc_nov = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_acc_dec = number_format($getTargetProduk->where('kode_produk', 'ACC')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_pen_jan = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_pen_feb = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_pen_mar = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_pen_apr = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_pen_may = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_pen_jun = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_pen_jul = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_pen_agu = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_pen_sep = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_pen_oct = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_pen_nov = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_pen_dec = number_format($getTargetProduk->where('kode_produk', 'PEN')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            $target_acl_jan = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 1)->value('nominal'), 0, ',', ',');
            $target_acl_feb = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 2)->value('nominal'), 0, ',', ',');
            $target_acl_mar = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 3)->value('nominal'), 0, ',', ',');
            $target_acl_apr = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 4)->value('nominal'), 0, ',', ',');
            $target_acl_may = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 5)->value('nominal'), 0, ',', ',');
            $target_acl_jun = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 6)->value('nominal'), 0, ',', ',');
            $target_acl_jul = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 7)->value('nominal'), 0, ',', ',');
            $target_acl_agu = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 8)->value('nominal'), 0, ',', ',');
            $target_acl_sep = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 9)->value('nominal'), 0, ',', ',');
            $target_acl_oct = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 10)->value('nominal'), 0, ',', ',');
            $target_acl_nov = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 11)->value('nominal'), 0, ',', ',');
            $target_acl_dec = number_format($getTargetProduk->where('kode_produk', 'ACL')->where('tahun', $tahun)->where('bulan', 12)->value('nominal'), 0, ',', ',');

            //VIEW PEMBELIAN BY PRODUK
            //ICHIDAI
            $getActualIchidai = TransaksiInvoiceDetails::whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ICH');
                    })
                ->get();

            $jan_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->sum('nominal_total'), 0, ',', ',');
            $feb_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->sum('nominal_total'), 0, ',', ',');
            $mar_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->sum('nominal_total'), 0, ',', ',');
            $apr_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->sum('nominal_total'), 0, ',', ',');
            $may_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->sum('nominal_total'), 0, ',', ',');
            $jun_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->sum('nominal_total'), 0, ',', ',');
            $jul_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->sum('nominal_total'), 0, ',', ',');
            $agu_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->sum('nominal_total'), 0, ',', ',');
            $sep_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->sum('nominal_total'), 0, ',', ',');
            $oct_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->sum('nominal_total'), 0, ',', ',');
            $nov_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->sum('nominal_total'), 0, ',', ',');
            $dec_ich = number_format($getActualIchidai->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->sum('nominal_total'), 0, ',', ',');


            //BRIO
            $getActualBrio = TransaksiInvoiceDetails::whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'BRI');
                    })
                ->get();

            $jan_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->sum('nominal_total'), 0, ',', ',');
            $feb_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->sum('nominal_total'), 0, ',', ',');
            $mar_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->sum('nominal_total'), 0, ',', ',');
            $apr_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->sum('nominal_total'), 0, ',', ',');
            $may_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->sum('nominal_total'), 0, ',', ',');
            $jun_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->sum('nominal_total'), 0, ',', ',');
            $jul_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->sum('nominal_total'), 0, ',', ',');
            $agu_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->sum('nominal_total'), 0, ',', ',');
            $sep_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->sum('nominal_total'), 0, ',', ',');
            $oct_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->sum('nominal_total'), 0, ',', ',');
            $nov_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->sum('nominal_total'), 0, ',', ',');
            $dec_bri = number_format($getActualBrio->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->sum('nominal_total'), 0, ',', ','); 
        
            //ACCU
            $getActualAccu = TransaksiInvoiceDetails::whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACC');
                    })
                ->get();

            $jan_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->sum('nominal_total'), 0, ',', ',');
            $feb_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->sum('nominal_total'), 0, ',', ',');
            $mar_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->sum('nominal_total'), 0, ',', ',');
            $apr_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->sum('nominal_total'), 0, ',', ',');
            $may_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->sum('nominal_total'), 0, ',', ',');
            $jun_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->sum('nominal_total'), 0, ',', ',');
            $jul_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->sum('nominal_total'), 0, ',', ',');
            $agu_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->sum('nominal_total'), 0, ',', ',');
            $sep_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->sum('nominal_total'), 0, ',', ',');
            $oct_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->sum('nominal_total'), 0, ',', ',');
            $nov_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->sum('nominal_total'), 0, ',', ',');
            $dec_acc = number_format($getActualAccu->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->sum('nominal_total'), 0, ',', ','); 
        
            //COOLANT
            $getActualCoolant = TransaksiInvoiceDetails::whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'ACL');
                    })
                ->get();

            $jan_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->sum('nominal_total'), 0, ',', ',');
            $feb_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->sum('nominal_total'), 0, ',', ',');
            $mar_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->sum('nominal_total'), 0, ',', ',');
            $apr_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->sum('nominal_total'), 0, ',', ',');
            $may_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->sum('nominal_total'), 0, ',', ',');
            $jun_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->sum('nominal_total'), 0, ',', ',');
            $jul_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->sum('nominal_total'), 0, ',', ',');
            $agu_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->sum('nominal_total'), 0, ',', ',');
            $sep_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->sum('nominal_total'), 0, ',', ',');
            $oct_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->sum('nominal_total'), 0, ',', ',');
            $nov_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->sum('nominal_total'), 0, ',', ',');
            $dec_acl = number_format($getActualCoolant->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->sum('nominal_total'), 0, ',', ','); 
            

            //PENTIL
            $getActualPentil = TransaksiInvoiceDetails::whereIn('part_no', function ($query) {
                    $query->select('part_no')
                        ->from('master_part')
                        ->where('kode_produk', 'PEN');
                    })
                ->get();

            $jan_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-01-01')->where('created_at', '<=', $tahun.'-02-01')->sum('nominal_total'), 0, ',', ',');
            $feb_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-02-01')->where('created_at', '<=', $tahun.'-03-01')->sum('nominal_total'), 0, ',', ',');
            $mar_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-03-01')->where('created_at', '<=', $tahun.'-04-01')->sum('nominal_total'), 0, ',', ',');
            $apr_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-04-01')->where('created_at', '<=', $tahun.'-05-01')->sum('nominal_total'), 0, ',', ',');
            $may_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-05-01')->where('created_at', '<=', $tahun.'-06-01')->sum('nominal_total'), 0, ',', ',');
            $jun_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-06-01')->where('created_at', '<=', $tahun.'-07-01')->sum('nominal_total'), 0, ',', ',');
            $jul_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-07-01')->where('created_at', '<=', $tahun.'-08-01')->sum('nominal_total'), 0, ',', ',');
            $agu_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-08-01')->where('created_at', '<=', $tahun.'-09-01')->sum('nominal_total'), 0, ',', ',');
            $sep_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-09-01')->where('created_at', '<=', $tahun.'-10-01')->sum('nominal_total'), 0, ',', ',');
            $oct_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-10-01')->where('created_at', '<=', $tahun.'-11-01')->sum('nominal_total'), 0, ',', ',');
            $nov_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-11-01')->where('created_at', '<=', $tahun.'-12-01')->sum('nominal_total'), 0, ',', ',');
            $dec_pen = number_format($getActualPentil->where('created_at', '>=', $tahun.'-12-01')->where('created_at', '<=', $next_tahun.'-01-01')->sum('nominal_total'), 0, ',', ',');

            return view('monitoring.sales', compact('target', 'tahun', 'monthName','spv', 'getActual','getTarget', 'getTargetActual', 'getTargetBulanan',
            'selisih', 'pencapaian_persen', 'targetSpv', 
            'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'agu', 'sep', 'oct', 'nov', 'dec',
            'jan_ich', 'feb_ich', 'mar_ich', 'apr_ich', 'may_ich', 'jun_ich', 'jul_ich', 'agu_ich', 'sep_ich', 'oct_ich', 'nov_ich', 'dec_ich',
            'jan_bri', 'feb_bri', 'mar_bri', 'apr_bri', 'may_bri', 'jun_bri', 'jul_bri', 'agu_bri', 'sep_bri', 'oct_bri', 'nov_bri', 'dec_bri',
            'jan_acc', 'feb_acc', 'mar_acc', 'apr_acc', 'may_acc', 'jun_acc', 'jul_acc', 'agu_acc', 'sep_acc', 'oct_acc', 'nov_acc', 'dec_acc',
            'jan_acl', 'feb_acl', 'mar_acl', 'apr_acl', 'may_acl', 'jun_acl', 'jul_acl', 'agu_acl', 'sep_acl', 'oct_acl', 'nov_acl', 'dec_acl',
            'jan_pen', 'feb_pen', 'mar_pen', 'apr_pen', 'may_pen', 'jun_pen', 'jul_pen', 'agu_pen', 'sep_pen', 'oct_pen', 'nov_pen', 'dec_pen', 
            'target_jan', 'target_feb', 'target_mar', 'target_apr', 'target_may', 'target_jun', 'target_jul', 'target_agu', 'target_sep', 'target_oct', 'target_nov', 'target_dec',
            'target_ich_jan', 'target_ich_feb', 'target_ich_mar', 'target_ich_apr', 'target_ich_may', 'target_ich_jun', 'target_ich_jul', 'target_ich_agu', 'target_ich_sep', 'target_ich_oct', 'target_ich_nov', 'target_ich_dec',
            'target_bri_jan', 'target_bri_feb', 'target_bri_mar', 'target_bri_apr', 'target_bri_may', 'target_bri_jun', 'target_bri_jul', 'target_bri_agu', 'target_bri_sep', 'target_bri_oct', 'target_bri_nov', 'target_bri_dec',
            'target_acc_jan', 'target_acc_feb', 'target_acc_mar', 'target_acc_apr', 'target_acc_may', 'target_acc_jun', 'target_acc_jul', 'target_acc_agu', 'target_acc_sep', 'target_acc_oct', 'target_acc_nov', 'target_acc_dec',
            'target_acl_jan', 'target_acl_feb', 'target_acl_mar', 'target_acl_apr', 'target_acl_may', 'target_acl_jun', 'target_acl_jul', 'target_acl_agu', 'target_acl_sep', 'target_acl_oct', 'target_acl_nov', 'target_acl_dec',
            'target_pen_jan', 'target_pen_feb', 'target_pen_mar', 'target_pen_apr', 'target_pen_may', 'target_pen_jun', 'target_pen_jul', 'target_pen_agu', 'target_pen_sep', 'target_pen_oct', 'target_pen_nov', 'target_pen_dec'
            ));

        } else {

            return view('monitoring.sales', compact('targetSpv', 'tahun'));
        }
    }

    public function pesanan(){

        return view('monitoring.pesanan');
    }

    public function pesanan_store(Request $request){

        $request->validate([
            'tanggal_awal'  => 'required', 
            'tanggal_akhir' => 'required',
        ]);
        
        $sales  = $request->sales;
        $awal   = $request->tanggal_awal;
        $akhir  = $request->tanggal_akhir;

        $tanggal_awal   = Carbon::parse($awal)->startOfDay();
        $tanggal_akhir  = Carbon::parse($akhir)->endOfDay();
        $bulan          = Carbon::parse($awal)->month;
        $tahun          = Carbon::parse($awal)->year;
        $monthName      = Carbon::parse($awal)->month($bulan)->format('F');

        $getPesanan = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();

        $getPesananIchidai = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->whereIn('part_no', function ($query) {
                $query->select('part_no')
                    ->from('master_part')
                    ->where('id_grup', '1');
                })
            ->get();


        $getPesananBrio = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->whereIn('part_no', function ($query) {
                $query->select('part_no')
                    ->from('master_part')
                    ->where('id_grup', '2');
            })
            ->get();

        $getPesananAccu = TransaksiInvoiceDetails::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->whereIn('part_no', function ($query) {
                $query->select('part_no')
                    ->from('master_part')
                    ->where('id_grup', '3');
            })
            ->get();

        return view('monitoring.pesanan-terjual', compact('monthName', 'getPesanan', 'getPesananIchidai', 'getPesananBrio', 'getPesananAccu'));
    }

}
