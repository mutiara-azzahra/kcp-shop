@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
             <div class="float-left">
                <h4>Laporan Penjualan Kelompok Produk</h4>
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
            Pilih Periode
        </div>
        <div class="card-body">
            <form action="{{ route('laporan-kelompok-produk.view') }}"  method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-12">
                        <strong>Produk</strong><br>
                        <select name="produk" class="form-control mb-2" id="toko-selection">     
                            <option value="">-- Pilih Produk --</option>
                            <option value="1">ICHIDAI</option>
                            <option value="2">BRIO</option>
                            <option value="3">LIQUID</option>
                            <option value="4">ALL PRODUK</option>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <strong>Kelompok Produk</strong><br>
                        <select name="kelompok_produk" class="form-control mb-2" id="toko-selection">     
                            <option value="">-- Pilih Kelompok Produk --</option>
                            <option value="1">ICHIDAI</option>
                            <option value="2">BRIO</option>
                            <option value="3">LIQUID</option>
                            <option value="4">ALL KELOMPOK PRODUK</option>
                        </select>
                    </div>
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
    $('.my-select-1').select2({
        width: '100%'
    });
</script>


<script>
    let getKecamatan = async () => {
        const id_kota =  $('#id_kota').val();
        const endpoint = '/api/kecamatan/'+id_kota

        const response = await axios.get('/api/kecamatan/'+ id_kota).catch(error => console.log(error));
        console.log(response.data)
        const data_kecamatan = response.data
        const kecamatanEl = $('#id_kecamatan')

        kecamatanEl.children('option:not(:first)').remove();
        
        data_kecamatan.map((data) => {
            kecamatanEl.append(
                '<option value="'+data.id_kecamatan+'">'+data.nama_kecamatan+'</option>'
            )
        })
    }

    let getKelurahan = async () => {
    const id_kecamatan =  $('#id_kecamatan').val();
    const endpoint = '/api/kelurahan/'+id_kecamatan

        const response = await axios.get('/api/kelurahan/'+id_kecamatan).catch(error => console.log(error));
        const data_kelurahan = response.data
        const kelurahanEl = $('#id_kelurahan')

        kelurahanEl.children('option:not(:first)').remove();

        data_kelurahan.map((data) => {
            kelurahanEl.append(
                '<option value="'+data.id_kelurahan+'">'+data.nama_kelurahan+'</option>'
            )
        })
    }
</script>

@endsection