@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Ubah Master Outlet</h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-toko.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" id="myAlert">
            <strong>Maaf!</strong> Ada yang belum terisi<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('master-toko.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Provinsi</strong>
                            <input type="text" name="kode_prp" class="form-control" value= "{{ $outlet->kode_prp }}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Kabupaten/Kota</strong>
                            <input type="text" name="kode_kab" class="form-control" value= "{{ $outlet->kode_kab }}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Outlet</strong>
                            <input type="text" name="kd_outlet" class="form-control" value= "{{ $outlet->kd_outlet }}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Nama Pemilik</strong>
                            <input type="text" name="nm_pemilik" class="form-control" value= "{{ $outlet->nm_pemilik }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Nama Outlet</strong>
                            <input type="text" name="nm_outlet" class="form-control" value= "{{ $outlet->nm_outlet }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Alamat Outlet</strong>
                            <input type="text" name="almt_outlet" class="form-control" value= "{{ $outlet->almt_outlet }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Alamat Pengiriman</strong>
                            <input type="text" name="almt_pengiriman" class="form-control" value= "{{ $outlet->almt_pengiriman }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Telpon</strong>
                            <input type="text" name="tlpn" class="form-control" value= "{{ $outlet->tlpn }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Jatuh Tempo / TOP</strong>
                            <input type="text" name="jth_tempo" class="form-control" value= "{{ $outlet->jth_tempo }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Ekspedisi</strong>
                            <input type="text" name="expedisi" class="form-control" value= "{{ $outlet->expedisi }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>NIK</strong>
                            <input type="text" name="nik" class="form-control" value= "{{ $outlet->nik }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right pt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan Data</button>                            
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')

@endsection