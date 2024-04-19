@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Ubah Transfer Masuk</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success m-1" href="{{ route('transfer-masuk.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                <form action="{{ route('transfer-masuk.store-transfer', $transfer->id_transfer ) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>No. Transfer Masuk</strong>
                            <input type="text" name="kode_produk" class="form-control" value="{{ $transfer->id_transfer }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Transfer Via</strong>
                            <select name="bank" class="form-control my-select" >
                                <option value="">--Pilih Bank--</option>
                                <option value="BRI">BRI</option>
                                <option value="BNI">BNI</option>
                                <option value="MANDIRI">MANDIRI</option>
                                <option value="BCA">BCA</option>
                                <option value="DANAMON">DANAMON</option>
                                <option value="DANAMON_REGULER">DANAMON REGULER</option>
                            </select>

                            <select name="sales" class="form-control my-select" value="{{ $transfer_masuk->bank }}">
                                <option value="">---Pilih sales--</option>
                                <option value="bank" {{ $transfer_masuk->bank ==  $transfer_masuk->bank ? 'selected' : '' }}>{{ $transfer_masuk->bank }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Keterangan</strong>
                            <input type="text" name="keterangan" class="form-control" value="{{ $master_produk_id->keterangan }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Nominal</strong>
                            <input type="text" name="keterangan" class="form-control" value="{{ $master_produk_id->keterangan }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>                            
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

@endsection