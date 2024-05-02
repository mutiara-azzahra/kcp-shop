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

        if ($created){
            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $newKas->no_kas_masuk])->with('success', 'Bukti bayar baru berhasil ditambahkan');
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
        $detail_debet = KasMasukDetails::create([
            'no_kas_masuk'  => $request->no_kas_masuk,
            'perkiraan'     => 1.1101,
            'akuntansi_to'  => 'D',
            'total'         => str_replace(',', '', $request->nominal),
            'created_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user
        ]);

        //KAS MASUK DEBET
        $detail_kredit = KasMasukDetails::create([
            'no_kas_masuk'  => $request->no_kas_masuk,
            'perkiraan'     => 2.1702,
            'akuntansi_to'  => 'K',
            'total'         => str_replace(',', '', $request->nominal),
            'created_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user
        ]);

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
        $jurnal_debet['id_referensi'] = $detail_debet->id;
        $jurnal_debet['status']       = 'Y';
        $jurnal_debet['created_by']   = Auth::user()->nama_user;
        $jurnal_debet['created_at']   = now();
        $jurnal_debet['updated_at']   = now();

        $jurnal_created = TransaksiAkuntansiJurnalDetails::create($jurnal_debet);

        $jurnal_kredit['id_header']    = $jurnal_created->id;
        $jurnal_kredit['perkiraan']    = 2.1702;
        $jurnal_kredit['debet']        = 0;
        $jurnal_kredit['kredit']       = str_replace(',', '', $request->nominal);
        $jurnal_kredit['id_referensi'] = $detail_kredit->id;
        $jurnal_kredit['status']       = 'Y';
        $jurnal_kredit['created_by']   = Auth::user()->nama_user;
        $jurnal_kredit['created_at']   = now();
        $jurnal_kredit['updated_at']   = now();

        $jurnal_created = TransaksiAkuntansiJurnalDetails::create($jurnal_kredit);

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
    
        $created_details = KasMasukDetails::create([
            'no_kas_masuk'  => $request->no_kas_masuk,
            'perkiraan'     => $request->id_perkiraan,
            'akuntansi_to'  => $request->akuntansi_to,
            'total'         => $request->total,
            'created_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user,
        ]);

        //JURNAL DETAILS

        if($request->akuntansi_to == 'D'){

            $value['id_header']    = $request->id_header;
            $value['perkiraan']    = $request->id_perkiraan;
            $value['debet']        = $request->total;
            $value['kredit']       = 0;
            $value['id_referensi'] = $created_details->id;
            $value['status']       = 'Y';
            $value['created_by']   = Auth::user()->nama_user;
            $value['created_at']   = now();
            $value['updated_at']   = now();

            $jurnal_created = TransaksiAkuntansiJurnalDetails::create($value);

        } elseif($request->akuntansi_to == 'K'){

            $value['id_header']    = $request->id_header;
            $value['perkiraan']    = $request->id_perkiraan;
            $value['debet']        = 0;
            $value['kredit']       = $request->total;
            $value['id_referensi'] = $created_details->id;
            $value['status']       = 'Y';
            $value['created_by']   = Auth::user()->nama_user;
            $value['created_at']   = now();
            $value['updated_at']   = now();

            $jurnal_created = TransaksiAkuntansiJurnalDetails::create($value);

        }
            
        return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $request->no_kas_masuk, 'id_jurnal' => $request->id_header ])
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

            $kas_masuk = KasMasukHeader::findOrFail($id);
            $kas_masuk->delete();

            $details_kas_masuk = KasMasukDetails::where('no_kas_masuk', $kas_masuk->no_kas_masuk)->delete();


            $jurnal_detail = $detail_kas_keluar->header_keluar->jurnal_header->details->where('perkiraan', $detail_kas_keluar->perkiraan)->first();
            $jurnal_detail->delete();

            $id_header = $detail_kas_keluar->header_keluar->jurnal_header->id;

            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $kas_masuk->no_kas_masuk])->with('success', 'Data kas masuk berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $kas_masuk->no_kas_masuk])->with('danger', 'Terjadi kesalahan saat menghapus data Kas masuk.');
        }
    }

    public function delete_details($id)
    {
        try {

            $detail_kas_masuk = KasMasukDetails::findOrFail($id);
            $detail_kas_masuk->delete();

            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $detail_kas_masuk->no_kas_masuk])->with('success', 'Data kas masuk berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('kas-masuk.details', ['no_kas_masuk' => $detail_kas_masuk->no_kas_masuk])->with('danger', 'Terjadi kesalahan saat menghapus data Kas masuk.');
        }
    }

}
