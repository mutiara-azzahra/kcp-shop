<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterBank;

class MasterBankController extends Controller
{
    public function index(){

        $bank = MasterBank::where('status', 'Y')->get();

        return view('master-bank.index', compact('bank'));
    }

    public function create(){

        return view('master-bank.create');
    }

    public function show($id){

        $master_bank_id = MasterBank::findOrFail($id);

        return view('master-bank.show', compact('master_bank_id'));
       
    }

    public function store(Request $request){

        $request -> validate([
            'kode_bank'   => 'required', 
            'nama_bank'   => 'required',
        ]);

        $request->merge([
            'status'       => 'Y',
            'created_by'   => Auth::user()->nama_user,
        ]);

        $created = MasterBank::create($request->all());

        if ($created){
            return redirect()->route('master-bank.index')->with('success','Data baru berhasil ditambahkan');
        } else{
            return redirect()->route('master-bank.index')->with('danger','Data baru gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $master_bank_id  = MasterBank::findOrFail($id);

        return view('master-bank.update',compact('master_bank_id'));
    }

    public function delete($id)
    {
        try {

            $master_bank = MasterBank::findOrFail($id);
            $master_bank->delete();

            return redirect()->route('master-bank.index')->with('success', 'Data master bank berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('master-bank.index')->with('danger', 'Data master bank gagal dihapus');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_bank'   => 'required',
            'master_bank' => 'required',
        ]);

        $masterBank = MasterBank::find($id);

        if (!$masterBank) {
            return redirect()->route('master-bank.index')->with('danger', 'Data master bank tidak ditemukan');
        }

        $masterBank->update($request->all());

        return redirect()->route('master-bank.index')->with('success', 'Data master bank berhasil diubah');
    }
}
