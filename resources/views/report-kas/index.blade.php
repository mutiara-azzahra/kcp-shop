@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Laporan Kas</h4>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            Pilih Report, Tanggal Awal dan Tanggal Akhir
        </div>
        <div class="card-body">
            <form action="{{ route('report-kas.store') }}" method="GET">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-2">
                            <strong>Pilih Report</strong>
                            <select name="kas" class="form-control my-select" >
                                <option value="">---Pilih Report--</option>
                                <option value="1">Kas Masuk</option>
                                <option value="2">Kas Keluar</option>
                                <option value="3">Laporan Kas Harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="" class="form-control" placeholder="">
                    </div>

                    <div class="form-group col-6">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div class="float-right pt-3">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Proses Data</button>                            
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection