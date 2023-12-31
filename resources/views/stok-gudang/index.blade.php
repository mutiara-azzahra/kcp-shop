@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Stok Gudang</h4>
            </div>
            <div class="float-right m-1">
                <a class="btn btn-success m-1" href="{{ route('stok-gudang.tambah') }}"><i class="fas fa-plus"></i> Tambah Stok</a>
                <a class="btn btn-primary m-1" href="{{ route('stok-gudang.list') }}"><i class="fas fa-list"></i> List Barang Masuk</a>
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
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">Part No</th>
                            <th class="text-center">Nama Part</th>
                            <th class="text-center">Stok Gudang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($stok_gudang as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-left">{{ $p->part_no }}</td>
                            <td class="text-left">{{ $p->master_part->part_nama }}</td>
                            <td class="text-right">{{ number_format($p->stok, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('stok-gudang.show',$p->id) }}"><i class="fas fa-eye"></i></a>
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