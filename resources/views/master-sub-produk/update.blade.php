@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Ubah Master Sub Produk</h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-sub-produk.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-warning" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('master-sub-produk.update', $master_sub_produk_id->id ) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Kode Produk</strong>
                            <input type="text" name="sub_produk" class="form-control" value="{{ $master_sub_produk_id->sub_produk }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Nama Produk</strong>
                            <input type="text" name="keterangan" class="form-control" value="{{ $master_sub_produk_id->keterangan }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-2">
                            <strong>Kode Produk</strong>
                            <select name="kode_produk" class="form-control my-select">
                                <option value="">---Pilih Kode Produk--</option>
                                @foreach($master_produk as $k)
                                    <option value="{{ $k->kode_produk }}" {{ $master_sub_produk_id->kode_produk == $k->kode_produk ? 'selected' : '' }}>
                                        {{ $k->kode_produk }} - {{ $k->keterangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>                            
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