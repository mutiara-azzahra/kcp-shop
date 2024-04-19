<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Models\TransaksiSpHeader;
use App\Models\MasterPart;
use App\Models\MasterSales;
use App\Models\MasterOutlet;
use App\Models\MasterStokGudang;
use App\Models\TransaksiSpDetails;
use App\Models\StokGudang;
use App\Models\MasterAreaSales;
use App\Models\MasterDiskonPart;


class SuratPesananController extends Controller
{
    public function index(){

        $surat_pesanan = TransaksiSpHeader::orderBy('crea_date', 'desc')->where('status', 'O')->get();

        return view('surat-pesanan.index', compact('surat_pesanan'));
    }

    public function create(){

        // sales 1 : normal sales, sales 2 : kanvasing sales

        $sales      = MasterSales::where('sales', Auth::user()->username)->value('id');
        $all_sales  = MasterSales::where('status', 'A')->get();
        $toko       = MasterAreaSales::where('id_sales', $sales)->get();
        $all_toko   = MasterOutlet::where('status', 'Y')->get();
        $toko_kanvas= MasterOutlet::whereIn('kd_outlet', ['NW', 'VK'])->get();

        return view('surat-pesanan.create', compact('sales', 'toko', 'all_toko', 'all_sales', 'toko_kanvas'));
    }

    public function store(Request $request){

        $newSp          = new TransaksiSpHeader();
        $newSo          = new TransaksiSpHeader();
        $newSp->nosp    = TransaksiSpHeader::nosp();
        $newSo->noso    = TransaksiSpHeader::noso();

        $nama_sales ='';

        if($request->sales != null){
            $nama_sales     = MasterSales::where('sales', $request->sales)->value('sales');

        } else {
            $nama_sales     = MasterSales::where('sales', Auth::user()->username)->value('sales');
        }

        $request -> validate([
            'kd_outlet' => 'required',
        ]);

        $nama_outlet    = MasterOutlet::where('kd_outlet', $request->kd_outlet)->value('nm_outlet');
        $area_sp        = MasterOutlet::where('kd_outlet', $request->kd_outlet)->value('kode_prp');

        if($area_sp == '6300'){
            $area_sp = 'KS';
        } elseif ($area_sp == '6200'){
            $area_sp = 'KT';
        }

        $request->merge([
            'nosp'      => $newSp->nosp,
            'noso'      => $newSo->noso,
            'status'    => 'O',
            'area_sp'   => $area_sp,
            'nm_outlet' => $nama_outlet,
            'user_sales'=> $nama_sales,
            'crea_date' => NOW(),
            'crea_by'   => Auth::user()->nama_user
        ]);

        $created = TransaksiSpHeader::create($request->all());

        if ($created){
            return redirect()->route('surat-pesanan.detail', ['nosp' => $created->nosp])->with('success','Invoice header Berhasil ditambahkan, silahkan input details Invoice');
        } else{
            return redirect()->route('surat-pesanan.index')->with('danger','Data baru gagal ditambahkan');
        }
    }

    public function detail($nosp)
    {
        $details        = TransaksiSpHeader::where('nosp', $nosp)->first();
        $total          = TransaksiSpDetails::where('nosp', $nosp)->get();
        $master_part    = MasterPart::where('status', 'A')->get();
        $part_kanvasan  = StokGudang::where('id_rak', '33')->get();
        $check          = TransaksiSpDetails::where('nosp', $nosp)->first();

        $totalSum = 0;
        
        return view('surat-pesanan.details', ['nosp' => $nosp] ,compact('master_part', 'details', 'check', 'part_kanvasan'));
    }

    public function detail_sp($nosp)
    {
        $details        = TransaksiSpHeader::where('nosp', $nosp)->first();
        $master_part    = MasterPart::all();

        return view('surat-pesanan.details-sp', ['nosp' => $nosp] ,compact('master_part', 'details'));
    }

    public function store_details(Request $request){

        $request->validate([
            'inputs.*.nosp'    => 'required',
            'inputs.*.part_no' => 'required',
            'inputs.*.qty'     => 'required',
        ]);

        foreach($request->inputs as $key => $value){

            $harga_het      = MasterPart::where('part_no', $value['part_no'])->value('het');
            $diskon_maks    = MasterDiskonPart::where('part_no', $value['part_no'])->value('diskon_maksimal');

            $value['hrg_pcs'] = $harga_het;

            if($value['disc'] == null){
                $value['disc'] = 0;
            }

            $value['disc']          = $value['disc'];
            $value['nominal']       = $harga_het * $value['qty'];
            $value['nominal_disc']  = ($harga_het * $value['qty'] * $value['disc'])/100;
            $value['nominal_total'] = $value['nominal'] - $value['nominal_disc'];
            $value['crea_date']     = NOW();

            TransaksiSpDetails::create($value);
            
        }        
        
        return redirect()->route('surat-pesanan.index')->with('success','Data baru berhasil ditambahkan!');
        
    }
}
