<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterPerkiraan;
use App\Models\TransaksiAkuntansiJurnalHeader;
use App\Models\TransaksiAkuntansiJurnalDetails;

class JurnalPembukuanController extends Controller
{
    public function index(){

        return view('jurnal-pembukuan.index');
    }

    public function create(){

        return view('jurnal-pembukuan.create');
    }

    public function store(Request $request){

        // dd($request->all());

        $request -> validate([
            'kategori'  => 'required',
            'trx_date'  => 'required',
        ]);

        $request->merge([
            'kategori'          => $request->terima_dari,
            'trx_date'          => $request->trx_date,
            'keterangan'        => $request->keterangan,
            'status'            => 'Y',
            'created_by'        => Auth::user()->nama_user,
            'created_at'        => NOW(),
            'updated_at'        => NOW()
        ]);

        $created = TransaksiAkuntansiJurnalHeader::create($request->all());

        if ($created){
            return redirect()->route('jurnal-pembukuan.details', ['id' => $created->id])->with('success', 'Jurnal baru berhasil ditambahkan, tambahkan detail jurnal');
        } else{
            return redirect()->route('jurnal-pembukuan.index')->with('danger','Bukti bayar baru gagal ditambahkan');
        }
    }

    public function details($id){
        
        $jurnal_header = TransaksiAkuntansiJurnalHeader::findOrFail($id);

        $perkiraan  = MasterPerkiraan::where('status', 'AKTIF')->get();

        if (!$jurnal_header) {
            return redirect()->back()->with('warning', 'Jurnal Header tidak ditemukan');
        }

        $balance_debet = $jurnal_header->details->where('akuntansi_to', 'D')->sum('total');
        $balance_kredit = $jurnal_header->details->where('akuntansi_to', 'K')->sum('total');

        $balancing = $balance_debet - $balance_kredit;

        return view('jurnal-pembukuan.details', compact('perkiraan', 'balancing'));
    }
}
