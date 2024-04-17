<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterStokGudang;
use App\Models\MasterPart;
use App\Models\BarangMasukHeader;
use App\Models\BarangMasukDetails;
use App\Models\MasterKodeRak;
use App\Models\IntransitDetails;
use App\Models\TransaksiInvoiceDetails;
use App\Models\StokGudang;
use App\Models\FlowStokGudang;

class StokGudangController extends Controller
{
    public function index(){

        $stok_gudang = MasterStokGudang::where('status', 'A')->get();

        return view('stok-gudang.index', compact('stok_gudang'));
    }

    public function create(){

        $master_part = MasterPart::where('status', 'A')->get();

        return view('stok-gudang.create', compact('master_part'));
    }

    public function create_barang_masuk(){

        return view('stok-gudang.tambah');
    }

    public function store_barang_masuk(Request $request){

        $request -> validate([
            'invoice_non'  => 'required', 
            'customer_to'  => 'required',
            'supplier'     => 'required',
            'tanggal_nota' => 'required',
        ]);

        $existingRecord = BarangMasukHeader::where('invoice_non', $request->invoice_non)->first();

        if(isset($existingRecord)){

            return redirect()->route('stok-gudang.index')->with('danger','Nomor Nota '. $request->invoice_non .' sudah terdata! ');

        } else {

            $value['invoice_non']   = $request->invoice_non;
            $value['customer_to']   = $request->customer_to;
            $value['supplier']      = $request->supplier;
            $value['tanggal_nota']  = $request->tanggal_nota;
            $value['created_at']    = NOW();
            $value['created_by']    = Auth::user()->nama_user;

            $created = BarangMasukHeader::create($value);

            if ($created){

                $id = $created->id;

                return redirect()->route('stok-gudang.add-details', ['id' => $id])->with('success', 'Data stok gudang baru berhasil ditambahkan');

            } else{
                return redirect()->route('stok-gudang.index')->with('danger','Data stok gudang baru gagal ditambahkan');
            }

        }

    }

    public function add_details($id)
    {
        $header         = BarangMasukHeader::findOrFail($id);
        $master_part    = MasterPart::where('status', 'A')->get();
        $rak            = MasterKodeRak::where('status', 'A')->get();

        return view('stok-gudang.add-details',compact('header', 'master_part', 'rak'));
    }

    public function store_add_details(Request $request){

        $request->validate([
            'inputs.*.part_no' => 'required',
            'inputs.*.qty'     => 'required',
            'inputs.*.id_rak'  => 'required',
        ]);

        foreach($request->inputs as $key => $value){
            $value['part_no']       = $value['part_no'];
            $value['qty']           = $value['qty'];
            $value['id_rak']        = $value['id_rak'];
            $value['created_by']    = Auth::user()->nama_user;
            $value['created_at']    = NOW();

            $created = BarangMasukDetails::create($value);
        }       
                    
        if ($created){
            return redirect()->route('stok-gudang.index')->with('success','Silahkan Validasi Barang Masuk pada Menu Intransit!');
        } else{
            return redirect()->route('stok-gudang.index')->with('danger','Data stok gudang baru gagal ditambahkan');
        }
        
    }
    
    public function store(Request $request){

        $request -> validate([
            'part_no'      => 'required', 
            'stok'         => 'required',
        ]);

        $created = MasterStokGudang::create($request->all());

        if ($created){
            return redirect()->route('stok-gudang.index')->with('success','Data stok gudang baru berhasil ditambahkan');
        } else{
            return redirect()->route('stok-gudang.index')->with('danger','Data stok gudang baru gagal ditambahkan');
        }
    }

    public function delete($id)
    {
        $updated = MasterStokGudang::where('id', $id)->update([
                'status'         => 'N',
                'updated_at'     => NOW(),
                'updated_by'     => Auth::user()->nama_user
            ]);

        if ($updated){
            return redirect()->route('stok-gudang.index')->with('success','Stok Gudang berhasil dihapus!');
        } else{
            return redirect()->route('stok-gudang.index')->with('danger','Stok Gudang gagal dihapus');
        }
        
    }

    public function edit($id)
    {
        $stok_id  = MasterStokGudang::findOrFail($id);

        return view('stok-gudang.update',compact('stok_id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok'     => 'required|integer',
        ]);

        $stok_gudang = MasterStokGudang::find($id);

        if (!$stok_gudang) {
            return redirect()->route('stok-gudang.index')->with('danger', 'Data master part tidak ditemukan');
        }

        $stok_gudang->update($request->all());

        return redirect()->route('stok-gudang.index')->with('success', 'Data master part berhasil diubah');
    }

    public function show($id)
    {
        $stok_id        = MasterStokGudang::findOrFail($id);
        $barang_terjual = TransaksiInvoiceDetails::where('part_no', $stok_id->part_no)->get();
        $barang_masuk   = BarangMasukDetails::where('part_no', $stok_id->part_no)->get();
        $stok_rak       = StokGudang::where('part_no', $stok_id->part_no)->get();
        $kartu_stok     = FlowStokGudang::where('part_no', $stok_id->part_no)->get();

        return view('stok-gudang.show',compact('stok_id', 'barang_masuk', 'barang_terjual', 'stok_rak', 'kartu_stok'));
    }

    public function list(){

        $list_barang_masuk = BarangMasukHeader::orderBy('created_at', 'desc')->get();

        return view('stok-gudang.list', compact('list_barang_masuk'));
    }

    public function list_details($id)
    {
        $header         = BarangMasukHeader::findOrFail($id);
        $master_part    = MasterPart::where('status', 'A')->get();
        $rak            = MasterKodeRak::where('status', 'A')->get();

        return view('stok-gudang.list-details',compact('header', 'master_part', 'rak'));
    }

    public function store_list_details(Request $request){

        $request->validate([
            'inputs.*.invoice_non' => 'required',
            'inputs.*.part_no'     => 'required',
            'inputs.*.qty'         => 'required',
            'inputs.*.id_rak'      => 'required',
        ]);

        foreach($request->inputs as $key => $value){
            $value['invoice_non']   = $value['invoice_non'];
            $value['part_no']       = $value['part_no'];
            $value['qty']           = $value['qty'];
            $value['id_rak']        = $value['id_rak'];
            $value['created_by']    = Auth::user()->nama_user;
            $value['created_at']    = NOW();

            $created = BarangMasukDetails::create($value);
        }       
                    
        if ($created){
            return redirect()->route('stok-gudang.list')->with('success','Silahkan Validasi Barang Masuk pada Menu Intransit!');
        } else{
            return redirect()->route('stok-gudang.index')->with('danger','Data stok gudang baru gagal ditambahkan');
        }
        
    }

    
}
