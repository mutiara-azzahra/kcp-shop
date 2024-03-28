<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\TransaksiSpHeader;
use App\Models\TransaksiSpDetails;
use App\Models\TransaksiSOHeader;
use App\Models\TransaksiSODetails;
use App\Models\TransaksiBackOrderHeader;
use App\Models\TransaksiBackOrderDetails;
use App\Models\MasterStokGudang;
use App\Models\MasterPart;
use App\Models\MasterDiskonPart;

class SalesOrderController extends Controller
{
    public function index(){

        $surat_pesanan = TransaksiSpHeader::orderBy('nosp', 'desc')->get();

        return view('sales-order.index', compact('surat_pesanan'));
    }

    public function so_approved(){

        $so_approved = TransaksiSOHeader::where('flag_approve', 'Y')->get();

        return view('sales-order.approved', compact('so_approved'));
    }

    public function so_rejected(){

        $so_rejected = TransaksiSOHeader::where('flag_reject', 'Y')->get();

        return view('sales-order.rejected', compact('so_rejected'));
    }

    public function details($nosp){

        $surat_pesanan_id   = TransaksiSpHeader::where('nosp', $nosp)->first();
        
        $totalSum = 0;

        $totalSum += $surat_pesanan_id->details_sp->sum('nominal_total');

        return view('sales-order.details', ['nosp' => $nosp] , compact('surat_pesanan_id', 'totalSum'));
    }

    public function create(){

        return view('sales-order.create');
    }
    public function store(Request $request){

        return redirect()->route('sales-order.index')->with('success','Data SO baru berhasil ditambahkan!');

    }

    public function approve($nosp){

        $header_so  = TransaksiSpHeader::where('nosp', $nosp)->first();
        $hasZeroQty = false;
        $check_sp   = TransaksiSpDetails::where('nosp', $nosp)->get();

        //Periksa stok
        foreach ($check_sp as $i) {
            $stok_ready = MasterStokGudang::where('part_no', $i->part_no)->value('stok');

            if ($stok_ready == 0) {

                $hasZeroQty = true;
                break;
            }
        }

        //Apabila ada stok ready = 0, create BO
        if ($hasZeroQty) {
            $newBo             = new TransaksiBackOrderHeader();
            $newBo->nobo       = TransaksiBackOrderHeader::nobo();
            $nobo              = $newBo->nobo;

            $value['nobo']       = $newBo->nobo;
            $value['kd_outlet']  = $header_so->kd_outlet;
            $value['nm_outlet']  = $header_so->nm_outlet;
            $value['keterangan'] = $header_so->keterangan;
            $value['status']     = 'O';
            $value['ket_batal']  = 'N';
            $value['noso_out']   = $header_so->noso;
            $value['user_sales'] = $header_so->user_sales;
            $value['created_by'] = Auth::user()->nama_user;
            $value['created_at'] = NOW();

            TransaksiBackOrderHeader::create($value);

            foreach ($header_so->details_sp as $d) {

            $stok_ready = MasterStokGudang::where('part_no', $d->part_no)->value('stok');
    
                if ($stok_ready == 0) {

                    $back_order = [
                        'nobo'          => $nobo,
                        'area_bo'       => $header_so->area_sp,
                        'kd_outlet'     => $header_so->kd_outlet,
                        'part_no'       => $d->part_no,
                        'qty'           => $d->qty,
                        'hrg_pcs'       => $d->hrg_pcs,
                        'disc'          => $d->disc,
                        'status'        => 'O',
                        'created_at'    => now(),
                        'created_by'    => Auth::user()->nama_user,
                    ];
            
                    TransaksiBackOrderDetails::create($back_order);

                } elseif($stok_ready != 0) {

                    if($d->qty >= $stok_ready){

                        $back_order = [
                            'nobo'          => $nobo,
                            'area_bo'       => $header_so->area_sp,
                            'kd_outlet'     => $header_so->kd_outlet,
                            'part_no'       => $d->part_no,
                            'qty'           => $d->qty - $stok_ready,
                            'hrg_pcs'       => $d->hrg_pcs,
                            'disc'          => $d->disc,
                            'status'        => 'O',
                            'created_at'    => now(),
                            'created_by'    => Auth::user()->nama_user,
                        ];
            
                        TransaksiBackOrderDetails::create($back_order);


                    } elseif($d->qty == $stok_ready ){


                    } elseif($d->qty < $stok_ready ){
                       
                    }
                }
            }
        }

        //Ubah status SP
        TransaksiSpHeader::where('nosp', $nosp)->update([
            'status'        => 'C',
            'ket_status'    => 'CLOSE',
            'modi_date'     => NOW()
        ]);

        //Create SO Header
        $header = [
            'noso'              => $header_so->noso,
            'area_so'           => $header_so->area_sp,
            'kd_outlet'         => $header_so->kd_outlet,
            'nm_outlet'         => $header_so->nm_outlet,
            'status'            => 'O',
            'ket_status'        => 'OPEN',
            'user_sales'        => $header_so->user_sales,
            'flag_approve'      => 'Y',
            'flag_approve_date' => now(),
            'crea_date'         => now(),
            'crea_by'           => Auth::user()->nama_user,
        ];

        TransaksiSOHeader::create($header);
        
        foreach ($header_so->details_sp as $d) {

            $stok_ready = MasterStokGudang::where('part_no', $d->part_no)->value('stok');
            
            if($stok_ready != 0) {

                if($d->qty >= $stok_ready){

                    $details = [
                        'noso'              => $header_so->noso,
                        'area_so'           => $header_so->area_sp,
                        'kd_outlet'         => $header_so->kd_outlet,
                        'part_no'           => $d->part_no,
                        'qty'               => $stok_ready,
                        'hrg_pcs'           => $d->hrg_pcs,
                        'disc'              => $d->disc,
                        'nominal'           => $d->nominal,
                        'nominal_disc'      => $d->nominal_disc,
                        'nominal_total'     => $d->nominal_total,
                        'status'            => 'O',
                        'ket_status'        => 'OPEN',
                        'user_sales'        => $d->user_sales,
                        'flag_approve_date' => now(),
                        'crea_date'         => now(),
                        'crea_by'           => Auth::user()->nama_user,
                    ];
        
                    TransaksiSODetails::create($details);

                } elseif($d->qty == $stok_ready ){

                    $details = [
                        'noso'          => $header_so->noso,
                        'area_so'       => $header_so->area_sp,
                        'kd_outlet'     => $header_so->kd_outlet,
                        'part_no'       => $d->part_no,
                        'qty'           => $d->qty,
                        'hrg_pcs'       => $d->hrg_pcs,
                        'disc'          => $d->disc,
                        'nominal'       => $d->qty * $d->hrg_pcs,
                        'nominal_disc'  => $d->qty * $d->hrg_pcs * $d->disc / 100,
                        'nominal_total' => ($d->qty * $d->hrg_pcs) - ($d->qty * $d->hrg_pcs * $d->disc / 100),
                        'status'        => 'O',
                        'ket_status'    => 'OPEN',
                        'user_sales'    => $d->user_sales,
                        'flag_approve_date' => now(),
                        'crea_date'     => now(),
                        'crea_by'       => Auth::user()->nama_user,
                    ];
        
                    TransaksiSODetails::create($details);

                } elseif($d->qty < $stok_ready ){

                    $details = [
                        'noso'          => $header_so->noso,
                        'area_so'       => $header_so->area_sp,
                        'kd_outlet'     => $header_so->kd_outlet,
                        'part_no'       => $d->part_no,
                        'qty'           => $d->qty,
                        'hrg_pcs'       => $d->hrg_pcs,
                        'disc'          => $d->disc,
                        'nominal'       => $d->qty * $d->hrg_pcs,
                        'nominal_disc'  => $d->qty * $d->hrg_pcs * $d->disc / 100,
                        'nominal_total' => ($d->qty * $d->hrg_pcs) - ($d->qty * $d->hrg_pcs * $d->disc / 100),
                        'status'        => 'O',
                        'ket_status'    => 'OPEN',
                        'user_sales'    => $d->user_sales,
                        'flag_approve_date' => now(),
                        'crea_date'     => now(),
                        'crea_by'       => Auth::user()->nama_user,
                    ];
            
                    TransaksiSODetails::create($details);
                }

            }
    
        }
        
        return redirect()->route('sales-order.index')->with('success','Data SO berhasil di Approve!');

    }

    public function reject($nosp){

        $tolak_so = TransaksiSpHeader::where('nosp', $nosp)->get();

        foreach($tolak_so as $a){
            $data['noso']               = $a->noso;
            $data['area_so']            = $a->area_sp;
            $data['kd_outlet']          = $a->kd_outlet;
            $data['nm_outlet']          = $a->nm_outlet;
            $data['status']             = 'O';
            $data['ket_status']         = 'OPEN';
            $data['user_sales']         = $a->user_sales;
            $data['flag_approve']       = 'N';
            $data['flag_approve_date']  = NOW();
            $data['crea_date']          = NOW();
            $data['crea_by']            = Auth::user()->nama_user;

            TransaksiSOHeader::create($data);
        }

        foreach($tolak_so as $a){
            foreach($a->details_sp as $d){
                $details['noso']               = $a->noso;
                $details['area_so']            = $a->area_sp;
                $details['kd_outlet']          = $a->kd_outlet;
                $details['part_no']            = $d->part_no;
                $details['qty']                = $d->qty;
                $details['hrg_pcs']            = $d->hrg_pcs;
                $details['disc']               = $d->disc;
                $details['nominal']            = $d->nominal;
                $details['nominal_disc']       = $d->nominal_disc;
                $details['nominal_total']      = $d->nominal_total;
                $details['status']             = 'O';
                $details['ket_status']         = 'OPEN';
                $details['user_sales']         = $d->user_sales;
                $details['flag_reject_date']   = NOW();
                $details['crea_date']          = NOW();
                $details['crea_by']            = Auth::user()->nama_user;

                TransaksiSODetails::create($details);
            }
        }

        return redirect()->route('sales-order.index')->with('success','Data SO berhasil ditolak');

    }

    public function edit($id){

        $details       = TransaksiSPDetails::findOrFail($id);

        return view('sales-order.edit', compact('details'));

    }

    public function store_edit($id, Request $request)
    {
        $cari_sp    = TransaksiSPDetails::where('id', $id)->first();
        $het        = MasterPart::where('part_no', $request->part_no)->value('het');
        $getDiscMax = MasterDiskonPart::where('part_no', $request->part_no)->value('diskon_maksimal');

        if($getDiscMax != null){

            if($request->disc > $getDiscMax){

                return redirect()->route('sales_order.index')->with('danger','Nilai diskon part melebihi diskon maskimal! Silahkan input kembali');
            
            } else{

                if($request->disc == null){
                    $request->disc = 0;
                }

                $updated_sp = TransaksiSpDetails::where('id', $id)
                    ->update([
                    // 'id_rak'        => $request->id_rak,
                    'qty'           => $request->qty,
                    'disc'          => $request->disc,
                    'nominal'       => $request->qty * $het,
                    'nominal_disc'  => $request->qty * $het * $request->disc/100,
                    'nominal_total' => ($request->qty * $het) - ($request->qty * $het * $request->disc)/100,
                    'modi_date'     => NOW(),
                    'modi_by'       => Auth::user()->nama_user
                ]);


            }
        } else {

            $updated_sp = TransaksiSpDetails::where('id', $id)
                ->update([
                'qty'           => $request->qty,
                'disc'          => $request->disc,
                'nominal'       => $request->qty * $het,
                'nominal_disc'  => $request->qty * $het * $request->disc/100,
                'nominal_total' => ($request->qty * $het) - ($request->qty * $het * $request->disc/100),
                'modi_date'     => NOW(),
                'modi_by'       => Auth::user()->nama_user
            ]);
        }

        if ($updated_sp){
            return redirect()->route('sales-order.details', $cari_sp->nosp)->with('success','Data SP berhasil diubah!');
        } else{
            return redirect()->route('sales-order.details', $cari_sp->nosp)->with('danger','Data SP gagal diubah');
        }
    }


    public function tolak($noso){

        $data   = TransaksiSOHeader::where('noso',$noso)->first();

        $tolak  = TransaksiSOHeader::where('noso',$noso)->update([
            'flag_approve'     => 'N',
            'flag_reject'      => 'Y',
            'flag_reject_date' => NOW(),
            'modi_date'        => NOW(),
            'modi_by'          => Auth::user()->nama_user
        ]);

        if ($tolak){
            return redirect()->route('sales-order.index')->with('success','Data SO berhasil dibatalkan!');
        } else {
            return redirect()->route('sales-order.index')->with('warning','Data SO gagal dibatalkan!');
        }
    }
}
