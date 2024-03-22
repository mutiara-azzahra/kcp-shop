<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPartModal;
use App\Models\TransaksiInvoiceDetails;
use App\Models\ModalPartTerjual;

class ModalDbpController extends Controller
{
    public function index(){

    $getModal = MasterPartModal::all();

    return view('modal.index', compact('getModal'));

    }

    public function store(Request $request){

        $request->validate([
            'bulan'         => 'required',
            'tahun'         => 'required',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        //if qty_persediaan != 0 && qty_persediaan > qty_terjual'
        $getTerjual = TransaksiInvoiceDetails::where('created_at', '>=', $tahun.'-'.$bulan.'-01')
            ->where('created_at', '<=', $tahun.'-'.$bulan.'-'.Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('d'))
            ->get();

            $successCount = 0;
            $errorCount = 0;
            
            foreach ($getTerjual as $i) {
                $getPersediaan = MasterPartModal::where('part_no', $i->part_no)
                    ->where('status', 'A')
                    ->first();
            
                if ($getPersediaan) {
                    $nominalJualDbp = $getPersediaan->modal * $i->qty;
                    $stok_persediaan = $getPersediaan->qty - $i->qty;
            
                    $value = [
                        'noinv'         => $i->noinv,
                        'part_no'       => $i->part_no,
                        'qty_awal'      => $getPersediaan->qty,
                        'qty_terjual'   => $i->qty,
                        'qty_akhir'     => $stok_persediaan,
                        'modal'         => $getPersediaan->modal,
                        'nominal_modal' => $nominalJualDbp,
                        'status'        => 'A',
                        'created_at'    => now(),
                        'created_by'    => Auth::user()->nama_user,
                    ];
            
                    $created = ModalPartTerjual::create($value);
            
                    if ($created) {
                        $updated = $getPersediaan->update([
                            'qty'           => $stok_persediaan,
                            'updated_at'    => now(),
                        ]);
            
                        if ($updated) {
                            $successCount++;
                        } else {
                            $errorCount++;
                        }
                    } else {
                        $errorCount++;
                    }
                } else {
                    $errorCount++;
                }
            }
            
            if ($successCount > 0 && $errorCount === 0) {
                return redirect()->route('modal.index')->with('success', 'Data modal berhasil dijalankan');
            } else {
                return redirect()->route('modal.index')->with('danger', 'Ada kesalahan saat pemrosesan data');
            }
            
        
        //if qty_persediaan < qty_terjual
        //ambil satu data atas dulu yang masih bisa dikurangi dengan qty_terjual
        // $getModalTerjual = MasterPartModal::where('part_no', $part_no)
        //     ->where('status', 'A')
        //     ->first();
        
    }

}
