@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4><b>Detail Master Bank</b></h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-bank.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Kode Bank</strong><br>
                            {{ $bank->kode_bank }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nama Bank</strong><br>
                            {{ $bank->kode_bank }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('script')

@endsection