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
                <button type="submit" class="btn btn-primary m-1">
                    <i class="fas fa-check"></i> Selesai Validasi
                </button>
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
            <form method="POST" action="{{ route('transfer-masuk.store-update') }}">
                    @csrf
                    @method('POST')

                <div class="col-lg-8 p-1">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-left">Tgl. Rincian Tagihan</th>
                            <td>:</td>
                            @if(isset($transfer->kas_masuk->tanggal_rincian_tagihan))
                            <td class="text-left">{{ Carbon\Carbon::parse($transfer->kas_masuk->tanggal_rincian_tagihan)->format('d-m-Y') }}</td>
                            @else
                            <td class="text-left"><input type="date" name="tanggal_rincian_tagihan" class="form-control"></td>
                            @endif

                        </tr>
                        <tr>
                            <th class="text-left">No. Transfer</th>
                            <td>:</td>
                            <td class="text-left">{{ $transfer->id_transfer }}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Bank</th>
                            <td>:</td>
                            <td class="text-left">{{ $transfer->bank }}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Toko</th>
                            <td>:</td>
                            <td class="text-left">[{{ $transfer->kd_outlet }}] {{ $transfer->outlet->nm_outlet }}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Nominal</th>
                            <td>:</td>
                            @if(isset($transfer->kas_masuk->nominal))
                            <td class="text-left">{{ number_format($transfer->kas_masuk->nominal, 0, ',', ',') }}</td>
                            @else
                            <td class="text-left"><input type="text" id="nominal" name="nominal_kas" class="form-control" placeholder="0"></td>
                            <input type="hidden" name="id_transfer" class="form-control" value="{{$transfer->id_transfer}}">
                            @endif
                        </tr>
                        <tr>
                            <th class="text-left">Nominal Bank</th>
                            <td>:</td>
                            <td class="text-left">{{ number_format($transfer->details->where('akuntansi_to', 'D')->sum('total'), 0, ',', ',') }}</td>
                        </tr>
                    </table>
                </div>
                @if(isset($transfer->kas_masuk->nominal))

                @else
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div class="float-right">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan Data</button>                            
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">Tgl. Rincian Tagihan</th>
                            <th class="text-center">Kode Toko</th>
                            <th class="text-center">Toko</th>
                            <th class="text-center">Pembayaran Via</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Pemotongan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        <tr>
                            <td class="text-left">{{ $transfer->kas_masuk->no_kas_masuk }}</td>
                            <td class="text-center">{{ $transfer->kas_masuk->kd_outlet }}</td>
                            <td class="text-left">{{ $transfer->kas_masuk->outlet->nm_outlet }}</td>
                            <td class="text-center">{{ $transfer->kas_masuk->pembayaran_via }}</td>
                            <td class="text-right">{{ number_format($transfer->kas_masuk->nominal, 0, ',', ',') }}</td>
                            <td class="text-center">{{ $transfer->kas_masuk->flag_kas_manual }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    document.getElementById('nominal').addEventListener('input', function() {
     
        let valueWithoutCommas = this.value.replace(/,/g, '');
        let formattedValue = formatNumberWithCommas(valueWithoutCommas);
        
        this.value = formattedValue;
    });
</script>

@endsection