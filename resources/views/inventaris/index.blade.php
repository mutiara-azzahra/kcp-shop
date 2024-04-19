@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4><b>Aset</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('inventaris.create') }}"><i class="fas fa-plus"></i> Tambah Aset</a>
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

            {{-- <div class="card" style="padding: 10px;">
                <div class="card-body">
                    <strong>Tata Cara Proses Inventaris</strong><br>
                    <ul>
                        <li>Dilakukan pada tanggal 31 sebanyak <strong>1 x</strong> dalam 1 bulan</li>
                        <li>Apabila sudah diproses untuk dua area, dapat dilihat hasilnya pada tombol Lihat Nilai Inventaris Bulanan</li>
                    </ul>
                </div>
            </div> --}}

        <div class="card" style="padding: 10px;">
            {{-- <div class="card-body">
                        <form action="{{ route('inventaris.store') }}"  method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" id="" class="form-control" placeholder="">
                                </div>

                                <div class="form-group col-6">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="" class="form-control" placeholder="">
                                </div>
                            </div>

                            <div class="float-right pt-2">
                                <button class="btn btn-warning" type="submit"><i class="fas fa-check"></i> Proses</button>
                            </div>
                        </form>
                </div>
            </div> --}}

            <div class="card" style="padding: 10px;">
                <div class="card-body">
                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Departemen</th>
                                    <th class="text-center">Tahun Ekonomis</th>
                                    <th class="text-center">Harga Beli</th>
                                    <th class="text-center">Penyusutan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=1;
                                @endphp

                                @foreach($inventaris as $p)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $p->kode }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td class="text-center">{{ $p->kelompok }}</td>
                                    <td>{{ $p->departement }}</td>
                                    <td class="text-center">{{ $p->tahun_ekonomis }} tahun</td>
                                    <td class="text-right">{{ $p->hrg_beli }}</td>
                                    <td class="text-center"><a class="btn btn-info btn-sm" href="{{ route('inventaris.show',$p->kode) }}"><i class="fas fa-eye"></i></a></td>
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