<?php

namespace App\Http\Controllers;

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

        $update = MasterOutlet::where('kd_outlet', $kd_outlet)
                ->update([
                'kode_prp'      => $request->qty,
                'kode_kab'      => $request->disc,
                'kd_outlet'     => $request->qty * $het,
                'nominal_disc'  => $request->qty * $het * $request->disc/100,
                'nominal_total' => ($request->qty * $het) - ($request->qty * $het * $request->disc/100),
                'modi_date'     => NOW(),
                'modi_by'       => Auth::user()->nama_user
            ]);

        if ($update){
            return redirect()->route('sales-order.details', $cari_sp->nosp)->with('success','Data SP berhasil diubah!');
        } else{
            return redirect()->route('sales-order.details', $cari_sp->nosp)->with('danger','Data SP gagal diubah');
        }
    }
}
