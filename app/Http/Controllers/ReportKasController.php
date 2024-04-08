<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasMasukHeader;
use App\Models\TransaksiKasKeluarHeader;

class ReportKasController extends Controller
{
    public function index(){

        return view('report-kas.index');
    }

    public function store(Request $request){

        $request->validate([
            'kas'           => 'required',
            'tanggal_awal'  => 'required',
            'tanggal_akhir' => 'required',
        ]);

        $tanggal_awal       = $request->tanggal_awal;
        $tanggal_akhir      = $request->tanggal_akhir;
    
        if($request->kas == 1){
            $getReport = KasMasukHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();

            $pdf   = PDF::loadView('reports.laporan-kas-masuk', ['getReport'=> $getReport, 'tanggal_awal'=> $tanggal_awal,'tanggal_akhir'=> $tanggal_akhir]);
            $pdf->setPaper('letter', 'landscape');

            return $pdf->stream('report-kas.pdf');

        } elseif($request->kas == 2){
            $getReport = TransaksiKasKeluarHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();

            $sumKasKeluar = 0;

            foreach($getReport as $p){
                $sumKasKeluar += $p->details_keluar->where('akuntansi_to', 'D')->sum('total');
            }


            $pdf   = PDF::loadView('reports.laporan-kas-keluar', ['getReport'=> $getReport, 'sumKasKeluar'=> $sumKasKeluar, 'tanggal_awal'=> $tanggal_awal, 'tanggal_akhir'=> $tanggal_akhir]);
            $pdf->setPaper('letter', 'landscape');

            return $pdf->stream('report-kas.pdf');

        } elseif($request->kas == 3){

            $getReportMasuk = TransaksiKasMasukHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
            $getReportKeluar = TransaksiKasKeluarHeader::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();

            $sumKasMasuk = 0;
            $sumKasKeluar = 0;

            foreach($getReportMasuk as $p){
                $sumKasMasuk += $p->details->where('akuntansi_to', 'D')->sum('total');
            }

            foreach($getReportKeluar as $p){
                $sumKasKeluar += $p->details_keluar->where('akuntansi_to', 'D')->sum('total');
            }

            $pdf   = PDF::loadView('reports.laporan-kas-keluar', ['getReport'=> $getReport, 'sumKasKeluar'=> $sumKasKeluar, 'tanggal_awal'=> $tanggal_awal, 'tanggal_akhir'=> $tanggal_akhir]);
            $pdf->setPaper('letter', 'landscape');

            return $pdf->stream('report-kas.pdf');
        }

    }
}
