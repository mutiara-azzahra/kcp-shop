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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Produk</strong>
                            <select name="kode_produk" class="form-control" id="kode_produk" onchange="getSubProduk()">
                                <option value="">---Pilih Produk--</option>
                                @foreach($all_produk as $k)
                                    <option value=" {{ $k->kode_produk }}"> {{ $k->keterangan }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Sub Produk</strong>
                            <select name="sub_produk" class="form-control" id="sub_produk" >
                                <option value="">---Pilih Sub Produk--</option>
                            </select>
                        </div>
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
    
    let getSubProduk = async () => {
        const kode_produk =  $('#kode_produk').val();

        const endpoint = '/api/produk/'+kode_produk

        const response = await axios.get('/api/produk/'+ kode_produk).catch(error => console.log(error));
        console.log(response.data)
        const data_sub_produk = response.data
        const subProdukEl = $('#sub_produk')

        subProdukEl.children('option:not(:first)').remove();
        
        data_sub_produk.map((data) => {
            subProdukEl.append(
                '<option value="'+data.sub_produk+'">'+data.keterangan+'</option>'
            )
        })
    }

</script>

@endsection