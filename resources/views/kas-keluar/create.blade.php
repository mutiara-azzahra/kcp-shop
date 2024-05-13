@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Tambah Kas Keluar</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('kas-keluar.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('kas-keluar.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Tanggal Transaksi</strong>
                            <input type="date" name="trx_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Pembayaran</strong>
                            <input type="text" name="pembayaran" class="form-control" placeholder="Isi pembayaran">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Keterangan</strong>
                            <input type="text" name="keterangan" class="form-control" placeholder="Isi keterangan">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Nominal</strong>
                            <input type="text" id="nominal" name="nominal" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan Data</button>                            
                        </div>
                    </div>
                </div>
            </form>
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