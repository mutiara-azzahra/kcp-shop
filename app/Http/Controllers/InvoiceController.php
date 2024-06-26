<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use App\Models\StokGudang;
use App\Models\MasterStokGudang;
use App\Models\MasterOutlet;
use App\Models\MasterPerkiraan;
use App\Models\TransaksiSOHeader;
use App\Models\TransaksiInvoiceHeader;
use App\Models\TransaksiInvoiceDetails;
use App\Models\TransaksiAkuntansiJurnalHeader;
use App\Models\TransaksiAkuntansiJurnalDetails;
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
        $jurnal = [
            'trx_date'      => now(),
            'trx_from'      => $header->noinv,
            'keterangan'    => 'Penjualan : '. $header->noinv . $so_to_invoice->kd_outlet . '/' . $so_to_invoice->nm_outlet ,
            'catatan'       => 'Penjualan',
            'kategori'      => 'INVOICE',
            'created_at'    => NOW(),
            'updated_at'    => NOW(),
            'created_by'    => Auth::user()->nama_user,
        ];

        $jurnal_created = TransaksiAkuntansiJurnalHeader::create($jurnal);

        //CREATE JURNAL KAS KELUAR DETAILS: DEBET
        $debet['id_header']  = $jurnal_created->id;
        $debet['perkiraan']  = '1.1300';
        $debet['debet']      = $so_to_invoice->details_so->sum('nominal_total');
        $debet['kredit']     = 0;
        $debet['status']     = 'Y';
        $debet['created_by'] = Auth::user()->nama_user;
        $debet['created_at'] = now();
        $debet['updated_at'] = now();

        $created_debet = TransaksiAkuntansiJurnalDetails::create($debet);

        //SALDO DEBET
        $saldo_debet = MasterPerkiraan::where('id_perkiraan', '1.1300')->value('saldo');

        MasterPerkiraan::where('id_perkiraan', '1.1300')->update(['saldo' => $saldo_debet + $created_debet->debet]);

        //CREATE JURNAL KAS KELUAR DETAILS: KREDIT
        $kredit['id_header']  = $jurnal_created->id;
        $kredit['perkiraan']  = '4.1000';
        $kredit['debet']      = 0;
        $kredit['kredit']     = $so_to_invoice->details_so->sum('nominal_total');
        $kredit['status']     = 'Y';
        $kredit['created_by'] = Auth::user()->nama_user;
        $kredit['created_at'] = now();
        $kredit['updated_at'] = now();

        $created_kredit = TransaksiAkuntansiJurnalDetails::create($kredit);

        //SALDO KREDIT
        $saldo_kredit = MasterPerkiraan::where('id_perkiraan', '4.1000')->value('saldo');
        MasterPerkiraan::where('id_perkiraan', '4.1000')->update(['saldo' => $saldo_kredit + $created_kredit->kredit]);

        //CREATE DETAILS INVOICE
        foreach($so_to_invoice->details_so as $s){

            $stok_ready = MasterStokGudang::where('part_no', $s->part_no)->value('stok');

            if($stok_ready = 0 || $stok_ready < $s->qty){

            } elseif ($stok_ready > 0 || $stok_ready = $s->qty){

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
                $details['nominal_disc_ppn']   = $s->nominal_total * 0.11;
                $details['nominal_total']      = $s->nominal_total;
                $details['status']             = 'Y';
                $details['created_by']         = Auth::user()->nama_user;

                TransaksiInvoiceDetails::create($details);

                //LIST BARANG KELUAR, KARTU STOK
                $stok_awal_barang = FlowStokGudang::where('part_no', $s->part_no)->orderBy('created_at', 'desc')->value('stok_akhir');
                
                if(isset($stok_awal_barang)) {
                    $stok_awal = $stok_awal_barang;
                } else{
                    $stok_awal = MasterStokGudang::where('part_no', $s->part_no)->value('stok');
                }

                $outlet = MasterOutlet::where('kd_outlet', $so_to_invoice->kd_outlet)->first();

                $value['part_no']              = $s->part_no;
                $value['keterangan']           = $so_to_invoice->kd_outlet . '/' . $outlet->nm_outlet;
                $value['referensi']            = $header->noinv;
                $value['tanggal_barang_masuk'] = NOW();
                $value['stok_awal']            = $stok_awal;
                $value['stok_masuk']           = 0;
                $value['stok_keluar']          = $s->qty;
                $value['stok_akhir']           = $stok_awal + 0 - $s->qty;

                FlowStokGudang::create($value);

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
