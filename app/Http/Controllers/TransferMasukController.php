<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPerkiraan;
use App\Models\KasMasukHeader;
use App\Models\KasMasukDetails;
use App\Models\MasterOutlet;
use App\Models\MasterBank;
use App\Models\TransferMasukHeader;
use App\Models\TransferMasukDetails;

class TransferMasukController extends Controller
{
    public function index(){

        $tf_masuk           = TransferMasukHeader::where('status_transfer', 'IN')->where('flag_kas_ar', 'N')->orderBy('created_at', 'desc')->get();
        $tf_masuk_validated = TransferMasukHeader::where('flag_kas_ar', 'Y')->orderBy('created_at', 'desc')->get();

        return view('transfer-masuk.index', compact('tf_masuk', 'tf_masuk_validated'));
    }

    public function create(){

        $all_toko   = MasterOutlet::where('status', 'Y')->get();

        return view('transfer-masuk.create', compact('all_toko'));
    }

    public function validasi(){

        $tf_kas = TransferMasukHeader::where('status_transfer', 'IN')->orderBy('id_transfer', 'desc')->get();

        return view('transfer-masuk.validasi', compact('tf_kas'));
    }

    public function store(Request $request){

        $request->validate([
            'tanggal_bank'      => 'required',
            'bank'              => 'required',
            'dari_toko'         => 'required',
            'keterangan'        => 'required',
            'status_transfer'   => 'required',
        ]);
    
        $newTransfer              = new TransferMasukHeader();
        $newTransfer->id_transfer = TransferMasukHeader::id_transfer();
    
        $status_transfer = '';
        $flag_by_toko = '';
    
        if ($request->status_transfer == 1) {
            $status_transfer = 'IN';
            $flag_by_toko = ($request->dari_toko == 1) ? 'Y' : 'N';
        }
    
        $requestData = [
            'id_transfer'       => $newTransfer->id_transfer,
            'status_transfer'   => $status_transfer,
            'tanggal_bank'      => $request->tanggal_bank,
            'bank'              => $request->bank,
            'flag_by_toko'      => $flag_by_toko,
            'keterangan'        => $request->keterangan,
            'status'            => 'O',
            'created_by'        => Auth::user()->nama_user
        ];
    
        $created = TransferMasukHeader::create($requestData);

        if ($created) {
            return redirect()->route('transfer-masuk.details', ['id_transfer' => $newTransfer->id_transfer])
                ->with('success', 'Transfer masuk berhasil ditambahkan. Tambahkan Details');
        } else {
            return redirect()->route('transfer-masuk.index')->with('danger', 'Transfer masuk gagal ditambahkan');
        }
    }

    public function details($id_transfer){

        $perkiraan  = MasterPerkiraan::where('status', 'AKTIF')->get();

        $transfer   = TransferMasukHeader::where('id_transfer', $id_transfer)->first();

        $balance_debet  = $transfer->details->where('akuntansi_to', 'D')->sum('total');
        $balance_kredit = $transfer->details->where('akuntansi_to', 'K')->sum('total');

        $balancing  = $balance_debet - $balance_kredit;

        return view('transfer-masuk.details', compact('transfer', 'balancing', 'perkiraan'));
    }

    public function validasi_data($id_transfer){

        $transfer   = TransferMasukHeader::where('id_transfer', $id_transfer)->first();
        $kas_masuk  = KasMasukHeader::where('id_transfer', $id_transfer)->get();

        return view('transfer-masuk.view', compact('transfer', 'kas_masuk'));
    }

    public function store_details(Request $request){

        $request->validate([
            'id_transfer'  => 'required',
            'perkiraan'    => 'required',
            'akuntansi_to' => 'required',
            'total'        => 'required',
        ]);
    
        $perkiraan = MasterPerkiraan::findOrFail($request['perkiraan']);
    
        TransferMasukDetails::create([
            'id_transfer'   => $request['id_transfer'],
            'perkiraan'     => $perkiraan->id_perkiraan,
            'sub_perkiraan' => $perkiraan->sub_perkiraan,
            'akuntansi_to'  => $request['akuntansi_to'],
            'total'         => $request['total'],
            'created_by'    => Auth::user()->nama_user,
            'created_at'    => now()
        ]);

            
        return redirect()->route('transfer-masuk.details', ['id_transfer' => $request['id_transfer']])
            ->with('success','Data detail transfer baru berhasil ditambahkan!');
    }

    public function edit($id_transfer){

        $transfer_masuk   = TransferMasukHeader::where('id_transfer', $id_transfer)->first();
        $check      = KasMasukHeader::where('id_transfer', $id_transfer)->first();
        $kas_masuk  = KasMasukHeader::all();
        $outlet     = MasterOutlet::where('status', 'Y')->get();
        $all_bank   = MasterBank::where('status', 'Y')->get();

        return view('transfer-masuk.edit', compact('transfer_masuk', 'outlet', 'kas_masuk','check', 'all_bank'));
    }

    public function store_validasi($id_transfer)
    {

        TransferMasukHeader::where('id_transfer', $id_transfer)->update([
            'flag_kas_ar'        => 'Y',
            'updated_at'         => NOW(),
            'updated_by'         => Auth::user()->nama_user
        ]);

        return redirect()->route('transfer-masuk.index')->with('success', 'Transfer masuk baru berhasil ditambahkan kedalam kas masuk');
    }

    public function delete($id)
    {
        try {

            $transfer   = TransferMasukHeader::findOrFail($id);
            $transfer->delete();

            $datails    = TransferMasukDetails::where('id_transfer', $transfer->id_transfer)->delete();

            return redirect()->route('transfer-masuk.details', ['id_transfer' => $transfer->id_transfer])->with('success', 'Data transfer masuk berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('transfer-masuk.details', ['id_transfer' => $transfer->id_transfer])->with('danger', 'Terjadi kesalahan saat menghapus data transfer masuk.');
        }
    }


    public function delete_details($id)
    {
        try {

            $transfer = TransferMasukDetails::findOrFail($id);
            $transfer->delete();

            return redirect()->route('transfer-masuk.details', ['id_transfer' => $transfer->id_transfer])->with('success', 'Data transfer masuk berhasil dihapus!');

        } catch (\Exception $e) {

            return redirect()->route('transfer-masuk.details', ['id_transfer' => $transfer->id_transfer])->with('danger', 'Terjadi kesalahan saat menghapus data transfer masuk.');
        }
    }

    public function store_transfer(Request $request, $id)
    {

        $request->validate([
            'bank'        => 'required',
            'tanggal_bank'  => 'required',
            'keterangan'  => 'required',
        ]);

        $updated = TransferMasukHeader::where('id', $id)->update([
                'bank'          => $request->bank,
                'tanggal_bank'  => $request->tanggal_bank,
                'keterangan'    => $request->keterangan,
                'updated_at'    => NOW(),
                'updated_by'    => Auth::user()->nama_user
            ]);
        
        if ($updated){
            return redirect()->route('transfer-masuk.index')->with('success','Transfer Masuk berhasil diubah!');
        } else{
            return redirect()->route('transfer-masuk.index')->with('danger','Transfer Masuk gagal diubah');
        }   
    }

    
}
