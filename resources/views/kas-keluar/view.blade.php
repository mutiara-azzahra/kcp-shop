@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Details Kas Keluar</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success m-1" href="{{ route('kas-keluar.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-8 p-1">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-left">Tgl. Transaksi</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ Carbon\Carbon::parse($kas_keluar->tanggal_transaksi)->format('d-m-Y') }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">No. Kas Keluar</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $kas_keluar->no_keluar }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Pembayaran</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $kas_keluar->pembayaran }}</b></td>
                    </tr>
                    <tr>
                        <th class="text-left">Keterangan</th>
                        <td>:</td>
                        <td class="text-left"><b>{{ $kas_keluar->keterangan }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12 p-1" id="main" data-loading="true">
                <form action="{{ route('kas-keluar.store-details')}}" method="POST">
                    @csrf
                    <div class="table-container">
                        <table class="table table-hover table-sm bg-light table-striped table-bordered" id="table">
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center">Perkiraan</th>
                                    <th class="text-center">Akuntansi To</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="input-fields">
                                <tr>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <select name="inputs[0][perkiraan]" class="form-control mr-2 my-select">
                                                <option value="">-- Pilih Perkiraan --</option>
                                                @foreach($perkiraan as $k)
                                                    <option value="{{ $k->id }}">{{ $k->perkiraan }}.{{ $k->sub_perkiraan }} - {{ $k->nm_perkiraan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <select name="inputs[0][akuntansi_to]" class="form-control mr-2">
                                                <option value="">-- Pilih --</option>
                                                <option value="D">DEBET</option>
                                                <option value="K">KREDIT</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <input type="hidden" name="inputs[0][no_keluar]" value="{{ $kas_keluar->no_keluar }}">
                                            <input type="text" name="inputs[0][total]" class="form-control">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-group col-12">
                                            <a type="button" class="btn btn-primary m-1" id="add"><i class="fas fa-plus"></i></a>                                                                                  
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
                                @foreach($kas_keluar->details_keluar as $i)
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
                                    <form action="{{ route('kas-keluar.delete-details', $i->id) }}" method="POST" id="form_delete_{{ $i->id }}" data-id="{{ $i->id }}">

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
    var i = 0;
    $('#add').click(function(){
        ++i;
        $('#table').append(`<tr>
            <td class="text-center">
                <div class="form-group col-12">
                    <select name="inputs[${i}][perkiraan]" class="form-control mr-2 my-select-1">
                        <option value="">-- Pilih Perkiraan --</option>
                        @foreach($perkiraan as $k)
                            <option value="{{ $k->id }}">{{ $k->perkiraan }}.{{ $k->sub_perkiraan }} - {{ $k->nm_perkiraan }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td class="text-center">
                <div class="form-group col-12">
                    <select name="inputs[${i}][akuntansi_to]" class="form-control mr-2">
                        <option value="">-- Pilih --</option>
                        <option value="D">DEBET</option>
                        <option value="K">KREDIT</option>
                    </select>
                </div>
            </td>
            <td class="text-center">
                <div class="form-group col-12">
                    <input type="hidden" name="inputs[${i}][no_keluar]" value="{{ $kas_keluar->no_keluar }}">
                    <input type="text" name="inputs[${i}][total]" class="form-control">
                </div>
            </td>
            <td class="text-center">
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-danger remove-table-row"><i class="fas fa-minus"></i></button>
                </div>
            </td>
        </tr>
        `);
        $('.my-select-1').select2({
            width: '100%'
        });
    });

    $(document).on('click','.remove-table-row', function(){
        $(this).parents('tr').remove();
    })

    // Hapus = (id)=>{
    //     Swal.fire({
    //         title: 'Apa anda yakin menghapus data ini?',
    //         text:  "menghapus notifikasi" ,
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6' ,
    //         cancelButtonColor: 'red' ,
    //         confirmButtonText: 'hapus data' ,
    //         cancelButtonText: 'batal' ,
    //         reverseButtons: false
    //         }).then((result) => {
    //             if (result.value) {
    //                 $('#form_delete').submit();
    //             }

    //     })
    // }

    Hapus = (id)=>{
        Swal.fire({
            title: 'Apa anda yakin menghapus data ini?',
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
</script>

@endsection