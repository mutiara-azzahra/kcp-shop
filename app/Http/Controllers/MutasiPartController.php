<?php

namespace App\Http\Controllers;

use App\Models\MutasiHeader;
use Illuminate\Http\Request;

class MutasiPartController extends Controller
{
    public function index(){

        $mutasi_approved = MutasiHeader::where('approval_head_gudang', 'Y')->get();
        $mutasi          = MutasiHeader::where('approval_head_gudang', 'N')->get();

        return view('mutasi-part.index', compact('mutasi_approved', 'mutasi'));
    }

    public function details($no_mutasi){

        $header = MutasiHeader::where('no_mutasi', $no_mutasi)->first();

        return view('mutasi-part.details', compact('header'));
    }
}
