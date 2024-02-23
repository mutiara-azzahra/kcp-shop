<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use PDF;
use Terbilang;
use Config;
use Carbon\Carbon;
use App\Models\TransaksiKasKeluarHeader;
use App\Models\TransaksiKasKeluarDetails;
use App\Models\MasterPerkiraan;


class KasKeluarController extends Controller
{
    public function index(){

        $belum_selesai = TransaksiKasKeluarHeader::orderBy('no_keluar', 'desc')->where('status', 'O')->get();

        $selesai = TransaksiKasKeluarHeader::orderBy('no_keluar', 'desc')->where('status', 'C')->get();

        return view('kas-keluar.index', compact('belum_selesai', 'selesai'));
    }

    public function create(){

        return view('kas-keluar.create');
    }

    public function store(Request $request){

        $request -> validate([
            'trx_date'   => 'required',
            'keterangan'          => 'required',
        ]);

        $newKeluar              = new TransaksiKasKeluarHeader();
        $newKeluar->no_keluar   = TransaksiKasKeluarHeader::no_keluar();
        
        $request->merge([
            'no_keluar'         => $newKeluar->no_keluar,
            'trx_date'          => $request->trx_date,
            'pembayaran'        => $request->pembayaran,
            'keterangan'        => $request->keterangan,
            'status'            => 'O',
            'created_by'        => Auth::user()->nama_user
        ]);

        $created = TransaksiKasKeluarHeader::create($request->all());

        if ($created){
            return redirect()->route('kas-keluar.details', ['no_keluar' => $newKeluar->no_keluar])->with('success', 'Bukti bayar baru berhasil ditambahkan');
        } else{
            return redirect()->route('kas-keluar.index')->with('danger','Kas Keluar baru gagal ditambahkan');
        }
    }

    public function details($no_keluar){

        $debet = MasterPerkiraan::where('sts_perkiraan', 'D')->get();
        $kredit = MasterPerkiraan::where('sts_perkiraan', 'K')->get();

        $kas_keluar = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)->first();

        if (!$kas_keluar) {
            return redirect()->back()->with('warning', 'Nomor Kas Keluar tidak ditemukan');
        }

        $balance_debet = $kas_keluar->details_keluar->where('akuntansi_to', 'D')->sum('total');
        $balance_kredit = $kas_keluar->details_keluar->where('akuntansi_to', 'K')->sum('total');

        $balancing = $balance_debet - $balance_kredit;
        if ($balancing != 0) {
            return view('kas-keluar.details', compact('kas_keluar', 'debet', 'kredit'))->with('warning', 'Nominal Kas Keluar tidak seimbang. Periksa kembali data.');
        }

        return view('kas-keluar.details', compact('kas_keluar', 'debet', 'kredit'));
    }


   public function store_details(Request $request){

        $request->validate([
            'no_keluar'    => 'required',
            'perkiraan'    => 'required',
            'akuntansi_to' => 'required',
            'total'        => 'required',
        ]);
        
        $perkiraan = MasterPerkiraan::findOrFail($request['perkiraan']);
    
        TransaksiKasKeluarDetails::create([
            'no_keluar'     => $request['no_keluar'],
            'perkiraan'     => $perkiraan ? $perkiraan->perkiraan . '.' . $perkiraan->sub_perkiraan : null,
            'akuntansi_to'  => $request['akuntansi_to'],
            'total'         => $request['total'],
            'created_at'    => NOW(),
        ]);
            
        return redirect()->route('kas-keluar.index')->with('success','Data kas keluar baru berhasil ditambahkan!');
    
    }

    public function show($no_keluar){

        $kas_keluar = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)->first();
        $perkiraan  = MasterPerkiraan::all();

       return view('kas-keluar.view', compact('kas_keluar', 'perkiraan'));
    }

    public function delete($id)
    {
        $header     = TransaksiKasKeluarHeader::findOrFail($id);
        $no_keluar  = $header->no_keluar;

        TransaksiKasKeluarDetails::where('no_keluar', $no_keluar)->delete();

        $header->delete();

        return redirect()->route('kas-keluar.index')->with('success', 'Data berhasil dihapus');
    }

    public function delete_details($id)
    {
        $details    = TransaksiKasKeluarDetails::findOrFail($id);
        $no_keluar  = TransaksiKasKeluarHeader::where('no_keluar', $details->no_keluar)->value('no_keluar');

        $details->delete();

        return redirect()->route('kas-keluar.show', $no_keluar)->with('success', 'Data berhasil dihapus');
    }

    public function cetak($no_keluar)
    {
        Config::set('terbilang.locale', 'id');
        $data  = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)->first();
        $pdf   = PDF::loadView('reports.kas-keluar', ['data'=> $data]);
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream('kas-keluar.pdf');
    }

    public function update($no_keluar)
    {

        $update_header = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)
            ->update([
            'status'        => 'C',
            'updated_at'    => NOW(),
            'updated_by'    => Auth::user()->nama_user
        ]);

        $update_details = TransaksiKasKeluarDetails::where('no_keluar', $no_keluar)
            ->update([
            'status'        => 'C',
            'updated_at'    => NOW(),
            'updated_by'    => Auth::user()->nama_user
        ]);

        return redirect()->route('kas-keluar.index')->with('success','Data kas keluar baru berhasil ditambahkan!');
        

    }



}
