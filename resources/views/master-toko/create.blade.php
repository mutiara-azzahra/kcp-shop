@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Tambah Area Outlet</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('master-area-outlet.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('master-area-outlet.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Provinsi</strong>
                            <input type="text" name="kode_prp" class="form-control" placeholder="Isi kode provinsi">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Kabupaten/Kota</strong>
                            <input type="text" name="kode_kab" class="form-control" placeholder="Isi kode kabupaten/kota">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kabupaten/Kota</strong>
                            <input type="text" name="nm_area" class="form-control" placeholder="Isi nama kabupaten/kota">
                        </div>
                    </div>


                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Provinsi</strong>
                            <input type="text" name="kode_prp" class="form-control" value= "{{ $outlet->kode_prp }}" readonly>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group">
                            <strong>Provinsi</strong><br>
                            <select name="kode_prp" class="form-control mb-2 my-select" onchange="updateData()">     
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach($provinsi as $s)
                                    <option value="{{ $s->kode_prp }}" data-id="{{ $s->kode_sales }}">{{ $s->sales }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <strong>Kabupaten/Kota</strong><br>
                            <select name="kode_kab" class="form-control mb-2 my-select" onchange="updateData()">     
                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                @foreach($kota as $s)
                                    <option value="{{ $s->sales }}" data-id="{{ $s->kode_sales }}">{{ $s->sales }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Nama Pemilik</strong>
                            <input type="text" name="nm_pemilik" class="form-control" placeholder="Nama Pemilik">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Kode Outlet</strong>
                            <input type="text" name="kd_outlet" class="form-control" placeholder="Kode Outlet">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Nama Outlet</strong>
                            <input type="text" name="nm_outlet" class="form-control" placeholder="Nama Outlet">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Alamat Outlet</strong>
                            <input type="text" name="almt_outlet" class="form-control" placeholder="Alamat Outlet">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Alamat Pengiriman</strong>
                            <input type="text" name="almt_pengiriman" class="form-control" placeholder="Alamat Pengiriman">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Telpon</strong>
                            <input type="text" name="tlpn" class="form-control" placeholder="Telpon">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Jatuh Tempo / TOP</strong>
                            <input type="number" name="jth_tempo" class="form-control" placeholder="Jatuh Tempo">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Ekspedisi</strong>
                            <input type="text" name="expedisi" class="form-control" placeholder="Ekspedisi">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>NIK</strong>
                            <input type="text" name="nik" class="form-control" placeholder="NIK">
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