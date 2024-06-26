@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Edit Detail Sales Order</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('validasi-so.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form action="{{ route('validasi-so.store_edit', ['id' => $details->id]) }}" method="POST">
        @csrf
        <div class="card" style="padding: 10px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 p-1">
                        <table class="table table-hover table-bordered table-sm bg-light table-striped" >
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center">Part No</th>
                                    <th class="text-center">Qty SO</th>
                                    <th class="text-center">Diskon (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td class="text-center">
                                    <div class="form-group col-12">
                                        <input type="text" name="part_no" class="form-control" value="{{ $details->part_no }}" readonly>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group col-12">
                                        <input type="number" name="qty" class="form-control" value="{{ $details->qty }}">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group col-12">
                                        <input type="text" name="disc" class="form-control" value="{{ $details->disc }}">
                                    </div>
                                </td>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')

<script>
    function updateData(){
        const rak = $(`#package option:selected`).data('rak');

        const formattedRak = Number(rak).toLocaleString('id-ID');

        $(`#rak`).val(formattedRak);
    }
</script>

@endsection