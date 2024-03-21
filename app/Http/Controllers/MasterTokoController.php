<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterOutlet;

class MasterTokoController extends Controller
{
    public function index(){

        $list_toko = MasterOutlet::where('status', 'Y')->get();

        return view('master-toko.index', compact('list_toko'));
    }

    public function edit($kd_outlet){

        $outlet = MasterOutlet::where('kd_outlet', $kd_outlet)->first();

        return view('master-toko.edit', compact('outlet'));
    }
}
