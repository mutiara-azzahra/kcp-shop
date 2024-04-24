@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Edit Detail Packingsheet</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('packingsheet.details', $details->nops) }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    <form action="{{ route('packingsheet.store_edit', [$details->id , $details->nops])}}" method="POST">
    @csrf
        <div class="card" style="padding: 10px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 p-1">
                        <table class="table table-hover table-bordered table-sm bg-light table-striped" >
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center">Part No</th>
                                    <th class="text-center">Stok Rak</th>
                                    <th class="text-center">Qty</th>
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
                                        <input type="text" name="part_no" class="form-control" value="{{ $details->stok->stok }}" readonly>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group col-12">
                                        <input type="number" name="qty" class="form-control" value="{{ $details->qty }}">
                                    </div>
                                </td>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan Data</button>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@section('script')

@endsection