@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Periode</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('laporan-penjualan-toko.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center">Kode Outlet</th>
                            <th class="text-center">Nama Outlet</th>
                            @php
                            $uniqueMonths = [];

                            foreach ($sumNominal as $i) {
                                foreach ($i as $month => $invoices) {
                                    $uniqueMonths[$month] = \Carbon\Carbon::parse($month)->format('M Y');
                                }
                            }

                            ksort($uniqueMonths);

                            @endphp
                            @foreach ($uniqueMonths as $month => $formattedMonth)
                                <th class="text-center">{{ $formattedMonth }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($sumNominal as $kd_outlet => $details)
                        <tr>
                            <td class="text-center">{{ $nama_produk }}</td>
                            <td class="text-center">{{ $kd_outlet }}</td>
                            <td class="text-left">{{ App\Models\MasterOutlet::where('kd_outlet', $kd_outlet)->value('nm_outlet') }}</td>                           

                            @foreach ($uniqueMonths as $month => $monthLabel)
                                <td class="text-right">
                                    {{ $details->has($month) ? number_format($details[$month], 0, ',', ',') : 0 }}
                                </td>
                            @endforeach

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