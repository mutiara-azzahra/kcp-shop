<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterProduk;

class MasterProdukController extends Controller
{
    public function index(){

        $master_produk = MasterProduk::where('status', 'A')->get();

        return view('master-produk.index', compact('master_produk'));
    }

    public function create(){

        $kode_rak = MasterKodeRak::where('status', 'A')->get();

        return view('master-produk.create', compact('kode_rak'));
    }

    public function show($id){

         $master_produk_id = MasterProduk::findOrFail($id);

        return view('master-produk.show', compact('master_produk_id'));
       
    }

    public function store(Request $request){

        $request -> validate([
            'kode_produk'   => 'required',
            'keterangan'    => 'required',
        ]);

        $created = MasterProduk::create($request->all());

        if ($created){
            return redirect()->route('master-produk.index')->with('success','Data baru berhasil ditambahkan');
        } else{
            return redirect()->route('master-produk.index')->with('danger','Data baru gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $master_produk_id  = MasterProduk::findOrFail($id);
        $kode_rak          = MasterKodeRak::where('status', 'A')->get();

        return view('master-produk.update',compact('master_produk_id', 'kode_rak'));
    }

    public function delete($id)
    {
        $updated = MasterProduk::where('id', $id)->update([
                'status'        => 'N',
                'updated_at'    => NOW(),
                'updated_by'    => Auth::user()->nama_user
            ]);

        if ($updated){
            return redirect()->route('master-produk.index')->with('success','Master produk berhasil dihapus!');
        } else{
            return redirect()->route('master-produk.index')->with('danger','Master produk gagal dihapus');
        }
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk'    => 'required',
            'keterangan'     => 'required',
        ]);

        $masterProduk = MasterProduk::find($id);

        if (!$masterProduk) {
            return redirect()->route('master-produk.index')->with('danger', 'Data master produk tidak ditemukan');
        }

        $masterProduk->update($request->all());

        return redirect()->route('master-produk.index')->with('success', 'Data master produk berhasil diubah');
    }
}
