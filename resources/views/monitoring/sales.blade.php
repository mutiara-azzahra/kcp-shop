@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Monitoring Supervisor</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('monitoring.spv') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    @if(isset($targetSpv))

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-4">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-left">Supervisor</th>
                        <td>:</td>
                        <td class="text-left">{{ $spv }}</td>
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
                            <td class="text-center">Rp. {{ number_format($getTarget->nominal, 0, ',', '.') }}</td>

                            @if($target == null)

                            @else
                            <td class="text-center">Rp. {{ number_format($target, 0, ',', '.') }}, <p style="color:red;">({{ number_format($selisih, 0, ',', '.') }})</p></td>
                            @endif
                            <td class="text-center">{{ number_format((($target/$getTarget->nominal) * 100), 3, ',', '.') }} %</td>
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
                            <td class="text-right">{{ $jan_ich }}</td>
                            <td class="text-right">{{ $feb_ich }}</td>
                            <td class="text-right">{{ $mar_ich }}</td>
                            <td class="text-right">{{ $apr_ich }}</td>
                            <td class="text-right">{{ $may_ich }}</td>
                            <td class="text-right">{{ $jun_ich }}</td>
                            <td class="text-right">{{ $jul_ich }}</td>
                            <td class="text-right">{{ $agu_ich }}</td>
                            <td class="text-right">{{ $sep_ich }}</td>
                            <td class="text-right">{{ $oct_ich }}</td>
                            <td class="text-right">{{ $nov_ich }}</td>
                            <td class="text-right">{{ $dec_ich }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_ich_jan }}</td>
                            <td class="text-right">{{ $target_ich_feb }}</td>
                            <td class="text-right">{{ $target_ich_mar }}</td>
                            <td class="text-right">{{ $target_ich_apr }}</td>
                            <td class="text-right">{{ $target_ich_may }}</td>
                            <td class="text-right">{{ $target_ich_jun }}</td>
                            <td class="text-right">{{ $target_ich_jul }}</td>
                            <td class="text-right">{{ $target_ich_agu }}</td>
                            <td class="text-right">{{ $target_ich_sep }}</td>
                            <td class="text-right">{{ $target_ich_oct }}</td>
                            <td class="text-right">{{ $target_ich_nov }}</td>
                            <td class="text-right">{{ $target_ich_dec }}</td>
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
                            <td class="text-right">{{ $jan_bri }}</td>
                            <td class="text-right">{{ $feb_bri }}</td>
                            <td class="text-right">{{ $mar_bri }}</td>
                            <td class="text-right">{{ $apr_bri }}</td>
                            <td class="text-right">{{ $may_bri }}</td>
                            <td class="text-right">{{ $jun_bri }}</td>
                            <td class="text-right">{{ $jul_bri }}</td>
                            <td class="text-right">{{ $agu_bri }}</td>
                            <td class="text-right">{{ $sep_bri }}</td>
                            <td class="text-right">{{ $oct_bri }}</td>
                            <td class="text-right">{{ $nov_bri }}</td>
                            <td class="text-right">{{ $dec_bri }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_bri_jan }}</td>
                            <td class="text-right">{{ $target_bri_feb }}</td>
                            <td class="text-right">{{ $target_bri_mar }}</td>
                            <td class="text-right">{{ $target_bri_apr }}</td>
                            <td class="text-right">{{ $target_bri_may }}</td>
                            <td class="text-right">{{ $target_bri_jun }}</td>
                            <td class="text-right">{{ $target_bri_jul }}</td>
                            <td class="text-right">{{ $target_bri_agu }}</td>
                            <td class="text-right">{{ $target_bri_sep }}</td>
                            <td class="text-right">{{ $target_bri_oct }}</td>
                            <td class="text-right">{{ $target_bri_nov }}</td>
                            <td class="text-right">{{ $target_bri_dec }}</td>
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
                            <td class="text-right">{{ $jan_acc }}</td>
                            <td class="text-right">{{ $feb_acc }}</td>
                            <td class="text-right">{{ $mar_acc }}</td>
                            <td class="text-right">{{ $apr_acc }}</td>
                            <td class="text-right">{{ $may_acc }}</td>
                            <td class="text-right">{{ $jun_acc }}</td>
                            <td class="text-right">{{ $jul_acc }}</td>
                            <td class="text-right">{{ $agu_acc }}</td>
                            <td class="text-right">{{ $sep_acc }}</td>
                            <td class="text-right">{{ $oct_acc }}</td>
                            <td class="text-right">{{ $nov_acc }}</td>
                            <td class="text-right">{{ $dec_acc }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_acc_jan }}</td>
                            <td class="text-right">{{ $target_acc_feb }}</td>
                            <td class="text-right">{{ $target_acc_mar }}</td>
                            <td class="text-right">{{ $target_acc_apr }}</td>
                            <td class="text-right">{{ $target_acc_may }}</td>
                            <td class="text-right">{{ $target_acc_jun }}</td>
                            <td class="text-right">{{ $target_acc_jul }}</td>
                            <td class="text-right">{{ $target_acc_agu }}</td>
                            <td class="text-right">{{ $target_acc_sep }}</td>
                            <td class="text-right">{{ $target_acc_oct }}</td>
                            <td class="text-right">{{ $target_acc_nov }}</td>
                            <td class="text-right">{{ $target_acc_dec }}</td>
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
                            <td class="text-right">{{ $jan_acl }}</td>
                            <td class="text-right">{{ $feb_acl }}</td>
                            <td class="text-right">{{ $mar_acl }}</td>
                            <td class="text-right">{{ $apr_acl }}</td>
                            <td class="text-right">{{ $may_acl }}</td>
                            <td class="text-right">{{ $jun_acl }}</td>
                            <td class="text-right">{{ $jul_acl }}</td>
                            <td class="text-right">{{ $agu_acl }}</td>
                            <td class="text-right">{{ $sep_acl }}</td>
                            <td class="text-right">{{ $oct_acl }}</td>
                            <td class="text-right">{{ $nov_acl }}</td>
                            <td class="text-right">{{ $dec_acl }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_acl_jan }}</td>
                            <td class="text-right">{{ $target_acl_feb }}</td>
                            <td class="text-right">{{ $target_acl_mar }}</td>
                            <td class="text-right">{{ $target_acl_apr }}</td>
                            <td class="text-right">{{ $target_acl_may }}</td>
                            <td class="text-right">{{ $target_acl_jun }}</td>
                            <td class="text-right">{{ $target_acl_jul }}</td>
                            <td class="text-right">{{ $target_acl_agu }}</td>
                            <td class="text-right">{{ $target_acl_sep }}</td>
                            <td class="text-right">{{ $target_acl_oct }}</td>
                            <td class="text-right">{{ $target_acl_nov }}</td>
                            <td class="text-right">{{ $target_acl_dec }}</td>
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
                            <td class="text-right">{{ $jan_pen }}</td>
                            <td class="text-right">{{ $feb_pen }}</td>
                            <td class="text-right">{{ $mar_pen }}</td>
                            <td class="text-right">{{ $apr_pen }}</td>
                            <td class="text-right">{{ $may_pen }}</td>
                            <td class="text-right">{{ $jun_pen }}</td>
                            <td class="text-right">{{ $jul_pen }}</td>
                            <td class="text-right">{{ $agu_pen }}</td>
                            <td class="text-right">{{ $sep_pen }}</td>
                            <td class="text-right">{{ $oct_pen }}</td>
                            <td class="text-right">{{ $nov_pen }}</td>
                            <td class="text-right">{{ $dec_pen }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="background-color: yellow; color:black">TARGET</td>
                            <td class="text-right">{{ $target_pen_jan }}</td>
                            <td class="text-right">{{ $target_pen_feb }}</td>
                            <td class="text-right">{{ $target_pen_mar }}</td>
                            <td class="text-right">{{ $target_pen_apr }}</td>
                            <td class="text-right">{{ $target_pen_may }}</td>
                            <td class="text-right">{{ $target_pen_jun }}</td>
                            <td class="text-right">{{ $target_pen_jul }}</td>
                            <td class="text-right">{{ $target_pen_agu }}</td>
                            <td class="text-right">{{ $target_pen_sep }}</td>
                            <td class="text-right">{{ $target_pen_oct }}</td>
                            <td class="text-right">{{ $target_pen_nov }}</td>
                            <td class="text-right">{{ $target_pen_dec }}</td>
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
                <p>Maaf, anda belum menambahkan target SPV Tahun {{ $tahun }}, tambahkan target SPV <a href="{{ route('master-target-spv.index')}}">disini.</a></li>
            </div>
        </div>
    </div>
    
    @endif

</div>
@endsection

@section('script')

@endsection