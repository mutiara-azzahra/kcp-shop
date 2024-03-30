@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Modal DBP</h4>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-danger" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            Pilih Periode
        </div>
        <div class="card-body">
            <form action="{{ route('modal.store') }}"  method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="">Bulan</label>
                        <select name="bulan" class="form-control mr-2">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="">Tahun</label>
                        <select class="form-control mr-2" id="date-dropdown" name="tahun">
                            <option value="">-- Pilih Tahun --</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div class="float-right pt-3">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Proses Data</button>                            
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="padding: 20px;">
        <div class="card-body p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">No.</th>
                            <th class="text-center">No Invoice</th>
                            <th class="text-center">Part No</th>
                            <th class="text-center">Qty Pembelian</th>
                            <th class="text-center">Modal per item</th>
                            <th class="text-center">Modal DBP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        
                        @foreach($getModalDbp as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}.</td>
                            <td class="text-left">{{ $p->noinv }}</td>
                            <td class="text-left">{{ $p->part_no }}</td>
                            <td class="text-right">{{ number_format($p->qty_terjual, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format($p->modal, 0, ',', ',') }}</td>
                            <td class="text-right">{{ number_format(($p->nominal_modal), 0, ',', ',') }}</td>
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
  let dateDropdown = document.getElementById('date-dropdown'); 
       
  let currentYear = new Date().getFullYear();    
  let earliestYear = 2022;     
  while (currentYear >= earliestYear) {      
    let dateOption = document.createElement('option');          
    dateOption.text = currentYear;      
    dateOption.value = currentYear;        
    dateDropdown.add(dateOption);      
    currentYear -= 1;    
  }

</script>

@endsection