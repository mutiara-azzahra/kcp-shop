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

        $request -> validate([
            'kategori'  => 'required',
            'trx_date'  => 'required',
        ]);

        $request->merge([
            'kategori'          => $request->kategori,
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

        $balance_debet  = $jurnal_header->details->sum('debet');
        $balance_kredit = $jurnal_header->details->sum('kredit');

        $balancing = $balance_debet - $balance_kredit;

        

        return view('jurnal-pembukuan.details', compact('jurnal_header', 'perkiraan', 'balancing'));
    }

    public function store_details(Request $request){

        $request->validate([
            'id_header'    => 'required',
            'perkiraan'    => 'required',
            'akuntansi_to' => 'required',
            'total'        => 'required',
        ]);

        $perkiraan = MasterPerkiraan::findOrFail($request->perkiraan);

        $value['id_header'] = $request->id_header;
        $value['perkiraan'] = $perkiraan->id_perkiraan;

        if ($request->akuntansi_to == 'D') {
            $value['debet'] = $request->total;
            $value['kredit'] = 0;
        } else {
            $value['debet'] = 0;
            $value['kredit'] = $request->total;
        }

        $value['status'] = 'Y';
        $value['created_by'] = Auth::user()->nama_user;
        $value['created_at'] = now();
        $value['updated_at'] = now();

        TransaksiAkuntansiJurnalDetails::create($value);
            
        return redirect()->route('jurnal-pembukuan.details', ['id' => $request->id_header])->with('success','Data jurnal baru berhasil ditambahkan!');
    }

    public function delete_details($id)
    {
        try {

            $jurnal_details = TransaksiAkuntansiJurnalDetails::findOrFail($id);
            $jurnal_details->delete();

            return redirect()->route('jurnal-pembukuan.details', ['id' => $jurnal_details->id_header])->with('success', 'Data jurnal detail berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('jurnal-pembukuan.details', ['id' => $jurnal_details->id_header])->with('danger', 'Terjadi kesalahan saat menghapus data jurnal detail.');
        }
    }
}
