@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Monitoring Sales</h4>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-success" id="myAlert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-header">
            Pilih Sales, Tanggal Awal dan Tanggal Akhir
        </div>
        <div class="card-body">
            <form action="{{ route('monitoring.store') }}"  method="GET">
                <!-- @csrf -->
                <div class="row">
                    @if(Auth::user()->id_role == 24)
                    <div class="col-lg-12">
                        <div class="form-group mb-2">
                            <strong>Pilih Sales</strong>
                            <select name="sales" class="form-control my-select" >
                                <option value="">---Pilih Sales--</option>
                                @foreach($username as $a)
                                    <option value="{{ $a->username }}">{{ $a->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @elseif(Auth::user()->id_role == 20)
                    <div class="form-group col-lg-12">
                        <label for="">Sales</label>
                        <input type="text" name="sales" value="{{ Auth::user()->username }}" id="" class="form-control" readonly>
                    </div>
                    @endif
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
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Proses Data</button>                            
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
  let dateDropdown = document.getElementById('date-dropdown'); 
       
  let currentYear = new Date().getFullYear();    
  let earliestYear = 1970;     
  while (currentYear >= earliestYear) {      
    let dateOption = document.createElement('option');          
    dateOption.text = currentYear;      
    dateOption.value = currentYear;        
    dateDropdown.add(dateOption);      
    currentYear -= 1;    
  }
</script>

@endsection