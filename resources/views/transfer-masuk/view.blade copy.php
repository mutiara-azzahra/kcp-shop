@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Validasi Transfer Masuk</h4>
            </div>
            <div class="float-right">
            <form method="POST" action="{{ route('transfer-masuk.store-validasi', $transfer->id_transfer) }}">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-warning m-1">
                    <i class="fas fa-check"></i> Selesai Validasi
                </button>
                <a class="btn btn-success m-1" href="{{ route('transfer-masuk.edit') }}"><i class="fas fa-arrow-left"></i> Ubah</a>
                <a class="btn btn-success m-1" href="{{ route('transfer-masuk.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </form>
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
            <div class="col-lg-8 p-1">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-left">No. Transfer</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->id_transfer }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Transfer Via</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->bank }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Keterangan</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->keterangan }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Nominal</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ number_format($transfer->details->where('akuntansi_to', 'D')->sum('total'), 0, ',', ',') }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Kas Masuk</th>
                            <th class="text-center">Kode Toko</th>
                            <th class="text-center">Toko</th>
                            <th class="text-center">Pembayaran Via</th>
                            <th class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($transfer->kas_masuk as $k)
                        <tr>
                            <td class="text-left">{{ $k->no_kas_masuk }}</td>
                            <td class="text-center">{{ $k->kd_outlet }}</td>
                            <td class="text-left">{{ $k->outlet->nm_outlet }}</td>
                            <td class="text-center">{{ $k->pembayaran_via }}</td>
                            <td class="text-right">{{ number_format($k->nominal, 0, ',', ',') }}</td>
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