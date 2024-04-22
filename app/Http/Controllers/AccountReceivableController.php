<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MasterOutlet;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiPembayaranPiutangHeader;

class AccountReceivableController extends Controller
{
    public function index(){

        $piutang_header = TransaksiPembayaranPiutangHeader::all();
        $invoice        = TransaksiInvoiceHeader::orderBy('noinv', 'asc')->where('flag_batal', 'N')->get();

        return view('account-receivable.index', compact('piutang_header', 'invoice'));
    }

    public function create(){

        $outlet = MasterOutlet::where('status', 'Y')->get();

        return view('account-receivable.create', compact('outlet'));
    }

    public function store(Request $request){

        $newPiutang              = new TransaksiPembayaranPiutangHeader();
        $newPiutang->no_piutang  = TransaksiPembayaranPiutangHeader::no_piutang();

        $request -> validate([
            'kd_outlet' => 'required',
            'nominal'   => 'required',
        ]);

        $nama_outlet    = MasterOutlet::where('kd_outlet', $request->kd_outlet)->value('nm_outlet');
        $area_piutang   = MasterOutlet::where('kd_outlet', $request->kd_outlet)->value('kode_prp');

        if($area_piutang == '6300'){
            $area_piutang = 'KS';
        } elseif ($area_piutang == '6200'){
            $area_piutang = 'KT';
        }

        $request->merge([
            'no_piutang'      => $newPiutang->no_piutang,
            'tanggal_piutang' => $request->tanggal_piutang,
            'area_piutang'    => $area_piutang,
            'kd_outlet'       => $request->kd_outlet,
            'nm_outlet'       => $nama_outlet,
            'nominal_potong'  => $request->nominal,
            'status'          => 'O',
            'created_by'      => Auth::user()->nama_user
        ]);

        $created = TransaksiPembayaranPiutangHeader::create($request->all());

        if ($created){
            return redirect()->route('account-receivable.details', ['no_piutang' => $newPiutang->no_piutang])->with('success','Piutang baru berhasil ditambahkan, silahkan input detail piutang!');
        } else{
            return redirect()->route('account-receivable.index')->with('danger','Data baru gagal ditambahkan');
        }
    }

    public function details($no_piutang){
        $data           = TransaksiPembayaranPiutangHeader::where('no_piutang', $no_piutang)->first();
        $invoice_toko   = TransaksiInvoiceHeader::where('kd_outlet', $data->kd_outlet)->where('status', 'O')->get();
        $invoice        = TransaksiInvoiceHeader::where('status', 'O')->get();

        return view('account-receivable.details', compact('data', 'invoice', 'invoice_toko'));
    }

    public function store_details(Request $request)
    {

        $selectedItems  = $request->input('selected_items', []);

        for ($i = 0; $i < count($selectedItems); $i++) {
            $itemInvoice = $selectedItems[$i];

            $invoice  = TransaksiInvoiceHeader::where('noinv', $itemInvoice)->first();

            $value = [
                'noinv'                 => $invoice->noinv,
                'no_piutang'            => $request->no_piutang,
                'nominal'               => $invoice->details_invoice->sum('nominal_total'),
                'status'                => 'O',
                'created_at'            => NOW(),
                'created_by'            => Auth::user()->nama_user,
            ];

            $created = TransaksiPembayaranPiutangHeader::create($value);
        }

        return redirect()->route('account-receivable.index')->with('success', 'Detail piutang baru berhasil ditambahkan!');
    }

    public function cetak(){

        $outlet  = MasterOutlet::where('status', 'Y')->get();

        return view('account-receivable.search', compact('outlet'));
    }

    public function search(Request $request){

        $request -> validate([
            'kd_outlet' => 'required',
        ]);

        return redirect()->route('account-receivable.dpt' , ['kd_outlet' => $request->kd_outlet])->with('success', 'Menampilkan Daftar Piutang Toko');
    }

    public function dpt($kd_outlet){

        $invoice_selected  = TransaksiInvoiceHeader::where('kd_outlet', $kd_outlet)->where('flag_pembayaran_lunas', 'N')->get();

        return view('account-receivable.dpt', compact('invoice_selected'));
    }

    public function cetak_pdf(Request $request)
    {


        $selectedItems      = $request->input('selected_items', []);
        $data               = TransaksiInvoiceHeader::whereIn('noinv', $selectedItems)->get();


        // Data Pembayaran Tanggal 1-10

        $data1 = TransaksiInvoiceHeader::whereIn('noinv', $selectedItems)
            ->whereIn(DB::raw('DAY(created_at)'), [1, 2, 3, 4, 5, 6, 7, 8, 10])
            ->get();



        dd($data1);

        


        // dd($data->groupBy('created_at')->month()

        // dd($data);
        $pdf                = PDF::loadView('reports.daftar-piutang-toko', ['data'=>$data]);
        $pdf->setPaper('letter', 'landscape');

        return $pdf->stream('piutang-toko.pdf');
    }

    
}
