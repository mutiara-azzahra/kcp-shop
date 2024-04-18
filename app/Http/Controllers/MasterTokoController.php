<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;
use App\Models\MasterProvinsi;
use App\Models\MasterAreaOutlet;

class MasterTokoController extends Controller
{
    public function index(){

        $list_toko = MasterOutlet::where('status', 'Y')->get();

        return view('master-toko.index', compact('list_toko'));
    }

    public function create(){

        $kota = MasterAreaOutlet::where('status','Y')->get();

        return view('master-toko.create', compact('kota'));
    }

    public function edit($kd_outlet){

        $outlet = MasterOutlet::where('kd_outlet', $kd_outlet)->first();

        return view('master-toko.edit', compact('outlet'));
    }

    public function view($kd_outlet){

        $outlet = MasterOutlet::where('kd_outlet', $kd_outlet)->first();

        return view('master-toko.show', compact('outlet'));
    }

    public function store(Request $request){

        $request->validate([
            'kode_kab'          => 'required',
            'kd_outlet'         => 'required',
            'nm_pemilik'        => 'required',
            'nm_outlet'         => 'required',
            'almt_outlet'       => 'required',
            'almt_pengiriman'   => 'required',
            'tlpn'              => 'required',
            'jth_tempo'         => 'required',
            'expedisi'          => 'required'
        ]);

        try {
            $kode_toko = MasterOutlet::where('kd_outlet', $request->kd_outlet)->first();
        
            if (isset($kode_toko)) {

                return redirect()->back()->with('danger', 'Error: Kode Toko sudah ada.');

            } else {

                $provinsi = MasterAreaOutlet::where('kode_kab', $request->kode_kab)->first();
                
                $request->merge([
                    'kode_prp'      => $provinsi->kode_prp,
                    'status'        => 'Y',
                    'no_npwp'       => isset($request->no_npwp) ? $request->no_npwp : '*',
                ]);
        
                MasterOutlet::create($request->all());

                return redirect()->route('master-toko.index')->with('success', 'Data baru berhasil ditambahkan');
            }
        } catch (QueryException $exception) {
         
            return redirect()->back()->with('danger', 'Error: Kode Toko sudah ada');
        }

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

    public function nonaktif($kd_outlet)
    {
        try {

            $outlet = MasterOutlet::where('kd_outlet', $kd_outlet)->first();

            $outlet->update([
                'status'        => 'Y',
                'modi_date'     => now(),
                'modi_by'       => Auth::user()->nama_user
            ]);

            return redirect()->route('master-toko.index')->with('success', 'Data master toko berhasil dinonaktifkan!');

        } catch (\Exception $e) {

            return redirect()->route('master-toko.index')->with('danger', 'Data master toko gagal dinonaktifkan');
        }
    }

}
