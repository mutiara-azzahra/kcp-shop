<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterProduk;
use App\Models\MasterSubProduk;

class MasterSubProdukController extends Controller
{
    public function index(){

        $master_sub_produk = MasterSubProduk::where('status', 'A')->get();

        return view('master-sub-produk.index', compact('master_sub_produk'));
    }

    public function create(){

        $master_produk = MasterProduk::where('status', 'A')->get();

        return view('master-sub-produk.create', compact('master_produk'));
    }

    public function show($id){

         $master_produk_id = MasterSubProduk::findOrFail($id);

        return view('master-sub-produk.show', compact('master_produk_id'));
       
    }

    public function store(Request $request){

        $request -> validate([
            'sub_produk'   => 'required',
            'keterangan'   => 'required',
            'kode_produk'  => 'required',
        ]);

        $created = MasterSubProduk::create($request->all());

        if ($created){
            return redirect()->route('master-sub-produk.index')->with('success','Data baru berhasil ditambahkan');
        } else{
            return redirect()->route('master-sub-produk.index')->with('danger','Data baru gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $master_sub_produk_id  = MasterSubProduk::findOrFail($id);
        $master_produk     = MasterProduk::where('status', 'A')->get();

        return view('master-sub-produk.update',compact('master_sub_produk_id', 'master_produk'));
    }

    public function delete($id)
    {
        $updated = MasterSubProduk::where('id', $id)->update([
                'status'        => 'N',
                'updated_at'    => NOW(),
                'updated_by'    => Auth::user()->nama_user
            ]);

        if ($updated){
            return redirect()->route('master-sub-produk.index')->with('success','Master sub produk berhasil dihapus!');
        } else{
            return redirect()->route('master-sub-produk.index')->with('danger','Master sub produk gagal dihapus');
        }
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_produk'    => 'required',
            'keterangan'    => 'required',
            'kode_produk'   => 'required',
        ]);

        $masterProduk = MasterSubProduk::find($id);

        if (!$masterProduk) {
            return redirect()->route('master-sub-produk.index')->with('danger', 'Data master sub produk tidak ditemukan');
        }

        $masterProduk->update($request->all());

        return redirect()->route('master-sub-produk.index')->with('success', 'Data master sub produk berhasil diubah');
    }
}
