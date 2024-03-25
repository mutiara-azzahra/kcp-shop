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
    public function store(Request $request){

        return redirect()->route('invoice.index')->with('succes','Data baru berhasil ditambahkan');

    }

    public function approve($noso){

        TransaksiSOHeader::where('noso', $noso)->update([
                'flag_invoice'      => 'Y',
                'flag_invoice_date' => NOW(),
            ]);

        $newInv         = new TransaksiInvoiceHeader();
        $newInv->noinv  = TransaksiInvoiceHeader::noinv();
        $so_to_invoice  = TransaksiSOHeader::where('noso', $noso)->get();
        
        foreach($so_to_invoice as $a){

            $top = NOW()->addDays($a->outlet->jth_tempo);

            $data['noinv']              = $newInv->noinv;
            $data['noso']               = $a->noso;
            $data['kd_outlet']          = $a->kd_outlet;
            $data['nm_outlet']          = $a->nm_outlet;
            $data['tgl_jatuh_tempo']    = $top;
            $data['status']             = 'O';
            $data['ket_status']         = 'OPEN';
            $data['user_sales']         = $a->user_sales;

            $header = TransaksiInvoiceHeader::create($data);
        }

        foreach($so_to_invoice as $a){

            foreach($a->details_so as $s){

                $stok_ready = MasterStokGudang::where('part_no', $s->part_no)->value('stok');
                $stok_akhir = $stok_ready - $s->qty;
 
                MasterStokGudang::where('part_no', $s->part_no)->update(['stok' => $stok_akhir]);

                if(($stok_ready != 0) && ($stok_ready > 0)){
                    
                    $details['noinv']              = $header->noinv;
                    $details['area_inv']           = $s->area_so;
                    $details['kd_outlet']          = $a->kd_outlet;
                    $details['part_no']            = $s->part_no;
                    $details['nm_part']            = $s->nm_part;
                    $details['qty']                = $s->qty;
                    $details['hrg_pcs']            = $s->hrg_pcs;
                    $details['disc']               = $s->disc;
                    $details['nominal']            = $s->nominal;
                    $details['nominal_disc']       = $s->nominal_disc;
                    $details['nominal_disc_ppn']   = $a->nominal_total * 0.11;
                    $details['nominal_total']      = $s->nominal_total;

                    TransaksiInvoiceDetails::create($details);


                    // ModalPartTerjual
                    $modal['noinv']              = $header->noinv;
                    $modal['part_no']            = $s->part_no;
                    $modal['qty_terjual']        = $s->qty;
                    $modal['modal']              = $s->hrg_pcs;
                    $modal['nominal_modal']      = $s->qty * $s->hrg_pcs;
                    $modal['status']             = 'A';
                    $modal['created_at']         = now();
                    $modal['created_by']         = Auth::user()->nama_user;

                    ModalPartTerjual::create($modal);

                }
            }
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
