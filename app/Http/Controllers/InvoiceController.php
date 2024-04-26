<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use App\Models\StokGudang;
use App\Models\MasterStokGudang;
use App\Models\TransaksiSOHeader;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiInvoiceDetails;
use App\Models\FlowStokGudang;
use App\Models\ModalPartTerjual;

class InvoiceController extends Controller
{
    public function index(){

        $so_approved = TransaksiSOHeader::where('flag_approve', 'Y')
        ->where('flag_packingsheet', 'Y')
        ->where('flag_invoice', 'N')
        ->get();

        $invoice = TransaksiInvoiceHeader::where('flag_batal', 'N')->get();

        return view('invoice.index', compact('so_approved', 'invoice'));
    }
    public function create(){

        return view('invoice.create');
    }

    public function approve($noso){

        TransaksiSOHeader::where('noso', $noso)->update([
                'flag_invoice'      => 'Y',
                'flag_invoice_date' => NOW(),
            ]);

        $newInv         = new TransaksiInvoiceHeader();
        $newInv->noinv  = TransaksiInvoiceHeader::noinv();
        $so_to_invoice  = TransaksiSOHeader::where('noso', $noso)->first();

        $top = NOW()->addDays($so_to_invoice->outlet->jth_tempo);

        //CREATE INVOICE HEADER
        $data['noinv']              = $newInv->noinv;
        $data['noso']               = $so_to_invoice->noso;
        $data['kd_outlet']          = $so_to_invoice->kd_outlet;
        $data['nm_outlet']          = $so_to_invoice->nm_outlet;
        $data['tgl_jatuh_tempo']    = $top;
        $data['status']             = 'O';
        $data['ket_status']         = 'OPEN';
        $data['user_sales']         = $so_to_invoice->user_sales;
        $data['user_sales']         = $so_to_invoice->user_sales;
        $data['created_by']         = Auth::user()->nama_user;
        
        $header = TransaksiInvoiceHeader::create($data);

        //CREATE JURNAL HEADER

        // Penjualan (k) 4.1000

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

        //CREATE JURNAL KAS KELUAR DETAILS: DEBET
        $debet['id_header']  = $jurnal_created->id;
        $debet['perkiraan']  = 1.1300;
        $debet['debet']      = $so_to_invoice->details_so->sum('nominal_total');
        $debet['kredit']     = 0;
        $debet['status']     = 'Y';
        $debet['created_by'] = Auth::user()->nama_user;
        $debet['created_at'] = now();
        $debet['updated_at'] = now();

        TransaksiAkuntansiJurnalDetails::create($debet);

        //CREATE JURNAL KAS KELUAR DETAILS: KREDIT
        $kredit['id_header']  = $jurnal_created->id;
        $kredit['perkiraan']  = 4.1000;
        $kredit['debet']      = 0;
        $kredit['kredit']     = $so_to_invoice->details_so->sum('nominal_total');
        $kredit['status']     = 'Y';
        $kredit['created_by'] = Auth::user()->nama_user;
        $kredit['created_at'] = now();
        $kredit['updated_at'] = now();

        TransaksiAkuntansiJurnalDetails::create($kredit);

        //CREATE DETAILS INVOICE
        foreach($so_to_invoice->details_so as $s){

            $stok_ready = MasterStokGudang::where('part_no', $s->part_no)->value('stok');
            $stok_akhir = $stok_ready - $s->qty;

            MasterStokGudang::where('part_no', $s->part_no)->update(['stok' => $stok_akhir]);
            
            $details['noinv']              = $header->noinv;
            $details['area_inv']           = $s->area_so;
            $details['kd_outlet']          = $so_to_invoice->kd_outlet;
            $details['part_no']            = $s->part_no;
            $details['nm_part']            = $s->nm_part;
            $details['qty']                = $s->qty;
            $details['hrg_pcs']            = $s->hrg_pcs;
            $details['disc']               = $s->disc;
            $details['nominal']            = $s->nominal;
            $details['nominal_disc']       = $s->nominal_disc;
            $details['nominal_disc_ppn']   = $so_to_invoice->nominal_total * 0.11;
            $details['nominal_total']      = $s->nominal_total;

            TransaksiInvoiceDetails::create($details);

        }

        return redirect()->route('invoice.index')->with('success','SO baru berhasil diteruskan menjadi invoice');

    }

    public function reject($noso){

        return redirect()->route('invoice.index')->with('success','Data baru berhasil ditambahkan');

    }

    public function cetak($noinv)
    {
        $data               = TransaksiInvoiceHeader::where('noinv', $noinv)->first();
        $invoice_details    = TransaksiInvoiceDetails::where('noinv', $noinv)->get();
        $pdf                = PDF::loadView('reports.invoice', ['data'=>$data], ['invoice_details'=>$invoice_details]);
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream('invoice.pdf');
    }
}
