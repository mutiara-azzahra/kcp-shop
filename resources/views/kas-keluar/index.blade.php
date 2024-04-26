@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Kas Keluar</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('kas-keluar.create') }}"><i class="fas fa-plus"></i> Kas Keluar</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('warning'))
        <div class="alert alert-danger" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            Kas Keluar Belum Selesai
        </div>

        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">No. Kas Keluar</th>
                            <th class="text-center">Pembayaran</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($belum_selesai as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}.</td>
                            <td class="text-left">{{ $p->no_keluar }}</td>
                            <td class="text-left">{{ $p->pembayaran }}</td>
                            <td class="text-left">{{ $p->keterangan }}</td>
                            <td class="text-right">{{ number_format($p->details_keluar->where('akuntansi_to', 'D')->sum('total'), 0, ',', ',') }}</td>
                            <td class="text-center">
                                <form action="{{ route('kas-keluar.update', $p->id) }}" method="GET" id="form_selesai_{{ $p->id }}" data-selesai="{{ $p->id }}">
                                    @csrf
                                    @method('GET')
                                </form>

                                <form action="{{ route('kas-keluar.delete', $p->id) }}" method="POST" id="form_delete_{{ $p->id }}" data-id="{{ $p->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <a class="btn btn-info btn-sm" href="{{ route('kas-keluar.show', $p->no_keluar)}}"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-success btn-sm" onclick="Selesai('{{ $p->id }}')"><i class="fas fa-check"></i></a>
                                <a class="btn btn-danger btn-sm" onclick="Delete('{{ $p->id }}')"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            Kas Keluar
        </div>
        <div class="card-body">
            <form action=""  method="GET">
                <!-- @csrf -->
                <div class="row">
                    <div class="form-group col-6">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="" class="form-control" placeholder="">
                    </div>

                    <div class="form-group col-6">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div class="float-right pt-3">
                        <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Cari</button>                            
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Kas Keluar</th>
                            <th class="text-center">Pembayaran</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selesai as $p)
                        <tr>
                            <td class="text-left">{{ $p->no_keluar }}</td>
                            <td class="text-left">{{ $p->pembayaran }}</td>
                            <td class="text-left">{{ $p->keterangan }}</td>
                            <td class="text-right">{{ number_format($p->details_keluar->where('akuntansi_to', 'D')->sum('total'), 0, '.', ',') }}</td>
                            <td class="text-center">
                                <form action="{{ route('kas-keluar.delete', $p->id) }}" method="POST" id="form_hapus_{{ $p->id }}" data-hapus="{{ $p->id }}">
                                    
                                    <a class="btn btn-info btn-sm" href="{{ route('kas-keluar.details', $p->no_keluar)}}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('kas-keluar.cetak', $p->no_keluar)}}" target="_blank"><i class="fas fa-print"></i></a>

                                    @csrf
                                    @method('DELETE')
                                   
                                    <a class="btn btn-danger btn-sm" onclick="Hapus('{{ $p->id }}')"><i class="fas fa-times"></i></a>
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
@endsection

@section('script')

<script>
    Hapus = (hapus)=>{
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
                    document.getElementById('form_hapus_' + hapus).submit();
                }
        })
    }

    Delete = (id)=>{
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

    Selesai = (selesai)=>{
        console.log(selesai)

        Swal.fire({
            title: 'Selesaikan kas keluar ini?',
            text:  "" ,
            showCancelButton: true,
            confirmButtonColor: '#3085d6' ,
            cancelButtonColor: 'red' ,
            confirmButtonText: 'selesai' ,
            cancelButtonText: 'batal' ,
            reverseButtons: false
            }).then((result) => {
                if (result.value) {
                    document.getElementById('form_selesai_' + selesai).submit();
                }
        })
    }

</script>

@endsection