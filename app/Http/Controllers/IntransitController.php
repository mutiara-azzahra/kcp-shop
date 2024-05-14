<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Models\IntransitHeader;
use App\Models\IntransitDetails;
use App\Models\MasterPart;
use App\Models\MasterStokGudang;
use App\Models\BarangMasukHeader;
use App\Models\BarangMasukDetails;
use App\Models\FlowStokGudang;

class IntransitController extends Controller
{
    public function index(){

        $intransit_header = IntransitHeader::orderBy('created_at', 'desc')->get();

        return view('intransit.index', compact('intransit_header'));
    }

    public function create(){

        $invoice_non = BarangMasukHeader::all();

        return view('intransit.create', compact('invoice_non'));
    }

    public function store(Request $request){

        $request -> validate([
            'no_surat_pesanan'     => 'required', 
            'tanggal_packingsheet' => 'required', 
        ]);

        $request['status']  = 'I';

        $created = IntransitHeader::create($request->all());

        if ($created){
            return redirect()->route('intransit.details', ['id' => $created->id])->with('success','Intransit header Berhasil ditambahkan, silahkan input details Intrasit');
        } else{
            return redirect()->route('intransit.index')->with('danger','Data baru gagal ditambahkan');
        }
    }

    public function details($id)
    {
        $intransit_header  = IntransitHeader::findOrFail($id);
        $details           = BarangMasukDetails::where('invoice_non', $intransit_header->no_surat_pesanan)->get();
        $master_part       = MasterPart::all();

        return view('intransit.details',compact('intransit_header', 'master_part', 'details'));
    }

    public function store_details(Request $request){

        $no_surat_pesanan   = $request->input('no_surat_pesanan');
        $details_intransit  = BarangMasukDetails::where('invoice_non', $no_surat_pesanan)->get();
    
        try {
            foreach ($details_intransit as $value) {
                $value->no_surat_pesanan = $no_surat_pesanan;
                $value->status           = 'I';
                $value->created_at       = now();
                $value->created_by       = Auth::user()->nama_user;
    
                IntransitDetails::create([
                    'no_surat_pesanan' => $value->no_surat_pesanan,
                    'part_no'          => $value->part_no,
                    'qty'              => $value->qty,
                    'status'           => $value->status,
                    'created_at'       => $value->created_at,
                    'created_by'       => $value->created_by,
                ]);

            }
    
            return redirect()->route('intransit.index')->with('success', 'Barang intransit berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('intransit.index')->with('danger', 'Gagal menambahkan barang intransit: ' . $e->getMessage());
        }
        
    }

    public function tambah_gudang($id)
    {
        $intransit_header  = IntransitHeader::findOrFail($id);

        return view('intransit.validasi',compact('intransit_header'));
    }

    public function validasi($id)
    {
        $intransit_header  = IntransitHeader::findOrFail($id);

        return view('intransit.validasi',compact('intransit_header'));
    }

    public function validasi_barang($id)
    {

        $intransit_header       = IntransitHeader::where('id', $id)->update(["status" => "T"]);
        $header                 = IntransitHeader::where('id', $id)->value('no_surat_pesanan');

        IntransitDetails::where('no_surat_pesanan', $header)->update(['status' => 'T']);

        $id_intransit_header    = IntransitHeader::where('id',$id)->value('no_surat_pesanan');

        return redirect()->route('intransit.stok_masuk', ['id_intransit_header' => $id_intransit_header])->with('success', 'Data berhasil divalidasi');
        
    }

    public function stok_masuk($no_surat_pesanan)
    {
        $intransit_details = IntransitDetails::where('no_surat_pesanan', $no_surat_pesanan)->get();

        return view('intransit.stok-masuk',compact('intransit_details'))->with('success', 'Data berhasil divalidasi, silahkan tambahkan barang ke gudang');
        
    }

    public function store_stok_gudang(Request $request, $part_no)
    {

        $selectedItems      = $request->input('selected_items', []);
        $no_surat_pesanans  = $request->input('no_surat_pesanan', []);

        for ($i = 0; $i < count($selectedItems); $i++) {
            $itemPartNo         = $selectedItems[$i];
            $no_surat_pesanan   = $no_surat_pesanans[$i];

            $stok_lama  = MasterStokGudang::where('part_no', $itemPartNo)->value('stok');
    
            $stok_masuk = IntransitDetails::where('part_no', $itemPartNo)
                ->where('no_surat_pesanan', $no_surat_pesanan)
                ->value('qty');
 
            MasterStokGudang::where('part_no', $itemPartNo)->update(['stok' => $stok_lama + $stok_masuk]);

            $rak = BarangMasukDetails::where('part_no', $itemPartNo)
                ->where('invoice_non', $no_surat_pesanan)
                ->value('id_rak');

            //LIST BARANG MASUK, KARTU STOK
            $stok_awal_barang = FlowStokGudang::where('part_no', $itemPartNo)->orderBy('created_at', 'desc')->value('stok_akhir');
            
            if(isset($stok_awal_barang)) {
                $stok_awal = $stok_awal_barang;
            } else{
                $stok_awal = 0;
            }

            $value['part_no']              = $itemPartNo;
            $value['keterangan']           = 'Barang Masuk';
            $value['referensi']            = $no_surat_pesanan;
            $value['tanggal_barang_masuk'] = NOW();
            $value['stok_awal']            = $stok_awal;
            $value['stok_masuk']           = $stok_masuk;
            $value['stok_keluar']          = 0;
            $value['stok_akhir']           = $stok_awal + $stok_masuk;

            FlowStokGudang::create($value);

        }

        return redirect()->route('intransit.index')->with('success', 'Barang berhasil dimasukkan ke gudang');
    }

}
