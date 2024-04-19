@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-3">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Tambah Bank</h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-bank.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('master-bank.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Kode Bank</strong>
                            <input type="number" name="kode_bank" class="form-control" placeholder="Isi Kode Bank">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="">Nama Bank</label>
                            <input type="text" name="nama_bank" id="" class="form-control" placeholder="Isi Nama Bank">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right">
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