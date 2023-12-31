@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4><b>Master Plafond Toko</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('master-plafond.create') }}"><i class="fas fa-plus"></i> Tambah Plafond</a>
            </div>
        </div>
    </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
            @endif

            <div class="card" style="padding: 10px;">
                <div class="card-body">
                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center">Kode Toko</th>
                                    <th class="text-center">Nama Toko</th>
                                    <th class="text-center">Plafond</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=1;
                                @endphp

                                @foreach($plafond as $p)
                                <tr>
                                    <td class="text-center">{{ $p->kd_outlet }}</td>
                                    <td class="text-left">{{ $p->nm_outlet }}</td>
                                    <td class="text-left">Rp. {{ number_format($p->nominal_plafond, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="{{ route('master-plafond.detail', $p->id ) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
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

@endsection