<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterProvinsi;

class MasterProvinsiController extends Controller
{
    public function index(){

        $list_provinsi = MasterProvinsi::where('status', 'Y')->get();

        return view('master-provinsi.index', compact('list_provinsi'));
    }

    public function create(){

        return view('master-provinsi.create');
    }

    public function edit($kode_prp){

        $provinsi = MasterProvinsi::findOrFail($id);

        return view('master-provinsi.update', compact('provinsi'));
    }

    public function store(Request $request)
    {

        $request -> validate([
            'kode_prp'    => 'required',
            'provinsi'    => 'required',
        ]);

        try {

            $request->merge([
                'status'    => 'Y',
                'crea_date' => now(),
                'crea_by'   => Auth::user()->nama_user,
            ]);

            MasterProvinsi::create($request->all());

            return redirect()->route('master-provinsi.index')->with('success','Data provinsi baru berhasil ditambahkan!');

        } catch (Throwable $e) {
            report($e);
    
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data provinsi. Data sudah ada');
        }
        
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'kode_prp'    => 'required',
            'provinsi'    => 'required',
        ]);

        MasterPerkiraan::where('id', $id)->update([
                'kode_prp'      => $request->role,
                'updated_at'    => NOW(),
                'updated_by'    => Auth::user()->nama_user
            ]);
        
        if ($updated){
            return redirect()->route('master-provinsi.index')->with('success','Master provinsi berhasil diubah!');
        } else{
            return redirect()->route('master-provinsi.index')->with('danger','Master provinsi gagal diubah');
        }   
    }

    public function nonaktif($kode_prp)
    {
        try {

            $provinsi = MasterProvinsi::findOrFail($kode_prp);

            $provinsi->update([
                'status'        => 'Y',
                'modi_date'     => now(),
                'modi_by'       => Auth::user()->nama_user
            ]);

            return redirect()->route('master-provinsi.index')->with('success', 'Data master provinsi berhasil dinonaktifkan!');

        } catch (\Exception $e) {

            return redirect()->route('master-provinsi.index')->with('danger', 'Data master provinsi gagal dinonaktifkan');
        }
    }

    public function delete($kode_prp)
    {
        try {

            $provinsi = MasterProvinsi::findOrFail($kode_prp);
            $provinsi->delete();

            return redirect()->route('master-provinsi.index')->with('success', 'Data master provinsi berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('master-provinsi.index')->with('danger', 'Data master provinsi gagal dihapus');
        }
    }

}
