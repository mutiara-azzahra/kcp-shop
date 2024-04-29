@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-2">
             <div class="float-left">
                <h4>Transfer Masuk</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-primary m-1" href="{{ route('transfer-masuk.validasi') }}"><i class="fas fa-book"></i> Validasi Transfer Masuk</a>
                <a class="btn btn-success m-1" href="{{ route('transfer-masuk.create') }}"><i class="fas fa-plus"></i> Tambah Transfer Masuk</a>
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
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Transfer</th>
                            <th class="text-center">Tgl. Bank</th>
                            <th class="text-center">Bank</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $no=1;
                    @endphp

                    @foreach($tf_masuk as $p)
                    <tr>
                        <td class="text-left">{{ $p->id_transfer }}</td>
                        <td class="text-center">{{ Carbon\Carbon::parse($p->tanggal_bank)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $p->bank }}</td>
                        <td class="text-left">{{ $p->keterangan }}</td>
                        <td class="text-right">{{ number_format($p->details->where('akuntansi_to', 'D')->sum('total'), 0, '.', ',') }}</td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm" href="{{ route('transfer-masuk.details', ['id_transfer' => $p->id_transfer, 'id_header']) }}"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            List Transfer Masuk
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Transfer</th>
                            <th class="text-center">Tgl. Bank</th>
                            <th class="text-center">Bank</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php
                    $no=1;
                    @endphp

                    @foreach($tf_masuk_validated as $p)
                    <tr>
                        <td class="text-left">{{ $p->id_transfer }}</td>
                         <td class="text-center">{{ Carbon\Carbon::parse($p->tanggal_bank)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $p->bank }}</td>
                        <td class="text-left">{{ $p->keterangan }}</td>
                        <td class="text-right">{{ number_format($p->details->where('akuntansi_to', 'D')->sum('total'), 0, ',', ',') }}</td>
                        <td class="text-center">

                            <form action="{{ route('transfer-masuk.delete', $p->id) }}" method="POST" id="form_delete_{{ $p->id }}" data-id="{{ $p->id }}">    

                                @csrf
                                @method('DELETE')
                                
                            </form>
                            
                            <a class="btn btn-warning btn-sm" href="{{ route('transfer-masuk.cetak', $p->id_transfer ) }}"><i class="fas fa-print"></i></a>
                            <a class="btn btn-danger btn-sm" onclick="Delete('{{ $p->id }}')"><i class="fas fa-times"></i></a>
                            
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

<script>
function printAndRefresh(url){
    window.open(url, '_blank');
    
    window.location.reload();
} 
</script>

@endsection