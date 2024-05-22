<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\TransaksiPlafond;
use App\Models\TransaksiInvoiceHeader;

class PlafondController extends Controller
{
    public function index(){

        $plafond = TransaksiPlafond::all();

        return view('master-plafond.index', compact('plafond'));
    }

    public function tambah($id){

        $plafond = TransaksiPlafond::findOrFail($id);

        //Invoice Toko All, lunas Y, belum lunas N
        $invoice_toko   = TransaksiInvoiceHeader::where('kd_outlet', $plafond->kd_outlet)->where('flag_pembayaran_lunas', 'N')->get();

        $plafond_used = 0;
        foreach($invoice_toko as $i){
            $plafond_used += $i->details_invoice->sum('nominal_total');
        }

        $sisa_plafond = $plafond->nominal_plafond - $plafond_used;

        return view('master-plafond.tambah', compact('plafond', 'sisa_plafond'));
    }

    public function kurang($id){

        $plafond = TransaksiPlafond::findOrFail($id);

        //Invoice Toko All, lunas Y, belum lunas N
        $invoice_toko   = TransaksiInvoiceHeader::where('kd_outlet', $plafond->kd_outlet)->where('flag_pembayaran_lunas', 'N')->get();

        $plafond_used = 0;
        foreach($invoice_toko as $i){
            $plafond_used += $i->details_invoice->sum('nominal_total');
        }

        $sisa_plafond = $plafond->nominal_plafond - $plafond_used;

        return view('master-plafond.kurang', compact('plafond', 'sisa_plafond'));
    }

    public function store_tambah(Request $request){

        $request -> validate([
            'limit_plafond'   => 'required', 
            'nominal_plafond' => 'required',
            'kd_outlet'       => 'required',
        ]);

        str_replace(',', '', $request->limit);

        $limit_plafond = str_replace(',', '', $request->limit_plafond);
        $nominal_plafond = str_replace(',', '', $request->nominal_plafond);

        $updated = MasterPlafond::where('kd_outlet', $request->kd_outlet)->update([
            'nomin'         => $request->sales,
            'bulan'         => $request->bulan,
            'tahun'         => $request->tahun,
            'nominal'       => $nominal,
            'updated_at'    => $nominal
        ]);

         if ($updated){
            return redirect()->route('master-plafond.index')->with('success','Master Plafond berhasil diubah!');
        } else{
            return redirect()->route('master-plafond.index')->with('danger','Master Plafond gagal diubah');
        }  

    }
}