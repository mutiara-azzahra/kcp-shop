@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Master Outlet</h4>
            </div>
            <div class="float-right">
                <a class="btn m-1 btn-success" href="{{ route('master-toko.create') }}"><i class="fas fa-plus"></i> Tambah Toko</a>
                <a class="btn m-1 btn-danger" href="{{ route('master-toko.list-pengajuan') }}"><i class="fas fa-list"></i> List Pengajuan</a>
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
                            <th class="text-center">Kode / Nama Toko</th>
                            <th class="text-center">Provinsi</th>
                            <th class="text-center">Kabupaten/Kota</th>
                            <th class="text-center">Telpon</th>
                            <th class="text-center">TOP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($list_toko as $p)
                        <tr>
                            <td class="text-left">[{{ $p->kd_outlet }}] {{ $p->nm_outlet }}</td>

                            @if( $p->kode_prp == 6300)
                            <td class="text-left">Kalimantan Selatan</td>
                            @elseif( $p->kode_prp == 6200)
                            <td class="text-left">Kalimantan Tengah</td>
                            @endif

                            @if(isset($p->area_outlet->nm_area))
                            <td class="text-left">{{ $p->area_outlet->nm_area }}</td>
                            @else
                            <td class="text-left"></td>
                            @endif

                            <td class="text-left">{{ $p->tlpn }}</td>
                            <td class="text-left">{{ $p->jth_tempo }}</td>
                            <td class="text-center">
                                <form action="{{ route('master-toko.nonaktif', $p->kd_outlet) }}" method="POST" id="form_nonaktif_{{ $p->kd_outlet }}" data-id="{{ $p->kd_outlet }}">
                                    
                                    <a class="btn btn-info btn-sm" href="{{ route('master-toko.details', $p->kd_outlet) }}" target="_blank"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('master-toko.edit', $p->kd_outlet) }}" target="_blank"><i class="fas fa-edit"></i></a>

                                    @csrf
                                    @method('POST')
                                    
                                    <a class="btn btn-danger btn-sm" onclick="Nonaktif('{{ $p->kd_outlet }}')"><i class="fas fa-times"></i></a>
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
    Nonaktif = (id)=>{
        Swal.fire({
            title: 'Apa anda yakin menghapus data area outlet ini?',
            text:  "Data tidak dapat kembali" ,
            showCancelButton: true,
            confirmButtonColor: '#3085d6' ,
            cancelButtonColor: 'red' ,
            confirmButtonText: 'hapus data' ,
            cancelButtonText: 'batal' ,
            reverseButtons: false
            }).then((result) => {
                if (result.value) {
                    document.getElementById('form_nonaktif_' + id).submit();
                }
        })
    }

</script>

@endsection