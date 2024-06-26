@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Laporan Penjualan Produk</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('laporan-penjualan-produk.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    @foreach($groupedInvoices as $i => $group)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-center">{{ App\Models\MasterSubProduk::where('sub_produk', $i)->value('keterangan') }}</td>
                            <td class="text-right">{{ number_format($group->sum('nominal_total'), 0, ',', ',') }}</td>
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