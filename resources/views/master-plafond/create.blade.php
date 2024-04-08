@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4><b>Tambah Master Part</b></h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('master-part.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                        <form action="{{ route('master-part.store') }}" method="POST">
                        @csrf

                        {{-- `id`, `part_no`, `part_nama`, `diskon`, `id_supplier`, `id_kategori_part`, 
                                    `id_group_part`, `id_produk_part`, `id_kelompok_part`, `status`, `created_at`, 
                                    `updated_at`, `created_by`, `updated_by` --}}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Part No</strong>
                                    <input type="text" name="part_no" class="form-control" placeholder="contoh: 12-ABCD-XD">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Nama Part</strong>
                                    <input type="text" name="part_nama" class="form-control" placeholder="contoh: AIR AKI">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Kategori Part</strong>
                                    <select name="id_kategori_part" class="form-control" >
                                        <option value="">---Pilih Kategori Part--</option>
                                        @foreach($kategori as $k)
                                            <option value=" {{ $k->id }}"> {{ $k->kategori_part }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Group Part</strong>
                                    <select name="id_group_part" class="form-control" >
                                        <option value="">---Pilih Group Part--</option>
                                        @foreach($group as $k)
                                            <option value=" {{ $k->id }}"> {{ $k->group_part }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Produk Part</strong>
                                    <select name="id_produk_part" class="form-control" >
                                        <option value="">---Pilih Produk Part--</option>
                                        @foreach($produk as $k)
                                            <option value=" {{ $k->id }}"> {{ $k->produk_part }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Kelompok Part</strong>
                                    <select name="id_kelompok_part" class="form-control" >
                                        <option value="">---Pilih Kelompok Part--</option>
                                        @foreach($kelompok as $k)
                                            <option value=" {{ $k->id }}"> {{ $k->kelompok_part }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <div class="float-right">
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
      $(function () {
        $("#example1")
          .DataTable({
            paging: true,
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
          })
          .buttons()
          .container()
          .appendTo("#example1_wrapper .col-md-6:eq(0)")
                  
        $("#example2").DataTable({
          paging: true,
          lengthChange: false,
          searching: false,
          ordering: true,
          info: true,
          autoWidth: false,
          responsive: true,
        });
      });
    </script>
    
    <script>
    $(document).ready(function() {
        $('#tanggal_awal').change(function() {
            var selectedDate = $(this).val();
            
            if (selectedDate) {
                // Get the year and month from the selected date
                var year = selectedDate.split('-')[0];
                var month = selectedDate.split('-')[1];
                
                // Set the date input to the first day of the selected month
                var firstDayOfMonth = year + '-' + month + '-01';
                $(this).val(firstDayOfMonth);
            }
        });
    });
    </script>

@endsection