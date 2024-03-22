@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Master Provinsi</h4>
            </div>
            <div class="float-right">
                <a class="btn m-1 btn-success" href="{{ route('master-provinsi.create') }}"><i class="fas fa-plus"></i> Tambah Provinsi</a>
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
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">Kode Provinsi</th>
                            <th class="text-center">Provinsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        @foreach($list_provinsi as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $p->kode_prp }}</td>
                            <td class="text-left">{{ $p->provinsi }}</td>
                            <td class="text-center"> 
                                <form action="{{ route('master-provinsi.nonaktif', $p->kode_prp) }}" method="GET" id="form_nonaktif_{{ $p->kode_prp }}" data-nonaktif="{{ $p->kode_prp }}">                                       
                                    @csrf
                                    @method('GET')
                                </form>

                                <form action="{{ route('master-provinsi.delete', $p->kode_prp) }}" method="POST" id="form_delete_{{ $p->kode_prp }}" data-id="{{ $p->kode_prp }}">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <a class="btn btn-info btn-sm" href="{{ route('master-provinsi.edit',$p->kode_prp) }}" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-warning btn-sm" onclick="Nonaktif('{{ $p->kode_prp }}')" data-toggle="tooltip" data-placement="top" title="Nonaktifkan"><i class="fas fa-ban"></i></a>
                                <a class="btn btn-danger btn-sm" onclick="Hapus('{{ $p->kode_prp }}')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-times"></i></a>
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

    Nonaktif = (nonaktif)=>{

        Swal.fire({
            title: 'Apa anda yakin menonaktifkan data ini?',
            text:  "Data tidak dapat kembali" ,
            showCancelButton: true,
            confirmButtonColor: '#3085d6' ,
            cancelButtonColor: 'red' ,
            confirmButtonText: 'nonaktifkan data' ,
            cancelButtonText: 'batal' ,
            reverseButtons: false
            }).then((result) => {
                if (result.value) {
                    document.getElementById('form_nonaktif_' + nonaktif).submit();
                }
        })
    }

</script>

@endsection