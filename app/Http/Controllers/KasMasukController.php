<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KasMasukHeader;
use App\Models\KasMasukDetails;
use App\Models\MasterKodeRak;
use App\Models\MasterOutlet;
use App\Models\MasterPerkiraan;
use App\Models\TransaksiAkuntansiJurnalHeader;
use App\Models\TransaksiAkuntansiJurnalDetails;

class KasMasukController extends Controller
{
    public function index(){

        $belum_selesai  = KasMasukHeader::where('status', 'O')->get();
        $selesai        = KasMasukHeader::where('status', 'C')->get();

        return view('kas-masuk.index', compact('belum_selesai', 'selesai'));
    }

    public function bukti_bayar(){

        $master_outlet = MasterOutlet::where('status', 'Y')->get();

        return view('kas-masuk.create', compact('master_outlet'));
    }
    public function bayar_manual(){

        $master_outlet = MasterOutlet::where('status', 'Y')->get();

        return view('kas-masuk.bayar-manual', compact('master_outlet'));
    }

    public function store_bukti_bayar(Request $request){

        $request -> validate([
            'tanggal_rincian_tagihan'   => 'required',
            'pembayaran_via'            => 'required',
        ]);

        $newKas                 = new KasMasukHeader();
        $newKas->no_kas_masuk   = KasMasukHeader::no_kas_masuk();

        $request->merge([
            'terima_dari'       => $request->terima_dari,
            'keterangan'        => $request->keterangan,
            'no_kas_masuk'      => $newKas->no_kas_masuk,
            'status'            => 'O',
            'flag_kas_manual'   => 'Y',
            'created_by'        => Auth::user()->nama_user
        ]);

        $created = KasMasukHeader::create($request->all());

        //JURNAL
        $jurnal = [
            'trx_date'      => NOW(),
            'trx_from'      => $created->no_kas_masuk,
            'keterangan'    => $request->keterangan,
            'catatan'       => $request->terima_dari,
            'kategori'      => 'KAS_MASUK',
            'created_at'    => NOW(),
            'updated_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user,
        ];

        $jurnal_created = TransaksiAkuntansiJurnalHeader::create($jurnal);

        if ($created){
            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $newKas->no_kas_masuk, 'id_jurnal' => $jurnal_created->id])->
                with('success', 'Bukti bayar baru berhasil ditambahkan');
        } else{
            return redirect()->route('kas-masuk.index')->with('danger','Bukti bayar baru gagal ditambahkan');
        }
    }

    public function details($no_kas_masuk, $id_jurnal){

        $perkiraan  = MasterPerkiraan::where('status', 'AKTIF')->get();

        $kas_masuk  = KasMasukHeader::where('no_kas_masuk', $no_kas_masuk)->first();

        if (!$kas_masuk) {
            return redirect()->back()->with('warning', 'Nomor Kas masuk tidak ditemukan');
        }

        $balance_debet  = $kas_masuk->details->where('akuntansi_to', 'D')->sum('total');
        $balance_kredit = $kas_masuk->details->where('akuntansi_to', 'K')->sum('total');
        $balancing      = $balance_debet - $balance_kredit;

        $id_jurnal = $id_jurnal;

        return view('kas-masuk.details', compact('kas_masuk', 'balancing', 'perkiraan', 'id_jurnal'));
    }

   public function store(Request $request){

        $request -> validate([
            'tanggal_rincian_tagihan'   => 'required', 
            'kd_outlet'                 => 'required', 
            'pembayaran_via'            => 'required',
            'nominal'                   => 'required',
        ]);

        $outlet = MasterOutlet::where('kd_outlet', $request->kd_outlet)->first();

        $newKas                 = new KasMasukHeader();
        $newKas->no_kas_masuk   = KasMasukHeader::no_kas_masuk();
        
        $request->merge([
            'nominal'           => str_replace(',', '', $request->nominal),
            'terima_dari'       => $outlet->nm_outlet,
            'keterangan'        => 'Pembayaran dari toko ' . $outlet->kd_outlet . '/'. $outlet->nm_outlet,
            'no_bg'             => $request->no_bg,
            'jatuh_tempo_bg'    => $request->jatuh_tempo_bg,
            'no_kas_masuk'      => $newKas->no_kas_masuk,
            'status'            => 'O',
            'created_by'        => Auth::user()->nama_user
        ]);

        $created = KasMasukHeader::create($request->all());

        //KAS MASUK DEBET
        $debit['no_kas_masuk'] = $request->no_kas_masuk;
        $debit['perkiraan']    = 1.1101;
        $debit['akuntansi_to'] = 'D';
        $debit['total']        = str_replace(',', '', $request->nominal);
        $debit['created_at']   = NOW();
        $debit['created_by']   = Auth::user()->nama_user;

        $kas_debit = KasMasukDetails::create($debit);

        //KAS MASUK KREDIT
        $kredit['no_kas_masuk'] = $request->no_kas_masuk;
        $kredit['perkiraan']    = 2.1702;
        $kredit['akuntansi_to'] = 'K';
        $kredit['total']        = str_replace(',', '', $request->nominal);
        $kredit['created_at']   = NOW();
        $kredit['created_by']   = Auth::user()->nama_user;

        $kas_kredit = KasMasukDetails::create($kredit);

        //STORE NOMINAL PERKIRAAN KAS MASUK
        $saldo_debit = MasterPerkiraan::where('id_perkiraan', 1.1101)->value('saldo');
        $saldo_kredit = MasterPerkiraan::where('id_perkiraan', 2.1702)->value('saldo');

        MasterPerkiraan::where('id_perkiraan', 1.1101)->update(['saldo' => $saldo_debit + str_replace(',', '', $request->nominal)]);
        MasterPerkiraan::where('id_perkiraan', 2.1702)->update(['saldo' => $saldo_kredit - str_replace(',', '', $request->nominal)]);

        //CREATE JURNAL KAS MASUK HEADER
        $jurnal = [
            'trx_date'      => NOW(),
            'trx_from'      => $request->no_kas_masuk,
            'keterangan'    => $request->keterangan,
            'catatan'       => $request->terima_dari,
            'kategori'      => 'KAS_MASUK',
            'created_at'    => NOW(),
            'updated_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user,
        ];

        $jurnal_created = TransaksiAkuntansiJurnalHeader::create($jurnal);

        //CREATE JURNAL KAS MASUK DETAILS
        $jurnal_debet['id_header']    = $jurnal_created->id;
        $jurnal_debet['perkiraan']    = 1.1101;
        $jurnal_debet['debet']        = str_replace(',', '', $request->nominal);
        $jurnal_debet['kredit']       = 0;
        $jurnal_debet['id_referensi'] = $kas_debit->id;
        $jurnal_debet['status']       = 'Y';
        $jurnal_debet['created_by']   = Auth::user()->nama_user;
        $jurnal_debet['created_at']   = now();
        $jurnal_debet['updated_at']   = now();

        $jurnal_debet_created = TransaksiAkuntansiJurnalDetails::create($jurnal_debet);

        $jurnal_kredit['id_header']    = $jurnal_created->id;
        $jurnal_kredit['perkiraan']    = 2.1702;
        $jurnal_kredit['debet']        = 0;
        $jurnal_kredit['kredit']       = str_replace(',', '', $request->nominal);
        $jurnal_kredit['id_referensi'] = $kas_kredit->id;
        $jurnal_kredit['status']       = 'Y';
        $jurnal_kredit['created_by']   = Auth::user()->nama_user;
        $jurnal_kredit['created_at']   = now();
        $jurnal_kredit['updated_at']   = now();

        $jurnal_kredit_created = TransaksiAkuntansiJurnalDetails::create($jurnal_kredit);

        if ($created){
            return redirect()->route('kas-masuk.index')->with('success','Kas masuk berhasil ditambahkan');
        } else{
            return redirect()->route('kas-masuk.index')->with('danger','Kas masuk gagal ditambahkan');
        }
    }

    public function store_details(Request $request){

        $request->validate([
            'no_kas_masuk' => 'required',
            'id_perkiraan' => 'required',
            'akuntansi_to' => 'required',
            'total'        => 'required',
        ]);

        //KAS MASUK DETAILS
        $detail['no_kas_masuk'] = $request->no_kas_masuk;
        $detail['perkiraan']    = $request->id_perkiraan;
        $detail['akuntansi_to'] = $request->akuntansi_to;
        $detail['total']        = $request->total;
        $detail['created_at']   = NOW();
        $detail['created_by']   = Auth::user()->nama_user;

        $created_details = KasMasukDetails::create($detail);

        //JURNAL DETAILS

        if($request->akuntansi_to == 'D'){

            $value['id_header']    = $request->id_jurnal;
            $value['perkiraan']    = $request->id_perkiraan;
            $value['debet']        = $request->total;
            $value['kredit']       = 0;
            $value['id_referensi'] = $created_details->id;
            $value['status']       = 'Y';
            $value['created_by']   = Auth::user()->nama_user;
            $value['created_at']   = now();
            $value['updated_at']   = now();

            $jurnal_created = TransaksiAkuntansiJurnalDetails::create($value);

            $jurnal_debit = MasterPerkiraan::where('id_perkiraan', $request->id_perkiraan)->value('saldo');

            MasterPerkiraan::where('id_perkiraan', $request->id_perkiraan)->update(['saldo' => $jurnal_debit + $request->total]);

        } elseif($request->akuntansi_to == 'K'){

            $value['id_header']    = $request->id_jurnal;
            $value['perkiraan']    = $request->id_perkiraan;
            $value['debet']        = 0;
            $value['kredit']       = $request->total;
            $value['id_referensi'] = $created_details->id;
            $value['status']       = 'Y';
            $value['created_by']   = Auth::user()->nama_user;
            $value['created_at']   = now();
            $value['updated_at']   = now();

            $jurnal_created = TransaksiAkuntansiJurnalDetails::create($value);

            $jurnal_kredit = MasterPerkiraan::where('id_perkiraan', $request->id_perkiraan)->value('saldo');

            MasterPerkiraan::where('id_perkiraan', $request->id_perkiraan)->update(['saldo' => $jurnal_kredit - $request->total]);

        }
            
        return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $request->no_kas_masuk, 'id_jurnal' => $request->id_jurnal ])
            ->with('success','Data kas masuk baru berhasil ditambahkan!');
    }

    public function cetak_tanda_terima($no_kas_masuk)
    {

        $update_header = KasMasukHeader::where('no_kas_masuk', $no_kas_masuk)
            ->update([
            'status'        => 'C',
            'updated_at'    => NOW(),
            'updated_by'    => Auth::user()->nama_user
        ]);

        $update_details = KasMasukDetails::where('no_kas_masuk', $no_kas_masuk)
            ->update([
            'status'        => 'C',
            'updated_at'    => NOW(),
            'updated_by'    => Auth::user()->nama_user
        ]);
        
        $data  = KasMasukHeader::where('no_kas_masuk', $no_kas_masuk)->first();
        $pdf   = PDF::loadView('reports.kas-masuk', ['data'=> $data]);
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream('kas-masuk.pdf');
    }

    public function cetak($no_kas_masuk)
    {

        $data  = KasMasukHeader::where('no_kas_masuk', $no_kas_masuk)->first();
        $pdf   = PDF::loadView('reports.kas-masuk', ['data'=> $data]);
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream('kas-masuk.pdf');
    }

    public function delete($id)
    {
        try {

            //PENGURANG DARI SALDO MASTER PART

            $kas = KasMasukHeader::findOrFail($id);

            foreach($kas->details as $i){

                $saldo_perkiraan = MasterPerkiraan::where('id_perkiraan', $i->perkiraan)->value('saldo');

                MasterPerkiraan::where('id_perkiraan', $i->perkiraan)->update(['saldo' => $saldo_perkiraan - $i->total ]);

            }

            //HAPUS KAS MASUK
            $kas_masuk = KasMasukHeader::findOrFail($id);
            $kas_masuk->delete();

            $details_kas_masuk = KasMasukDetails::where('no_kas_masuk', $kas_masuk->no_kas_masuk)->delete();

            //HAPUS JURNAL HEADER  DAN DETAILS
            $header_jurnal = $kas_masuk->jurnal_header->first();
            $header_jurnal->delete();
            $header_jurnal->details()->delete();

            return redirect()->route('kas-masuk.index')->with('success', 'Data kas masuk berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('kas-masuk.index')->with('danger', 'Terjadi kesalahan saat menghapus data Kas masuk.');
        }
    }

    public function delete_details($id)
    {
        try {

            //HAPUS DETAIL KAS MASUK
            $detail_kas_masuk = KasMasukDetails::findOrFail($id);
            $detail_kas_masuk->delete();

            //HAPUS DETAIL JURNAL
            $detail_jurnal = $detail_kas_masuk->header->jurnal_header->details->where('id_referensi', $id)->first();
            $detail_jurnal->delete();

            //PENGURANG DARI SALDO MASTER PART
            $jurnal_debit = MasterPerkiraan::where('id_perkiraan', $detail_jurnal->perkiraan)->value('saldo');

            MasterPerkiraan::where('id_perkiraan', $detail_jurnal->perkiraan)->update(['saldo' => $jurnal_debit - $detail_jurnal->debet - $detail_jurnal->kredit ]);

            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $detail_kas_masuk->no_kas_masuk, 'id_jurnal' => $detail_jurnal->id_header ])->with('success', 'Data kas masuk berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $detail_kas_masuk->no_kas_masuk, 'id_jurnal' => $detail_jurnal->id_header ])->with('danger', 'Terjadi kesalahan saat menghapus data Kas masuk.');
        }
    }

}
