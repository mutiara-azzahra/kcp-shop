@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Invoice</h4>
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
        <div class="card-header">
            <div class="col-lg-12">
                List Sales Order yang Belum Invoice
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No Sales Order</th>
                            <th class="text-center">Kode Toko</th>
                            <th class="text-center">Nama Toko</th>
                            <th class="text-center">Nominal Invoice</th>
                            <th class="text-center">Nama Sales</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach($so_approved as $s)
                        <tr>
                            <td class="text-left">KCP/NON/{{ $s->noso }}</td>
                            <td class="text-center">{{ $s->kd_outlet}} </td>
                            <td class="text-left">{{ $s->nm_outlet }}</td>
                            <td class="text-left" style="background-color: yellow;">{{ number_format($s->details_so->sum('nominal_total'), 0, ',', ',')  }}</td>
                            <td class="text-center">{{ $s->user_sales}}</td>
                            <td class="text-center">
                                <a class="btn btn-success btn-sm" href="{{ route('invoice.approve', $s->noso) }}"><i class="fas fa-check"></i></a>
                                <a class="btn btn-danger btn-sm" href="{{ route('invoice.reject', $s->noso) }}"><i class="fas fa-ban"></i> </a>
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
            <div class="col-lg-12">
                List Invoice
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example3">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Invoice</th>
                            <th class="text-center">No. Sales Order/SO</th>
                            <th class="text-center">Kode | Nama Toko</th>
                            <th class="text-center">Nominal Invoice</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        @foreach($invoice as $s)
                        <tr>
                            <td class="text-left">{{ $s->noinv }}</td>
                            <td class="text-left">{{ $s->noso }}</td>
                            <td class="text-left">{{ $s->kd_outlet }}/{{ $s->nm_outlet }}</td>
                            <td class="text-right">{{ number_format($s->details_invoice->sum('nominal_total'), 0, ',', ',') }}</td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm" href="{{ route('invoice.cetak', $s->noinv) }}" target="_blank"><i class="fas fa-print"></i></a>
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