@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>History Retur</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('retur.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>  
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            <div class="col-lg-12">
                List Retur Selesai
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Retur</th>
                            <th class="text-center">No. Invoice</th>
                            <th class="text-center">Kode Toko</th>
                            <th class="text-center">Nama Toko</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($history_retur as $p)
                        <tr>
                            <td class="text-left">{{ $p->no_retur }}</td>
                            <td class="text-left">{{ $p->noinv }}</td>
                            <td class="text-center">{{ $p->kd_outlet }}</td>
                            <td class="text-left">{{ $p->nm_outlet }}</td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm" href="{{ route('retur.details', $p->no_retur )}}"><i class="fas fa-eye"></i>
                                </a>
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