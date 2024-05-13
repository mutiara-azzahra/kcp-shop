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
use App\Models\TransaksiAkuntansiJurnalHeader;
use App\Models\TransaksiAkuntansiJurnalDetails;
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
            'keterangan' => 'required',
        ]);

        $newKeluar              = new TransaksiKasKeluarHeader();
        $newKeluar->no_keluar   = TransaksiKasKeluarHeader::no_keluar();
        
        $request->merge([
            'no_keluar'     => $newKeluar->no_keluar,
            'trx_date'      => $request->trx_date,
            'pembayaran'    => $request->pembayaran,
            'keterangan'    => $request->keterangan,
            'catatan'       => $request->catatan,
            'amount_total'  => str_replace(',', '', $request->nominal),
            'status'        => 'O',
            'created_by'    => Auth::user()->nama_user,
            'created_at'    => now()
        ]);

        $created = TransaksiKasKeluarHeader::create($request->all());

        //CREATE JURNAL KAS KELUAR
        $jurnal = [
            'trx_date'      => $request->trx_date,
            'trx_from'      => $created->no_keluar,
            'keterangan'    => $request->keterangan,
            'catatan'       => $request->pembayaran,
            'kategori'      => 'KAS_KELUAR',
            'created_at'    => NOW(),
            'updated_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user,
        ];

        $jurnal_created = TransaksiAkuntansiJurnalHeader::create($jurnal);

        if ($created){
            return redirect()->route('kas-keluar.details', ['no_keluar' => $newKeluar->no_keluar])
                ->with('success', 'Bukti bayar baru berhasil ditambahkan');
        } else{
            return redirect()->route('kas-keluar.index')->with('danger','Kas Keluar baru gagal ditambahkan');
        }
    }

    public function details($no_keluar){
        
        $perkiraan      = MasterPerkiraan::where('status', 'AKTIF')->get();
        $kas_keluar     = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)->first();

        if (!$kas_keluar) {
            return redirect()->back()->with('warning', 'Nomor Kas Keluar tidak ditemukan');
        }

        $balance_debet = $kas_keluar->details_keluar->where('akuntansi_to', 'D')->sum('total');
        $balance_kredit = $kas_keluar->details_keluar->where('akuntansi_to', 'K')->sum('total');

        $balancing = $balance_debet - $balance_kredit;

        return view('kas-keluar.details', compact('kas_keluar', 'perkiraan', 'balancing'));
    }


   public function store_details(Request $request){

        $request->validate([
            'no_keluar'    => 'required',
            'perkiraan'    => 'required',
            'akuntansi_to' => 'required',
            'total'        => 'required',
            'id_header'    => 'required',
        ]);

        $keluar['no_keluar']    = $request->no_keluar;
        $keluar['perkiraan']    = $request->perkiraan;
        $keluar['akuntansi_to'] = $request->akuntansi_to;
        $keluar['total']        = str_replace(',', '', $request->total);
        $keluar['created_at']   = NOW();
        $keluar['created_by']   = Auth::user()->nama_user;

        $kas_keluar = TransaksiKasKeluarDetails::create($keluar);

        //PENAMBAHAN SALDO PERKIRAAN
        $saldo = MasterPerkiraan::where('id_perkiraan', $request->perkiraan)->value('saldo');
        MasterPerkiraan::where('id_perkiraan', $request->perkiraan)->update(['saldo' => $saldo + str_replace(',', '', $request->total)]);

        //CREATE JURNAL KAS KELUAR DETAILS
        $value['id_header'] = $request->id_header;
        $value['perkiraan'] = $request->perkiraan;

        if ($request->akuntansi_to == 'D') {
            $value['debet']  = str_replace(',', '', $request->total);
            $value['kredit'] = 0;
        } else {
            $value['debet']  = 0;
            $value['kredit'] = str_replace(',', '', $request->total);
        }

        $value['id_referensi'] = $kas_keluar->id;
        $value['status']       = 'Y';
        $value['id_referensi'] = $request->id_header;
        $value['created_by']   = Auth::user()->nama_user;
        $value['created_at']   = now();
        $value['updated_at']   = now();

        TransaksiAkuntansiJurnalDetails::create($value);
            
        return redirect()->route('kas-keluar.details' , ['no_keluar' => $request->no_keluar])
            ->with('success','Data kas keluar baru berhasil ditambahkan!');
    
    }

    public function show($no_keluar){

        $kas_keluar = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)->first();
        $perkiraan  = MasterPerkiraan::all();

       return view('kas-keluar.view', compact('kas_keluar', 'perkiraan'));
    }

    public function delete($id)
    {
        try {

            //PENGURANG DARI SALDO MASTER PART
            $kas = TransaksiKasKeluarHeader::findOrFail($id);

            foreach($kas->details_keluar as $i){
                $saldo_perkiraan = MasterPerkiraan::where('id_perkiraan', $i->perkiraan)->value('saldo');

                MasterPerkiraan::where('id_perkiraan', $i->perkiraan)->update(['saldo' => $saldo_perkiraan - $i->total ]);
            }

            $header_kas_keluar = TransaksiKasKeluarHeader::findOrFail($id);

            //HAPUS JURNAL HEADER  DAN DETAILS
            $header_jurnal = $header_kas_keluar->jurnal_header->first();
            $header_jurnal->delete();
            $header_jurnal->details->delete();

            //HAPUS KAS KELUAR, DETAILS
            $header_kas_keluar->delete();

            $details_kas_keluar = TransaksiKasKeluarDetails::where('no_keluar', $header_kas_keluar->no_keluar)->delete();

            return redirect()->route('kas-keluar.index')->with('success', 'Data kas keluar berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('kas-keluar.index')->with('danger', 'Terjadi kesalahan saat menghapus data Kas Keluar.');
        }
    }

    public function delete_details($id)
    {
        try {

            $detail_kas_keluar = TransaksiKasKeluarDetails::findOrFail($id);

            $saldo_perkiraan = MasterPerkiraan::where('id_perkiraan', $detail_kas_keluar->perkiraan)->value('saldo');

            MasterPerkiraan::where('id_perkiraan', $detail_kas_keluar->perkiraan)->update(['saldo' => $saldo_perkiraan - $detail_kas_keluar->total ]);

            $detail_kas_keluar->delete();

            $detail_jurnal = $detail_kas_keluar->header_keluar->jurnal_header->details->where('id_referensi', $id)->first();
            $detail_jurnal->delete();

            return redirect()->route('kas-keluar.details', ['no_keluar' => $detail_kas_keluar->no_keluar , 'id_header' => $detail_jurnal->id_header ])->with('success', 'Data kas keluar berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('kas-keluar.details', ['no_keluar' => $detail_kas_keluar->no_keluar , 'id_header' => $detail_jurnal->id_header ])->with('danger', 'Terjadi kesalahan saat menghapus data Kas Keluar.');
        }
    }

    public function cetak($no_keluar)
    {
        Config::set('terbilang.locale', 'id');
        $data  = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar)->first();
        $pdf   = PDF::loadView('reports.kas-keluar', ['data'=> $data]);
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream('kas-keluar.pdf');
    }

    public function update($id)
    {

        $no_keluar = TransaksiKasKeluarHeader::findOrFail($id);

        $update_header = TransaksiKasKeluarHeader::where('no_keluar', $no_keluar->no_keluar)
            ->update([
            'status'        => 'C',
            'updated_at'    => NOW(),
            'updated_by'    => Auth::user()->nama_user
        ]);

        $update_details = TransaksiKasKeluarDetails::where('no_keluar', $no_keluar->no_keluar)
            ->update([
            'status'        => 'C',
            'updated_at'    => NOW(),
            'updated_by'    => Auth::user()->nama_user
        ]);

        return redirect()->route('kas-keluar.index')->with('success','Data kas keluar baru berhasil diselesaikan!');
        

    }



}
