@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-1">
            <div class="float-left">
                <h4>Monitoring Stok Terjual</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('monitoring.pesanan') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h6>{{ $monthName }}</h6>
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

    <!-- ICHIDAI -->
    <div class="card" style="padding: 10px;">
        <div class="card-header">
            <b>GROUP ICHIDAI</b>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
            <table class="table table-hover table-bordered table-sm bg-light" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">Part No</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        @foreach($getPesananIchidai->groupBy('part_no') as $i)
                        <tr>
                            <td class="text-center">{{ $i->first()->part_no }}</td>
                            <td class="text-center">{{ $i->sum('qty') }}</td>
                            <td class="text-right">{{ number_format($i->sum('nominal_total'), 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-warning">
                            <td colspan="2" class="text-center"><b>TOTAL</b></td>
                            <td class="text-right"><b>Rp. {{ number_format($getPesananIchidai->sum('nominal_total'), 0, ',', '.') }}</b></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ICHIDAI -->
    <div class="card" style="padding: 10px;">
        <div class="card-header">
            <b>GROUP BRIO</b>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
            <table class="table table-hover table-bordered table-sm bg-light" id="example3">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">Part No</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        @foreach($getPesananBrio->groupBy('part_no') as $i)
                        <tr>
                            <td class="text-center">{{ $i->first()->part_no }}</td>
                            <td class="text-center">{{ $i->sum('qty') }}</td>
                            <td class="text-right">{{ number_format($i->sum('nominal_total'), 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-warning">
                            <td colspan="2" class="text-center"><b>TOTAL</b></td>
                            <td class="text-right"><b>Rp. {{ number_format($getPesananBrio->sum('nominal_total'), 0, ',', '.') }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BRIO -->
    <div class="card" style="padding: 10px;">
        <div class="card-header">
            <b>GROUP AIR AKI</b>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light" id="example4">
                        <thead>
                            <tr style="background-color: #6082B6; color:white">
                                <th class="text-center">Part No</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php
                            $no=1;
                            @endphp
                            
                            @foreach($getPesananAccu->groupBy('part_no') as $i)
                            <tr>
                                <td class="text-center">{{ $i->first()->part_no }}</td>
                                <td class="text-center">{{ $i->sum('qty') }}</td>
                                <td class="text-right">{{ number_format($i->sum('nominal_total'), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-warning">
                                <td colspan="2" class="text-center"><b>TOTAL</b></td>
                                <td class="text-right"><b>Rp. {{ number_format($getPesananAccu->sum('nominal_total'), 0, ',', '.') }}</b></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('script')

@endsection