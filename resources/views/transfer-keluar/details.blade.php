@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Details Kas Keluar</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('transfer-keluar.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('warning'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($balancing != 0)
        <div class="alert alert-danger text-center">
            <p style="color:white; text-transform: uppercase;"><b>Transfer Keluar Tidak Balance, Periksa Kembali Data Anda!</b></p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-8 p-1">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-left">Tgl. Transaksi</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->tanggal_bank }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">No. Transfer</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->id_transfer }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Bank</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->bank }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Keterangan</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $transfer->keterangan }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12 p-1" id="main" data-loading="true">
                <form action="{{ route('transfer-keluar.store-details')}}" method="POST">
                    @csrf
                    <div class="table-container">
                        <table class="table table-hover table-sm bg-light table-striped table-bordered" id="table">
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center">Perkiraan</th>
                                    <th class="text-center">Akuntansi To</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody class="input-fields">
                                <tr>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <select name="perkiraan" class="form-control mr-2 my-select">     
                                                <option value="">-- Pilih Perkiraan --</option>
                                                @foreach($perkiraan as $s)
                                                    <option value="{{ $s->id_perkiraan }}">{{ $s->id_perkiraan }} - {{ $s->nm_perkiraan }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <select name="akuntansi_to" class="form-control mr-2">
                                                <option value="">-- Pilih --</option>
                                                <option value="D">DEBET</option>
                                                <option value="K">KREDIT</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <input type="hidden" name="id_transfer" value="{{ $transfer->id_transfer  }}">
                                            <input type="text" id="nominal" name="total" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>                           
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12 p-1" id="main" data-loading="true">
                <div class="table-container">
                    <table class="table table-hover table-sm bg-light table-striped table-bordered" id="table">
                        <thead>
                            <tr style="background-color: #6082B6; color:white">
                                <th class="text-center">Perkiraan</th>
                                <th class="text-center">Akuntansi To</th>
                                <th class="text-center">DEBET</th>
                                <th class="text-center">KREDIT</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="input-fields">
                            @foreach($transfer->details as $i)
                            <tr>
                                <td class="text-left">
                                    {{ $i->details_perkiraan->id_perkiraan }} - {{ $i->details_perkiraan->nm_sub_perkiraan }}
                                </td>
                                <td class="text-center">
                                    @if($i->akuntansi_to == 'D')

                                    DEBET
                                    @else

                                    KREDIT
                                    @endif
                                </td>
                                @if($i->akuntansi_to == 'D')
                                <td class="text-right">
                                    {{ number_format($i->total, 0, ',', '.') }}
                                </td>
                                <td></td>
                                
                                @else
                                <td></td>
                                <td class="text-right">
                                    {{ number_format($i->total, 0, ',', '.') }}
                                </td>
                                @endif
                                <td class="text-center">
                                    <form action="{{ route('transfer-keluar.delete-details', $i->id) }}" method="POST" id="form_delete_{{ $i->id }}" data-id="{{ $i->id }}">

                                        @csrf
                                        @method('DELETE')
                                        
                                        <a class="btn btn-danger btn-sm" onclick="Hapus('{{$i->id}}')"><i class="fas fa-times"></i></a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    //HAPUS

    Hapus = (id)=>{
        Swal.fire({
            title: 'Apa anda yakin menghapus data detail transfer keluar ini?',
            text:  "Data tidak dapat kembali" ,
            showCancelButton: true,
            confirmButtonColor: '#3085d6' ,
            cancelButtonColor: 'red' ,
            confirmButtonText: 'hapus data' ,
            cancelButtonText: 'batal' ,
            reverseButtons: false
            }).then((result) => {
                if (result.value) {
                    document.getElementById('form_delete_' + id).submit();
                }
        })
    }

    function updateData() {
        var dariToko = document.getElementsByName('dari_toko')[0];
        var tokoSelection = document.getElementById('toko-selection');

        if (dariToko.value == '1') {
            tokoSelection.style.display = 'block';
        } else {
            tokoSelection.style.display = 'none';
        }
    }
</script>

@endsection