<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\TransaksiPlafond;

class PlafondController extends Controller
{
    public function index(){

        $plafond = TransaksiPlafond::all();

        return view('master-plafond.index', compact('plafond'));
    }
}
