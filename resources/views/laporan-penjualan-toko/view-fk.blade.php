@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-2">
        <div class="col-lg-12 pb-3">
            <div class="float-left">
                <h4>Export Pajak Keluaran</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('export-pajak.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 pb-3">
            <div class="float-left">
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
    

    @if($jenis_data == 'FK')
    <div class="card" style="padding: 2px;">
        <div class="card-header">
            EXPORT PAJAK FK
        </div>
        <div class="card-body p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">

                        FK;KD_JENIS_TRANSAKSI;FG_PENGGANTI;NOMOR_FAKTUR;MASA_PAJAK;TAHUN_PAJAK;TANGGAL_FAKTUR;NPWP;NAMA;ALAMAT_LENGKAP;JUMLAH_DPP;JUMLAH_PPN;JUMLAH_PPNBM;ID_KETERANGAN_TAMBAHAN;FG_UANG_MUKA;UANG_MUKA_DPP;UANG_MUKA_PPN;UANG_MUKA_PPNBM;REFERENSI;KODE_DOKUMEN_PENDUKUNG

                            <th class="text-center">FK</th>
                            <th class="text-center">KD_JENIS_TRANSAKSI</th>
                            <th class="text-center">FG_PENGGANTI</th>
                            <th class="text-center">NOMOR_FAKTUR</th>
                            <th class="text-center">MASA_PAJAK</th>
                            <th class="text-center">TAHUN_PAJAK</th>
                            <th class="text-center">TANGGAL_FAKTUR</th>
                            <th class="text-center">NPWP</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">ALAMAT_LENGKAP</th>
                            <th class="text-center">JUMLAH_DPP</th>
                            <th class="text-center">JUMLAH_PPN</th>
                            <th class="text-center">JUMLAH_PPNBM</th>
                            <th class="text-center">ID_KETERANGAN_TAMBAHAN</th>
                            <th class="text-center">FG_UANG_MUKA</th>
                            <th class="text-center">UANG_MUKA_DPP</th>
                            <th class="text-center">UANG_MUKA_PPN</th>
                            <th class="text-center">UANG_MUKA_PPNBM</th>
                            <th class="text-center">REFERENSI</th>
                            <th class="text-center">KODE_DOKUMEN_PENDUKUNG</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice as $p)
                        <tr>
                            <td class="text-left">FK</td>
                            <td class="text-right">1</td>
                            <td class="text-right">0</td>
                            <td class="text-left">0{{ $no_faktur_pajak++ }}</td>
                            <td class="text-right">12</td>
                            <td class="text-right">{{ Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                            <td class="text-right">{{ Carbon\Carbon::parse($p->created_at)->year }}</td>
                            <td class="text-right">
                                @if($p->outlet->no_npwp == 000000000000000 )
                                
                                0

                                @else

                                {{ $p->outlet->no_npwp }}

                                @endif
                            </td>
                            <td class="text-left">{{ $p->outlet->nik }}#NIK#NAMA#{{ $p->outlet->nm_outlet }}</td>
                            <td class="text-left">{{ $p->outlet->almt_outlet }}</td>
                            <td class="text-right">{{ number_format( (($p->details_invoice->sum('nominal_total')/1.11 )), 0, ',', '') }}</td>
                            <td class="text-right">{{ number_format( (($p->details_invoice->sum('nominal_total')/1.11 *0.11)), 0, ',', '') }}</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-left">{{ $p->noinv }}</td>
                            <td class="text-right">0</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @else

    <div class="card" style="padding: 2px;">
        <div class="card-header">
        EXPORT PAJAK OF
        </div>
        <div class="card-body p-2">
            <div class="col-lg-12">  
                <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                    <thead>
                        <tr style="background-color: #6082B6; color:white">
                            <th class="text-center">OF</th>
                            <th class="text-center">KODE_OBJEK</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">HARGA_SATUAN</th>
                            <th class="text-center">JUMLAH_BARANG</th>
                            <th class="text-center">HARGA_TOTAL</th>
                            <th class="text-center">DISKON</th>
                            <th class="text-center">DPP</th>
                            <th class="text-center">PPN</th>
                            <th class="text-center">TARIF_PPNBM</th>
                            <th class="text-center">PPNBM</th>
                            <th class="text-center">Reff</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $p)
                        <tr>
                            <td class="text-left">OF</td>
                            <td class="text-left">{{ $p->part_no }}</td>
                            <td class="text-left">{{ $p->nama_part->part_nama }}</td>
                            <td class="text-left">{{ $p->hrg_pcs }}</td>
                            <td class="text-left">{{ $p->qty }}</td>
                            <td class="text-right">{{ number_format((($p->qty * $p->hrg_pcs)/1.11), 0, ',', '') }}</td>
                            <td class="text-right">{{ number_format((($p->qty * $p->hrg_pcs * $p->disc)/100 /1.11), 0, ',', '') }}</td>
                            <td class="text-right">{{ number_format(($p->nominal_total)/1.11, 0, ',', '') }}</td>  
                            <td class="text-right">{{ number_format(($p->nominal_total)/1.11 *0.11, 0, ',', '') }}</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-left">{{ $p->noinv }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection

@section('script')


@endsection