<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurnalPembukuanController extends Controller
{
    public function index(){

        return view('jurnal-pembukuan.index');
    }

    public function create(){

        return view('jurnal-pembukuan.create');
    }
}
