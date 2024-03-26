@extends('welcome')

@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Details Toko</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('master-toko.index') }}"><i class="fas fa-arrow-left"></i>  Kembali</a>
            </div>
        </div>
    </div>
 
    <div class="card" style="padding: 20px;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kode Outlet</strong><br>
                    {{ $outlet->kd_outlet }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Outlet</strong><br>
                    {{ $outlet->nm_outlet }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Pemilik</strong><br>
                    {{ $outlet->nm_pemilik }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Alamat Toko</strong><br>
                    {{ $outlet->almt_outlet }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Alamat Pengirim</strong><br>
                    {{ $outlet->almt_pengiriman }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Area Group</strong><br>
                    {{ $outlet->area_group_2w }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telpon</strong><br>
                    {{ $outlet->tlpn }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>NPWP</strong><br>
                    {{ $outlet->npwp }}<br>
                </div>
            </div>

            @if($outlet->jth_tempo == 0 ||$outlet->jth_tempo == null)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Jatuh Tempo</strong> <a style="color:red;"> *wajib diisi</a><br>
                    Kosong, Harap diisi <a style="color:#0096FF;" href="{{ route('master-toko.edit', $outlet->kd_outlet) }}">disini.</a><br>
                </div>
            </div>
            @else
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tanggal Jatuh Tempo</strong> *wajib diisi<br>
                    {{ $outlet->jth_tempo }}<br>
                </div>
            </div>
            @endif
            
        </div>
    </div>
    
</div>
@endsection