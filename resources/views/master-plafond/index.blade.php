@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Master Plafond Toko</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('master-plafond.create') }}"><i class="fas fa-plus"></i> Tambah Plafond</a>
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
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">Kode Toko</th>
                            <th class="text-center">Nama Toko</th>
                            <th class="text-center">Limit Plafond</th>
                            <th class="text-center">Sisa Plafond</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($plafond as $p)
                        <tr>
                            <td class="text-center">{{ $p->kd_outlet }}</td>
                            <td class="text-left">{{ $p->nm_outlet }}</td>
                            <td class="text-right">{{ number_format($p->nominal_plafond, 0, '.', ',') }}</td>
                            <td class="text-right">{{ number_format(($p->nominal_plafond) - ($p->invoice_header->where('flag_pembayaran_lunas', 'N')->flatMap->details_invoice->sum('nominal_total')), 0, '.', ',') }}</td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('master-plafond.tambah', $p->id ) }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('master-plafond.kurang', $p->id ) }}">
                                    <i class="fas fa-minus"></i>
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