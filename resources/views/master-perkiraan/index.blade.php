@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Master Perkiraan</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('master-perkiraan.create') }}"><i class="fas fa-plus"></i> Tambah Perkiraan</a>
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
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No</th>
                            <th class="text-center">Perkiraan - Sub Perkiraan</th>
                            <th class="text-center">Nama Perkiraan</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Akuntansi To</th>
                            <th class="text-center">Saldo</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp

                        @foreach($list_perkiraan as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}.</td>
                            <td class="text-left">{{ $p->nm_perkiraan }}</td>
                            <td class="text-center">{{ $p->perkiraan }}.{{ $p->sub_perkiraan }}</td>
                            <td class="text-left">{{ $p->kategori }}</td>
                            <td class="text-left">
                                @if($p->sts_perkiraan == 'D')
                                DEBIT
                                @elseif($p->sts_perkiraan == 'K')
                                KREDIT
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($p->saldo, 0, ',', ',') }}</td>
                            <td class="text-center"> 
                                <form action="{{ route('master-perkiraan.nonaktif', $p->id) }}" method="GET" id="form_nonaktif_{{ $p->id }}" data-nonaktif="{{ $p->id }}">                                       
                                    @csrf
                                    @method('GET')
                                </form>

                                <form action="{{ route('master-perkiraan.delete', $p->id) }}" method="POST" id="form_delete_{{ $p->id }}" data-id="{{ $p->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <a class="btn btn-info btn-sm" href="{{ route('master-perkiraan.edit',$p->id) }}" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-warning btn-sm" onclick="Nonaktif('{{ $p->id }}')" data-toggle="tooltip" data-placement="top" title="Nonaktifkan"><i class="fas fa-ban"></i></a>
                                <a class="btn btn-danger btn-sm" onclick="Hapus('{{ $p->id }}')"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Hapus"></i></a>
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
            confirmButtonText: 'hapus data' ,
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