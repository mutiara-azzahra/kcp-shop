<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;
use App\Models\TransaksiPlafond;
use App\Models\TransaksiInvoiceHeader;

class PlafondController extends Controller
{
    public function index(){

        $plafond = TransaksiPlafond::all();

        return view('master-plafond.index', compact('plafond'));
    }

    public function create(){

        $outlet_ada = TransaksiPlafond::where('status', 'A')->pluck('kd_outlet')->toArray();

        $outlet = MasterOutlet::whereNotIn('kd_outlet', $outlet_ada)->where('status', 'Y')->get();

        return view('master-plafond.create', compact('outlet'));
    }

    public function store(Request $request){

        $request -> validate([
            'kd_outlet'        => 'required',
            'nominal_plafond'  => 'required',
        ]);

        $nominal_plafond  = str_replace(',', '', $request->nominal_plafond);

        if($request->target_per_bulan != null){
            $target_per_bulan = str_replace(',', '', $request->target_per_bulan);
        } else {
            $target_per_bulan = 0;
        }
        
        $nama_outlet = MasterOutlet::where('kd_outlet', $request->kd_outlet)->value('nm_outlet');

        $data = [
            'kd_outlet'        => $request->kd_outlet,
            'nm_outlet'        => $nama_outlet,
            'target_per_bulan' => $target_per_bulan,
            'nominal_plafond'  => $nominal_plafond,
            'status'           => 'A',
            'created_by'       => Auth::user()->nama_user,
            'created_at'       => NOW(),
        ];
    
        $created = TransaksiPlafond::create($data);

         if ($created){
            return redirect()->route('master-plafond.index')->with('success','Master Plafond berhasil ditambah!');
        } else{
            return redirect()->route('master-plafond.index')->with('danger','Master Plafond gagal ditambah');
        }  

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
            'nominal_tambah'  => 'required', 
            'nominal_plafond' => 'required',
            'kd_outlet'       => 'required',
        ]);

        str_replace(',', '', $request->limit);

        $nominal_tambah  = str_replace(',', '', $request->nominal_tambah);
        $nominal_plafond = str_replace(',', '', $request->nominal_plafond);

        $updated = TransaksiPlafond::where('kd_outlet', $request->kd_outlet)->update([
            'nominal_plafond' => $nominal_tambah + $nominal_plafond,
            'updated_at'      => now(),
            'updated_by'      => Auth::user()->nama_user
        ]);

         if ($updated){
            return redirect()->route('master-plafond.index')->with('success','Master Plafond berhasil diubah!');
        } else{
            return redirect()->route('master-plafond.index')->with('danger','Master Plafond gagal diubah');
        }  

    }

    public function store_kurang(Request $request){

        $request -> validate([
            'nominal_kurang'  => 'required', 
            'nominal_plafond' => 'required',
            'kd_outlet'       => 'required',
        ]);

        str_replace(',', '', $request->limit);

        $nominal_kurang  = str_replace(',', '', $request->nominal_kurang);
        $nominal_plafond = str_replace(',', '', $request->nominal_plafond);

        $updated = TransaksiPlafond::where('kd_outlet', $request->kd_outlet)->update([
            'nominal_plafond' => $nominal_plafond - $nominal_kurang,
            'updated_at'      => now(),
            'updated_by'      => Auth::user()->nama_user
        ]);

         if ($updated){
            return redirect()->route('master-plafond.index')->with('success','Master Plafond berhasil diubah!');
        } else{
            return redirect()->route('master-plafond.index')->with('danger','Master Plafond gagal diubah');
        }  

    }
}