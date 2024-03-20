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
                        
                        @foreach($list_area as $p)
                        <tr>
                            <td class="text-center">[]</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-left"></td>
                            <td class="text-center">
                                
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
                    document.getElementById('form_delete_' + id).submit();
                }
        })
    }

</script>

@endsection