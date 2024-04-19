@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Laporan Penjualan Kelompok Produk {{ $nama_produk }}</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('laporan-kelompok-produk.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 pb-3">
            <div class="float-left">
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

    <div class="card" style="padding: 2px;">
        <div class="card-body p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">Kode Produk</th>
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($flattened as $partNumber)
                        <tr>
                            <td class="text-center">{{ $nama_produk }}</td>
                            <td class="text-left">{{ $partNumber }}</td>
                            <td class="text-left">{{ $partNumber }}</td>
                            <td class="text-right">
                                @php
                                    $sumNominalTotal = $invoicesIchidai->where('part_no', $partNumber)->sum('nominal_total');
                                @endphp
                                {{ $sumNominalTotal }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')


@endsection