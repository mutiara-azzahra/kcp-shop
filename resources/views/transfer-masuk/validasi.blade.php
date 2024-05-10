@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-2">
             <div class="float-left">
                <h4>Validasi Transfer Masuk</h4>
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
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No. Transfer</th>
                            <th class="text-center">Kode Toko</th>
                            <th class="text-center">Bank</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $no=1;
                    @endphp

                    @foreach($tf_kas as $p)
                    <tr>
                        <td class="text-left">{{ $p->id_transfer }}</td>
                        <td class="text-center">{{ $p->kd_outlet }}</td>
                        <td class="text-left">{{ $p->bank }}</td>
                        <td class="text-left">{{ $p->keterangan }}</td>
                        <td class="text-center">
                            <form action="{{ route('transfer-masuk.validasi-data', $p->id_transfer) }}" method="POST" id="form_validasi_{{ $p->id }}" data-id="{{ $p->id }}">

                                @csrf
                                @method('POST')
                                
                                <a class="btn btn-warning btn-sm" onclick="Validasi('{{$p->id}}')"><i class="fas fa-check"></i></a>
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
function printAndRefresh(url){
    window.open(url, '_blank');
    
    window.location.reload();
} 

    //VALIDASI

    Validasi = (id)=>{
        Swal.fire({
            title: 'Apa anda yakin validasi data transfer ini?',
            text:  "Data tidak dapat kembali" ,
            showCancelButton: true,
            confirmButtonColor: '#3085d6' ,
            cancelButtonColor: 'red' ,
            confirmButtonText: 'validasi data' ,
            cancelButtonText: 'batal' ,
            reverseButtons: false
            }).then((result) => {
                if (result.value) {
                    document.getElementById('form_validasi_' + id).submit();
                }
        })
    }

</script>   

@endsection