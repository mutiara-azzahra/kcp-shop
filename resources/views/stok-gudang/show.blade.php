@extends('welcome')
 
@section('content')
<div class="container" style="padding: 20px; padding-bottom: 30px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Details Stok Gudang</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('stok-gudang.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>        
    </div>
    <div class="card" style="padding: 30px;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Part No</strong><br>
                    {{ $stok_id->part_no }}<br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Stok Gudang</strong><br>
                    {{ number_format($stok_id->stok, 0, ',', '.') }}<br>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            <b>Barang Masuk dan Keluar</b>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">Part No</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Stok Masuk</th>
                            <th class="text-center">Stok Keluar</th>
                            <th class="text-center">Lokasi Rak</th>
                            <th class="text-center">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($barang_masuk as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-left">{{ $p->part_no }}</td>
                            <td class="text-center">MASUK</td>
                            <td class="text-right">{{ number_format($p->qty, 0, ',', '.') }}</td>
                            <td></td>
                            <td class="text-center">{{ $p->rak->kode_rak_lokasi }}</td>
                            <td class="text-center">{{ $p->created_at }}</td>
                        </tr>
                        @endforeach
                        @foreach($barang_terjual as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-left">{{ $p->part_no }}</td>
                            <td class="text-center">TERJUAL</td>
                            <td></td>
                            <td class="text-right">{{ number_format($p->qty, 0, ',', '.') }}</td>
                            <td></td>
                            <td class="text-center">{{ $p->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <div class="card" style="padding: 10px;">
        <div class="card-header">
            <b>Lokasi Rak</b>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">Part No</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Lokasi Rak</th>
                            <th class="text-center">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($stok_rak as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-left">{{ $p->part_no }}</td>
                            <td class="text-right">{{ number_format($p->stok, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $p->rak->kode_rak_lokasi}}</td>
                            <td class="text-center">{{ $p->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>
@endsection