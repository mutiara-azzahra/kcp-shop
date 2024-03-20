<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterOutlet;

class MasterTokoController extends Controller
{
    public function index(){

        $list_toko = MasterOutlet::all();

        return view('master-toko.index', compact('list_toko'));
    }
}
