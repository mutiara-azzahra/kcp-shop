@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Tambah Master Diskon DBP</h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-diskon-dbp.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                <form action="{{ route('master-diskon-dbp.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                        <strong>Isi Part No</strong>

                        <select name="part_no" class="form-control mr-2 my-select">
                            <option value="">-- Pilih --</option>
                            @foreach($master_part as $k)
                            <option value="{{ $k->part_no }}">{{ $k->part_no }} | {{ $k->part_nama }}</option>
                            @endforeach
                        </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Isi Maksimal Diskon (dalam %)</strong>
                            <input type="number" name="diskon_maksimal" class="form-control" placeholder="Contoh: 10">
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