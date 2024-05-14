@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Pembelian</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('pembelian-non-aop.create') }}"><i class="fas fa-plus"></i> Buat Pembelian Baru</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
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
                            <th class="text-center">Invoice Non</th>
                            <th class="text-center">Tanggal Nota</th>
                            <th class="text-center">Customer To</th>
                            <th class="text-center">Supplier</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        @foreach($pembelian as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-left">{{ $p->invoice_non }}</td>
                            <td class="text-left">{{ $p->tanggal_nota }}</td>
                            <td class="text-left">{{ $p->customer_to }}</td>
                            <td class="text-center">{{ $p->supplier }}</td>
                            <td class="text-right">{{ number_format($p->details_pembelian->sum('total_amount'), 0, ',', ',') }}</td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('pembelian-non-aop.pembelian-details',$p->id) }}">
                                    <i class="fas fa-eye"></i>
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