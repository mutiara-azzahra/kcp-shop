<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPerkiraan;
use App\Models\KasMasukHeader;
use App\Models\MasterOutlet;
use App\Models\TransferMasukHeader;
use App\Models\TransferMasukDetails;
use App\Models\TransaksiAkuntansiJurnalHeader;
use App\Models\TransaksiAkuntansiJurnalDetails;

class TransferKeluarController extends Controller
{
    public function index(){

        $tf_keluar = TransferMasukHeader::where('status_transfer', 'OUT')->orderBy('created_at', 'desc')->get();

        return view('transfer-keluar.index', compact('tf_keluar'));
    }

    public function create(){

        $perkiraan  = MasterPerkiraan::where('status', 'AKTIF')->get();

        return view('transfer-keluar.create', compact('perkiraan'));
    }

    public function validasi(){

        $tf_kas = TransferMasukHeader::where('status_transfer', 'IN')->orderBy('id_transfer', 'desc')->get();

        return view('transfer-keluar.validasi', compact('tf_kas'));
    }

    public function store(Request $request){

        $request->validate([
            'tanggal_bank'      => 'required',
            'bank'              => 'required',
            'keterangan'        => 'required',
        ]);
    
        $newTransfer              = new TransferMasukHeader();
        $newTransfer->id_transfer = TransferMasukHeader::id_transfer();
        
        $status_transfer = 'OUT';
       
        $requestData = [
            'id_transfer'       => $newTransfer->id_transfer,
            'status_transfer'   => $status_transfer,
            'tanggal_bank'      => $request->tanggal_bank,
            'bank'              => $request->bank,
            'flag_by_toko'      => 'N',
            'flag_kas_ar'       => 'N',
            'keterangan'        => $request->keterangan,
            'status'            => 'O',
            'created_by'        => Auth::user()->nama_user
        ];
    
        $created = TransferMasukHeader::create($requestData);

        //CREATE JURNAL TRANSFER KELUAR
        $jurnal = [
            'trx_date'      => NOW(),
            'trx_from'      => $created->id_transfer,
            'keterangan'    => $request->keterangan,
            'catatan'       => $request->keterangan,
            'kategori'      => 'TRANSFER_KELUAR',
            'created_at'    => NOW(),
            'updated_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user,
        ];

        $jurnal_created = TransaksiAkuntansiJurnalHeader::create($jurnal);
    
        if ($created) {
            return redirect()->route('transfer-keluar.details', ['id_transfer' => $newTransfer->id_transfer])
                ->with('success', 'Transfer keluar berhasil ditambahkan. Tambahkan Details Transfer!');
        } else {
            return redirect()->route('transfer-keluar.index')
                ->with('danger', 'Transfer keluar gagal ditambahkan');
        }
    }

    public function details($id_transfer){

        $perkiraan  = MasterPerkiraan::where('status', 'AKTIF')->get();
        $transfer   = TransferMasukHeader::where('id_transfer', $id_transfer)->first();

        $balance_debet  = $transfer->details->where('akuntansi_to', 'D')->sum('total');
        $balance_kredit = $transfer->details->where('akuntansi_to', 'K')->sum('total');

        $balancing  = $balance_debet - $balance_kredit;

        return view('transfer-keluar.details', compact('perkiraan', 'transfer', 'balancing'));
    }

    public function validasi_data($id_transfer){

        $transfer   = TransferMasukHeader::where('id_transfer', $id_transfer)->first();
        $kas_masuk  = KasMasukHeader::where('id_transfer', $id_transfer)->get();

        return view('transfer-keluar.view', compact('transfer', 'kas_masuk'));
    }

    public function store_details(Request $request){

        $request->validate([
            'id_transfer'  => 'required',
            'perkiraan'    => 'required',
            'akuntansi_to' => 'required',
            'total'        => 'required',
        ]);

        $detail['id_transfer']  = $request->id_transfer;
        $detail['perkiraan']    = $request->perkiraan;
        $detail['akuntansi_to'] = $request->akuntansi_to;
        $detail['total']        = str_replace(',', '', $request->total);
        $detail['created_by']   = Auth::user()->nama_user;
        $detail['created_at']   = now();

        $detail_created         = TransferMasukDetails::create($detail);

        $data = TransaksiAkuntansiJurnalHeader::where('trx_from', $request->id_transfer)->first();

        //CREATE JURNAL TRANSFER MASUK DETAILS
        $value['id_header'] = $data->id;
        $value['perkiraan'] = $request->perkiraan;

        if ($request->akuntansi_to == 'D') {
            $value['debet']  = str_replace(',', '', $request->total);
            $value['kredit'] = 0;
        } else {
            $value['debet']  = 0;
            $value['kredit'] = str_replace(',', '', $request->total);
        }

        $value['id_referensi'] = $detail_created->id;
        $value['status']       = 'Y';
        $value['created_by']   = Auth::user()->nama_user;
        $value['created_at']   = now();
        $value['updated_at']   = now();

        $jurnal_created = TransaksiAkuntansiJurnalDetails::create($value);

            
        return redirect()->route('transfer-keluar.details', ['id_transfer' => $request['id_transfer']])
            ->with('success','Data detail transfer baru berhasil ditambahkan!');
            
        return redirect()->route('transfer-keluar.index')->with('success','Data transfer baru berhasil ditambahkan!');
    }

    public function edit($id_transfer){

        $transfer   = TransferMasukHeader::where('id_transfer', $id_transfer)->first();
        $check      = KasMasukHeader::where('id_transfer', $id_transfer)->first();
        $kas_masuk  = KasMasukHeader::all();
        $outlet     = MasterOutlet::where('status', 'Y')->get();

        return view('transfer-keluar.edit', compact('transfer', 'outlet', 'kas_masuk','check'));
    }

    public function delete($id)
    {
        try {

            $transfer         = TransferMasukHeader::findOrFail($id);
            $jurnal_details   = $transfer->jurnal_header->details;
            $jurnal_header    = $transfer->jurnal_header;
            $details_transfer = $transfer->details;

            $details_transfer->delete();
            $jurnal_details->delete();
            $jurnal_header->delete();
            $transfer->delete();

            return redirect()->route('transfer-keluar.details', ['id_transfer' => $transfer->id_transfer])->with('success', 'Data transfer keluar berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('transfer-keluar.details', ['id_transfer' => $transfer->id_transfer])->with('danger', 'Terjadi kesalahan saat menghapus data transfer keluar.');
        }
    }


    public function delete_details($id)
    {
        try {

            $transfer   = TransferMasukDetails::findOrFail($id);
            $jurnal     = $transfer->jurnal_header->details->where('id_referensi', $transfer->id)->first();
            $jurnal->delete();
            $transfer->delete();

            return redirect()->route('transfer-keluar.details', ['id_transfer' => $transfer->id_transfer])->with('success', 'Data transfer keluar berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('transfer-keluar.details', ['id_transfer' => $transfer->id_transfer])->with('danger', 'Terjadi kesalahan saat menghapus data transfer keluar.');
        }
    }
    
}
