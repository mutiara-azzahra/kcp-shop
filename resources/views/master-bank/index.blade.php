@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-3">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Master Bank</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('master-bank.create') }}"><i class="fas fa-plus"></i> Tambah Bank</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">Kode Bank</th>
                            <th class="text-center">Nama Bank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($bank as $p)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->kode_bank }}</td>
                            <td>{{ $p->nama_bank }}</td>
                            <td class="text-center"><a class="btn btn-info btn-sm" href="{{ route('master-bank.show',$p->kode) }}"><i class="fas fa-eye"></i></a></td>
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