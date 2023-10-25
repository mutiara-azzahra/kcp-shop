@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Surat Jalan / SJ</h4>
            </div>
            {{-- <div class="float-right">
                <a class="btn btn-warning" href="{{ route('surat-jalan.reset') }}"><i class="fas fa-refresh"></i> Reset Surat Jalan</a>
            </div> --}}
        </div>
    </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="myAlert">
                    <p>{{ $message }}</p>
                </div>  
            @endif

            <div class="card" style="padding: 10px;">
                <div class="card-header">
                    <div class="col-lg-12">
                        <div class="float-left">
                            List Packingsheet
                        </div>       
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">

                        @foreach($invoice_belum_sj as $s)
                                
                        <form action="{{ route('surat-jalan.store_sj', ['noso' => $s->noso ]) }}" method="POST">
                        @csrf
                        
                        @endforeach

                        <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center"></th>
                                    <th class="text-center">Toko</th>
                                    <th class="text-center">No. P/S</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">No. SO</th>
                                    <th class="text-center">No. Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=1;
                                @endphp

                                @foreach($invoice_belum_sj as $s)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_items[]" value="{{ $s->noso }}">
                                        </div>
                                    </td>
                                    <td>{{ $s->kd_outlet }} - {{ $s->nm_outlet }}</td>
                                    <td>KCP/{{ $s->area_so }}/{{ $s->ps->nops }}</td>
                                    <td>{{ $s->area_so }}</td>
                                    <td>{{ $s->noso }}</td>
                                    <td>{{ $s->invoice->noinv }}</td>
                                    
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                        <div class="float-left">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>                            
                        </div>
                    </div>

                    </form>

                </div>
            </div>

            <div class="card" style="padding: 10px;">
                <div class="card-header">
                    <div class="col-lg-12">
                        <div class="float-left">
                            List Surat Jalan
                        </div>       
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example2">
                            <thead>
                                <tr style="background-color: #6082B6; color:white">
                                    <th class="text-center">No. Surat Jalan</th>
                                    <th class="text-center">Toko</th>
                                    <th class="text-center">Koli</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=1;
                                @endphp

                                @foreach($surat_jalan as $s)
                                @foreach($s->details_sj as $d)
                                <tr>
                                    
                                    <td>{{ $s->nosj }}</td>
                                    <td>{{ $d->kd_outlet }}/{{ $d->header_ps->nm_outlet }}</td>
                                    <td class="text-center">{{ $d->koli }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-warning btn-sm" href="{{ route('surat-jalan.cetak', $s->nosj) }}" target="_blank"><i class="fas fa-print"></i></a>
                                    </td>
                                    
                                </tr>
                                @endforeach
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