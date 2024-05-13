@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Jurnal</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('jurnal.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h3>Periode {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h3>
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
                        <tr style="background-color: #32CD32; color:black">
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Trx</th>
                            <th class="text-center">Perkiraan</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Kredit</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($jurnal_header as $i)
                        <tr>
                            <td class="text-center" style="background-color: #89CFF0; color:black">{{ $i->trx_date }}</td>
                            <td class="text-center" style="background-color: #89CFF0; color:black">{{ $i->trx_from }}</td>
                            <td class="text-left" style="background-color: #89CFF0; color:black" colspan="4">{{ $i->keterangan }}</td>
                            
                            @foreach ($i->details as $d)
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center">{{ $d->perkiraan }}</td>
                                <td class="text-left">{{ $d->details_perkiraan->nm_perkiraan }}</td>
                                <td class="text-right">{{ number_format($d->debet, 0, ',', ',') }}</td>
                                <td class="text-right">{{ number_format($d->kredit, 0, ',', ',') }}</td>
                            </tr>
                            @endforeach
                            
                        </tr>
                    @endforeach

                    <tr>
                        <td class="text-center" style="background-color:#e6e866; color:black" colspan="4"><b>TOTAL</b></td>
                        <td class="text-right" style="background-color:#e6e866; color:black"><b>{{ number_format($sum_debet, 0, ',', ',') }}</b></td>
                        <td class="text-right" style="background-color:#e6e866; color:black"><b>{{ number_format($sum_kredit, 0, ',', ',') }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')


@endsection