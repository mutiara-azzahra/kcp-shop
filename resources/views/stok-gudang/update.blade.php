@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4><b>Ubah Stok Gudang</b></h4>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('stok-gudang.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" id="myAlert">
                    <p>{{ $message }}</p>
                </div>
            @endif

        <div class="card" style="padding: 10px;">
                <div class="card-body">
                    <div class="col-lg-12">
                        <form action="{{ route('stok-gudang.update', $stok_id->id ) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Part No</strong>
                                    <input type="text" name="part_no" class="form-control" value="{{ $stok_id->part_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Stok</strong>
                                    <input type="number" name="stok" class="form-control" value="{{ $stok_id->stok }}">
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

      //alert success time
      function closeAlertAfterTime(alertId, milliseconds) {
            setTimeout(function () {
                var alertElement = document.getElementById(alertId);
                if (alertElement) {
                    alertElement.style.display = 'none'; 
                }
            }, milliseconds);
        }
        closeAlertAfterTime('myAlert', 2500);
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