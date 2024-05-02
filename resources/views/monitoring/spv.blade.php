@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Monitoring Sales</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('monitoring.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
    <div class="alert alert-danger" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if(isset($dataTargetTahun))

    <div class="card" style="padding: 2px;">
        <div class="card-body">
            <div class="col-lg-4">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-left">Nama Sales</th>
                        <td>:</td>
                        <td class="text-left">{{ $sales }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Bulan</th>
                        <td>:</td>
                        <td class="text-left">{{ $monthName }} {{ $tahun }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">Target</th>
                            <th class="text-center">Actual</th>
                            <th class="text-center">Ach.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        <tr>
                            <td class="text-center">Rp. {{ number_format($getTarget, 0, ',', ',') }}</td>
                            <td class="text-center">Rp. {{ number_format($target, 0, ',', ',') }}, <p style="color:red;">({{ number_format($selisih, 0, ',', ',') }})</p></td>
                            <td class="text-center">{{ number_format($pencapaian_persen, 3, ',', ',') }} %</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 2px;">
        <div class="card-body table-responsive p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1" style="font-size: 12px;">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center"></th>
                            <th class="text-center">Jan</th>
                            <th class="text-center">Feb</th>
                            <th class="text-center">Mar</th>
                            <th class="text-center">Apr</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Jun</th>
                            <th class="text-center">Jul</th>
                            <th class="text-center">Agt</th>
                            <th class="text-center">Sep</th>
                            <th class="text-center">Okt</th>
                            <th class="text-center">Nov</th>
                            <th class="text-center">Des</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_jan }}</td>
                            <td class="text-right">{{ $target_feb }}</td>
                            <td class="text-right">{{ $target_mar }}</td>
                            <td class="text-right">{{ $target_apr }}</td>
                            <td class="text-right">{{ $target_may }}</td>
                            <td class="text-right">{{ $target_jun }}</td>
                            <td class="text-right">{{ $target_jul }}</td>
                            <td class="text-right">{{ $target_agu }}</td>
                            <td class="text-right">{{ $target_sep }}</td>
                            <td class="text-right">{{ $target_oct }}</td>
                            <td class="text-right">{{ $target_nov }}</td>
                            <td class="text-right">{{ $target_dec }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: red; color:white">ACTUAL</td>
                            <td class="text-right">{{ $jan }}</td>
                            <td class="text-right">{{ $feb }}</td>
                            <td class="text-right">{{ $mar }}</td>
                            <td class="text-right">{{ $apr }}</td>
                            <td class="text-right">{{ $may }}</td>
                            <td class="text-right">{{ $jun }}</td>
                            <td class="text-right">{{ $jul }}</td>
                            <td class="text-right">{{ $agu }}</td>
                            <td class="text-right">{{ $sep }}</td>
                            <td class="text-right">{{ $oct }}</td>
                            <td class="text-right">{{ $nov }}</td>
                            <td class="text-right">{{ $dec }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 2px;">
        <div class="card-header">
            <b>TARGET PRODUK ICHIDAI</b>
        </div>
        <div class="card-body table-responsive p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3" style="font-size: 12px;">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center"></th>
                            <th class="text-center">Jan</th>
                            <th class="text-center">Feb</th>
                            <th class="text-center">Mar</th>
                            <th class="text-center">Apr</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Jun</th>
                            <th class="text-center">Jul</th>
                            <th class="text-center">Agt</th>
                            <th class="text-center">Sep</th>
                            <th class="text-center">Okt</th>
                            <th class="text-center">Nov</th>
                            <th class="text-center">Des</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td class="text-right" style="background-color: red; color:white">ACTUAL</td>
                            <td class="text-right">{{ number_format($achIchS01, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS02, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS03, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS04, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS05, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS06, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS07, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS08, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS09, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS10, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS11, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achIchS12, 0, ',', ',') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_s_ich_jan }}</td>
                            <td class="text-right">{{ $target_s_ich_feb }}</td>
                            <td class="text-right">{{ $target_s_ich_mar }}</td>
                            <td class="text-right">{{ $target_s_ich_apr }}</td>
                            <td class="text-right">{{ $target_s_ich_may }}</td>
                            <td class="text-right">{{ $target_s_ich_jun }}</td>
                            <td class="text-right">{{ $target_s_ich_jul }}</td>
                            <td class="text-right">{{ $target_s_ich_agu }}</td>
                            <td class="text-right">{{ $target_s_ich_sep }}</td>
                            <td class="text-right">{{ $target_s_ich_oct }}</td>
                            <td class="text-right">{{ $target_s_ich_nov }}</td>
                            <td class="text-right">{{ $target_s_ich_dec }}</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 2px;">
        <div class="card-header">
            <b>TARGET PRODUK BRIO</b>
        </div>
        <div class="card-body table-responsive p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3" style="font-size: 12px;">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center"></th>
                            <th class="text-center">Jan</th>
                            <th class="text-center">Feb</th>
                            <th class="text-center">Mar</th>
                            <th class="text-center">Apr</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Jun</th>
                            <th class="text-center">Jul</th>
                            <th class="text-center">Agt</th>
                            <th class="text-center">Sep</th>
                            <th class="text-center">Okt</th>
                            <th class="text-center">Nov</th>
                            <th class="text-center">Des</th>
                        </tr>
                    </thead>
                    <tbody>      
                        <tr>
                            <td class="text-right" style="background-color: red; color:white">ACTUAL</td>
                            <td class="text-right">{{ number_format($achBriS01, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS02, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS03, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS04, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS05, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS06, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS07, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS08, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS09, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS10, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS11, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achBriS12, 0, ',', ',') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_s_bri_jan }}</td>
                            <td class="text-right">{{ $target_s_bri_feb }}</td>
                            <td class="text-right">{{ $target_s_bri_mar }}</td>
                            <td class="text-right">{{ $target_s_bri_apr }}</td>
                            <td class="text-right">{{ $target_s_bri_may }}</td>
                            <td class="text-right">{{ $target_s_bri_jun }}</td>
                            <td class="text-right">{{ $target_s_bri_jul }}</td>
                            <td class="text-right">{{ $target_s_bri_agu }}</td>
                            <td class="text-right">{{ $target_s_bri_sep }}</td>
                            <td class="text-right">{{ $target_s_bri_oct }}</td>
                            <td class="text-right">{{ $target_s_bri_nov }}</td>
                            <td class="text-right">{{ $target_s_bri_dec }}</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 2px;">
        <div class="card-header">
            <b>TARGET PRODUK AIR ACCU</b>
        </div>
        <div class="card-body table-responsive p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3" style="font-size: 12px;">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center"></th>
                            <th class="text-center">Jan</th>
                            <th class="text-center">Feb</th>
                            <th class="text-center">Mar</th>
                            <th class="text-center">Apr</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Jun</th>
                            <th class="text-center">Jul</th>
                            <th class="text-center">Agt</th>
                            <th class="text-center">Sep</th>
                            <th class="text-center">Okt</th>
                            <th class="text-center">Nov</th>
                            <th class="text-center">Des</th>
                        </tr>
                    </thead>
                    <tbody>      
                        <tr>
                            <td class="text-right" style="background-color: red; color:white">ACTUAL</td>
                            <td class="text-right">{{ number_format($achAccS01, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS02, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS03, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS04, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS05, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS06, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS07, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS08, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS09, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS10, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS11, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAccS12, 0, ',', ',') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_s_acc_jan }}</td>
                            <td class="text-right">{{ $target_s_acc_feb }}</td>
                            <td class="text-right">{{ $target_s_acc_mar }}</td>
                            <td class="text-right">{{ $target_s_acc_apr }}</td>
                            <td class="text-right">{{ $target_s_acc_may }}</td>
                            <td class="text-right">{{ $target_s_acc_jun }}</td>
                            <td class="text-right">{{ $target_s_acc_jul }}</td>
                            <td class="text-right">{{ $target_s_acc_agu }}</td>
                            <td class="text-right">{{ $target_s_acc_sep }}</td>
                            <td class="text-right">{{ $target_s_acc_oct }}</td>
                            <td class="text-right">{{ $target_s_acc_nov }}</td>
                            <td class="text-right">{{ $target_s_acc_dec }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 2px;">
        <div class="card-header">
            <b>TARGET PRODUK AIR COOLANT</b>
        </div>
        <div class="card-body table-responsive p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3" style="font-size: 12px;">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center"></th>
                            <th class="text-center">Jan</th>
                            <th class="text-center">Feb</th>
                            <th class="text-center">Mar</th>
                            <th class="text-center">Apr</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Jun</th>
                            <th class="text-center">Jul</th>
                            <th class="text-center">Agt</th>
                            <th class="text-center">Sep</th>
                            <th class="text-center">Okt</th>
                            <th class="text-center">Nov</th>
                            <th class="text-center">Des</th>
                        </tr>
                    </thead>
                    <tbody>      
                        <tr>
                            <td class="text-right" style="background-color: red; color:white">ACTUAL</td>
                            <td class="text-right">{{ number_format($achAclS01, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS02, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS03, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS04, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS05, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS06, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS07, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS08, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS09, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS10, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS11, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achAclS12, 0, ',', ',') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_s_acl_jan }}</td>
                            <td class="text-right">{{ $target_s_acl_feb }}</td>
                            <td class="text-right">{{ $target_s_acl_mar }}</td>
                            <td class="text-right">{{ $target_s_acl_apr }}</td>
                            <td class="text-right">{{ $target_s_acl_may }}</td>
                            <td class="text-right">{{ $target_s_acl_jun }}</td>
                            <td class="text-right">{{ $target_s_acl_jul }}</td>
                            <td class="text-right">{{ $target_s_acl_agu }}</td>
                            <td class="text-right">{{ $target_s_acl_sep }}</td>
                            <td class="text-right">{{ $target_s_acl_oct }}</td>
                            <td class="text-right">{{ $target_s_acl_nov }}</td>
                            <td class="text-right">{{ $target_s_acl_dec }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 2px;">
        <div class="card-header">
            <b>TARGET PRODUK PENTIL</b>
        </div>
        <div class="card-body table-responsive p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3" style="font-size: 12px;">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center"></th>
                            <th class="text-center">Jan</th>
                            <th class="text-center">Feb</th>
                            <th class="text-center">Mar</th>
                            <th class="text-center">Apr</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Jun</th>
                            <th class="text-center">Jul</th>
                            <th class="text-center">Agt</th>
                            <th class="text-center">Sep</th>
                            <th class="text-center">Okt</th>
                            <th class="text-center">Nov</th>
                            <th class="text-center">Des</th>
                        </tr>
                    </thead>
                    <tbody>      
                        <tr>
                            <td class="text-right" style="background-color: red; color:white">ACTUAL</td>
                            <td class="text-right">{{ number_format($achPenS01, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS02, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS03, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS04, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS05, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS06, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS07, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS08, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS09, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS10, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS11, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($achPenS12, 0, ',', ',') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_s_pen_jan }}</td>
                            <td class="text-right">{{ $target_s_pen_feb }}</td>
                            <td class="text-right">{{ $target_s_pen_mar }}</td>
                            <td class="text-right">{{ $target_s_pen_apr }}</td>
                            <td class="text-right">{{ $target_s_pen_may }}</td>
                            <td class="text-right">{{ $target_s_pen_jun }}</td>
                            <td class="text-right">{{ $target_s_pen_jul }}</td>
                            <td class="text-right">{{ $target_s_pen_agu }}</td>
                            <td class="text-right">{{ $target_s_pen_sep }}</td>
                            <td class="text-right">{{ $target_s_pen_oct }}</td>
                            <td class="text-right">{{ $target_s_pen_nov }}</td>
                            <td class="text-right">{{ $target_s_pen_dec }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="card" style="padding: 2px;">
        <div class="card-body">
            <div class="card-header">
                <b>Pemberitahuan</b>
            </div>
            <div class="card-body">
                <p>Maaf, anda belum menambahkan Target Sales Tahun {{ $tahun }}, tambahkan target sales <a href="{{ route('master-target.index')}}">disini.</a></li>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection

@section('script')

@endsection