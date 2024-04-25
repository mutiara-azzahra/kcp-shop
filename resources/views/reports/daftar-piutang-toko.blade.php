<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Piutang Toko</title>
    <style>
    h4,h2{
        font-family: 'Times New Roman', Times;
    }
        body{
            font-family:'Times New Roman', Times;
        }
        table{
        border-collapse: collapse;
        width:100%;
      }
      table, th, td{
        border: 1px solid black;
      }
      th{
        text-align: center;
      }
      .atas{
          text-align: left;
          border: none;
      }
      .atas-total{
          text-align: right;
          border: none;
      }
      .ttd-table{
          border: none;
          text-align: left;
      }
      .nama-kcp{
          text-align: left;
          border: none;
          font-size: 14px;
      }
      .alamat-kcp{
          text-align: left;
          border: none;
          font-size: 12px;
      }
      .rekening{
          text-align: left;
          border: none;
          font-size: 14px;
      }
      .nops{
          padding-top:10px;
          text-align: left;
          border: none;
      }
      .table-part{
          border: none;
      }
      td{
        text-align: center;
      }
      .td-part{
        text-align: left;
        border: none;
      }
      .td-qty{
        text-align: center;
        border: none;
      }
      .td-angka{
        text-align: right;
        border: none;
      }
      .th-header{
        text-align: center;
        border-top: 1px solid #000; /* Add a top border with a black color */
        border-bottom: 1px solid #000; /* Add a bottom border with a black color */
        border-left: none; /* Remove the left border */
        border-right: none;
      }
      br{
          margin-bottom: 2px !important;
      }
      .table-bawah{
        border-left: none; /* Remove left border */
        border-right: none;
        line-height: 14px;
      }
     .judul{
         text-align: center;
     }
     .header{
         margin-bottom: 0;
         text-align: center;
         height: 105px;
         padding: 0px;
     }
     hr{
         height: 3px;
         background-color: black;
         width:100%;
     }
     .ttd{
        text-align: center;
     }
     .text-right{
         text-align:right;
     }
     .isi{
         padding:0px;
     }

    </style>
</head>
<body>
    <style>
        @page { 
          size: 21 cm 14.8 cm; 
          margin-top: 10px;
          margin-left: 5px;
          margin-right: 5px;
          padding: 0px !important;
          } 
    </style>
    <div class="header">
        <table class="table atas" style="line-height: 12px;">
            <tr>
                <td class="atas" style="width: 350px;">
                    <table class="atas" style="line-height: 13px;">
                        <tr>
                            <td class="atas"><b>PT. KCP</b></td>
                        </tr>
                        <tr>
                            <td class="atas"><i>Jl. Sutoyo S. No. 144 Banjarmasin, Hp. 0811 517 1595, 0812 5156 2768</i></td>
                        </tr>
                    </table>
                </td>
                <td class="atas">
                </td>
            </tr>

            <tr>
                <td class="atas" style="width: 350px;">
                    <table class="atas" style="line-height: 13px;">
                        <tr>
                            <td class="atas" style="margin:0px; text-decoration:underline;"><b><i>Daftar Piutang Toko</i></b></td>
                        </tr>
                        <tr>
                            <td class="atas"><b>Tanggal :</b></td>
                        </tr>
                    </table>
                </td>
                <td class="atas" style="width: 350px;">
                    <table class="atas" style="line-height: 13px;">
                        
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="isi">
            <table class="table table-bawah">
                <thead>
                    <tr>
                        <th class="th-header">NO</th>
                        <th class="th-header">TANGGAL</th>
                        <th class="th-header">NO FAKTUR</th>
                        <th class="th-header">JATUH TEMPO</th>
                        <th class="th-header">TOTAL</th>
                        <th class="th-header">RETUR</th>
                        <th class="th-header">TELAH BAYAR</th>
                        <th class="th-header">TANGGAL BAYAR</th>
                        <th class="th-header">SISA</th>
                    </tr>
                </thead>
    
                <tbody>

                    @php $counter = 1; @endphp

                    @foreach ($data as $p => $month)

                        @php

                        $sisa_batas = $month->flatMap->details_invoice->sum('nominal_total') - $month->flatMap->piutang_details->sum('nominal');

                        @endphp
                        
                        @foreach ($month as $i)
                        <tr>
                            @php
                            $nominal_invoice    = $i->details_invoice->sum('nominal_total');
                            $piutang_terbayar   = $i->piutang_details->sum('nominal');
                            $sisa               = $nominal_invoice - $piutang_terbayar;

                            $tanggal_bayar = '';

                            if(isset($i->piutang_details) && $firstPiutangDetail = $i->piutang_details->first()) {
                                $tanggal_bayar = Carbon\Carbon::parse($firstPiutangDetail->created_at)->format('d-m-Y');
                            } else {
                                $tanggal_bayar = '-';
                            }

                            @endphp

                            <td class="td-qty">{{ $counter }}.</td>
                            <td class="td-angka">{{ Carbon\Carbon::parse($i->created_at)->format('d-m-Y') }}</td>
                            <td class="td-angka">{{ $i->noinv }}</td>
                            <td class="td-angka">{{ Carbon\Carbon::parse($i->tgl_jatuh_tempo)->format('d-m-Y') }}</td>
                            <td class="td-angka">{{ number_format($nominal_invoice, 0, ',', '.') }}</td>
                            <td class="td-angka"> - </td>
                            <td class="td-angka">{{ number_format($piutang_terbayar, 0, ',', '.') }}</td>
                            <td class="td-qty">{{ $tanggal_bayar }}</td>
                            <td class="td-angka">{{ number_format($sisa, 0, ',', '.') }}</td>
                        </tr>

                        @php $counter++; @endphp

                        @endforeach
                        <tr>
                            <td class="td-qty">{{ $counter++ }}.</td>
                            <td class="td-angka" colspan="7"><b>{{ $p }}</b></td>
                            <td class="td-angka"><b>Rp. {{ number_format($sisa_batas, 0, ',', '.') }}</b></td>
                        </tr>
                    @endforeach
            </tbody>

            </table>
          
            <table class="atas" style="line-height: 15px;">
                <tr>
                    <td class="atas-total"><b>Harap dibayar pada tangal:</b></td>
                </tr>
            </table>

            <br>

            <table style="border: none">
                <td class="td-angka">
                    <table class="atas" style="padding-bottom: 10px">
                        <tr>
                            <td class="rekening" style="margin:0px;"><b>Catatan :</b></td>
                        </tr>
                        <tr>
                            <td class="rekening" style="margin:0px;"><b>- Untuk nota asli menyusul setelah pembayaran lunas</b></td>
                        </tr>
                        <br>
                        <tr>
                            <td class="rekening" style="margin:0px; text-decoration:underline;"><b>Harap melakukan Transfer ke Rekening :</b></td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr>
                            <td class="rekening"><b>BANK MANDIRI</b></td>
                            <td class="rekening"><b>:</b></td>
                            <td class="rekening"><b>031-0004265081</b></td>
                        </tr>
                        <tr>
                            <td class="rekening"><b>BANK BCA</b></td>
                            <td class="rekening"><b>:</b></td>
                            <td class="rekening"><b>051-0583698</b></td>
                        </tr>
                        <tr>
                            <td class="rekening"><b>BANK BNI</b></td>
                            <td class="rekening"><b>:</b></td>
                            <td class="rekening"><b>0065946746</b></td>
                        </tr>
                        <tr>
                            <td class="rekening"><b>BANK BRI</b></td>
                            <td class="rekening"><b>:</b></td>
                            <td class="rekening"><b>0003010021753004</b></td>
                        </tr>
                        <tr>
                            <td class="rekening"><b>BANK DANAMON</b></td>
                            <td class="rekening"><b>:</b></td>
                            <td class="rekening"><b>007700173805</b></td>
                        </tr>
                    </table>
                </td>

                <td class="td-angka">
                    <table class="td-angka" style="width:100%">
                        <tr>
                            <td class="atas">
                                <div class="ttd">
                                    <h5 style="margin:0px">Diterima Oleh,</h5>
                                    <br><br>
                                    <h5 style="text-decoration:underline;">TTD, Nama & Stempel Toko,</h5>
                                </div>
                            </td>
                            <td class="atas">
                                <div class="ttd">
                                    <h5 style="margin:0px">Dibuat Oleh,</h5>
                                    <br><br>
                                    <h5>______________________</h5>
                                </div>
                            </td>
                            <td class="atas">
                                <div class="ttd">
                                    <h5 style="margin:0px">Diketahui Oleh,</h5>
                                    <br><br>
                                    <h5>_____________________</h5>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </table>
        </div>
    </div>
</body>
</html>