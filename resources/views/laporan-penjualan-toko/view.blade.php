@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Laporan Penjualan Toko</h4>
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
                            <th class="text-center">Kode Outlet</th>
                            <th class="text-center">Nama Outlet</th>
                            @php
                                $uniqueMonths = [];

                                foreach ($nominal_perbulan as $invoicesByMonth) {
                                    foreach ($invoicesByMonth as $month => $invoices) {
                                        $uniqueMonths[$month] = \Carbon\Carbon::parse($month)->format('M Y');
                                    }
                                }
                            @endphp
                            @foreach ($uniqueMonths as $month)
                                <th class="text-center">{{ $month }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($nominal_perbulan as $kd_outlet => $invoicesByMonth)
                            <tr>
                                <td class="text-left">{{ $kd_outlet }}</td>
                                <td class="text-left">{{ $invoicesByMonth->first()->first()->nm_outlet }}</td>
                                @foreach ($uniqueMonths as $month => $monthLabel)
                                    <td class="text-right">
                                        {{ $invoicesByMonth->has($month) ? number_format($invoicesByMonth[$month]->sum(function ($invoice) {
                                            return $invoice->details_invoice->sum('nominal_total');
                                        }) , 0, ',', ',') : 0 }}
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