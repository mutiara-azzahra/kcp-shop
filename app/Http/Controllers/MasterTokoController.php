<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;

class MasterTokoController extends Controller
{
    public function index(){

        $list_toko = MasterOutlet::where('status', 'Y')->get();

        return view('master-toko.index', compact('list_toko'));
    }

    public function edit($kd_outlet){

        $outlet = MasterOutlet::where('kd_outlet', $kd_outlet)->first();

        return view('master-toko.edit', compact('outlet'));
    }

    public function update(Request $request){

        $update = MasterOutlet::where('kd_outlet', $request->kd_outlet)
                ->update([
                'kode_prp'          => $request->kode_prp,
                'kode_kab'          => $request->kode_kab,
                'nm_pemilik'        => $request->nm_pemilik,
                'nm_outlet'         => $request->nm_outlet,
                'almt_outlet'       => $request->almt_outlet,
                'almt_pengiriman'   => $request->almt_pengiriman,
                'tlpn'              => $request->tlpn,
                'jth_tempo'         => $request->jth_tempo,
                'expedisi'          => $request->expedisi,
                'nik'               => $request->nik,
                'modi_date'         => NOW(),
                'modi_by'           => Auth::user()->nama_user
            ]);

        if ($update){
            return redirect()->route('master-toko.index')->with('success','Data Master Toko berhasil diubah!');
        } else{
            return redirect()->route('master-toko.index')->with('danger','Data Master Toko gagal diubah');
        }
    }


    
}
