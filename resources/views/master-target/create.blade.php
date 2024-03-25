@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Tambah Target Sales</h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-target.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('master-target.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-2">
                            <strong>Pilih Sales</strong>
                            <select name="sales" class="form-control my-select" >
                                <option value="">---Pilih Sales--</option>
                                <option value="muhammad">Muhammad</option>
                                <option value="juliandari">Juliandari</option>
                                <option value="yana2">Yana</option>
                                <option value="fazar">Fazar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <label for="">Bulan</label>
                        <select name="bulan" class="form-control mr-2 my-select">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <label for="">Tahun</label>
                        <select class="form-control mr-2 my-select" id="date-dropdown" name="tahun">
                            <option value="">-- Pilih Tahun --</option>
                        </select>
                    </div>
                    <div class="form-group mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <strong>Nominal</strong>
                            <input type="text" id="rupiah" name="nominal" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <div class="float-right pt-3">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>                            
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')

<script>
    //tahun
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

    //separator rupiah
    var rupiah = document.getElementById("rupiah");

    rupiah.addEventListener("keyup", function(e) {
    rupiah.value = formatRupiah(this.value);
    });

    function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }
</script>

@endsection