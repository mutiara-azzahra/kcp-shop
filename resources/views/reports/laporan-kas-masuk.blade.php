<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laporan Kas Masuk</title>
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
      .atas-isi{
          text-align: left;
          width: 150px;
          border: none;
      }
      .atas-header{
          text-align: center;
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
        text-align: right;
        border-top: 0.5px solid #000; 
        border-bottom: 0.5px solid #000;
        border-left: none;
        border-right: none;
      }
      .td-qty{
        text-align: left;
        border-top: 0.5px solid #000; 
        border-bottom: 0.5px solid #000;
        border-left: none;
        border-right: none;
      }
      .td-angka{
        text-align: center;
        border-top: 0.5px solid #000; 
        border-bottom: 0.5px solid #000;
        border-left: none;
        border-right: none;
      }
      .th-header{
        text-align: center;
        border-top: 0.5px solid #000; 
        border-bottom: 0.5px solid #000;
        border-left: none;
        border-right: none;
      }
      br{
          margin-bottom: 2px !important;
      }
      .table-bawah{
        border-left: none;
        border-right: none;
        line-height: 14px;
      }
     .judul{
         text-align: center;
     }
     .header{
         margin-bottom: 0;
         text-align: center;
         height: 40px;
         padding: 0px;
     }
     .isi{
         margin-bottom: 0;
         text-align: center;
         height: 10px;
     }
     .judul{
         margin-bottom: 0;
         text-align: center;
         height: 60px;
     }
     hr{
         height: 3px;
         background-color: black;
         width:100%;
     }
     .text-right{
         text-align:right;
     }
     .ttd{
        text-align: center;
        text-transform: uppercase;
     }
     .ttd-biasa{
        text-align: center;
     }

    </style>
</head>
<body>
    <style>
        @page { 
          size: 21 cm 29.6 cm; 
          margin: 10px;
          padding: 0px !important;
          } 
    </style>
    <div class="header">
        <table class="table atas" style="line-height: 15px;">
            <tr>
                <td class="atas">PT. KCP</td>
            </tr>
        </table>
    </div>
    <div class="judul">
        <table class="atas" style="line-height: 15px;">
            <tr>
                <td class="atas-header"><h4 style="text-decoration:underline; text-transform: uppercase; margin:0px">Laporan Kas Masuk</h4></td>
            </tr>
        </table>
        <table class="atas">
            <tr>
                <td class="atas">Periode</td>
                <td class="atas">:</td>
                <td class="atas">{{ Carbon\Carbon::parse($tanggal_awal)->format('d-m-Y') }} s/d {{ Carbon\Carbon::parse($tanggal_akhir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="atas">Cetak Oleh</td>
                <td class="atas">:</td>
                <td class="atas">{{ Auth::user()->nama_user }}, {{ NOW() }}</td>
            </tr>
        </table>
    </div>

    <div class="isi">
        <table class="table table-bawah" style="line-height: 16px;">
            <thead>
                <tr>
                    <th class="th-header">Tanggal</th>
                    <th class="th-header">Kas Masuk</th>
                    <th class="th-header">Bukti Potong</th>
                    <th class="th-header">Terima Dari/Keterangan</th>
                    <th class="th-header">Pembayaran Via</th>
                    <th class="th-header">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getReport as $p)
                <tr>
                    <td class="td-qty">{{ Carbon\Carbon::parse($p->created_at)->format('d-m-Y') }}</td>
                    <td class="td-qty">{{$p->no_kas_masuk }}</td>
                    <td class="td-qty">{{$p->no_piutang}}</td>
                    <td class="td-qty">{{$p->terima_dari }} <b>{{$p->keterangan }}</b></td>
                    <td class="td-angka">{{$p->pembayaran_via }}</td>
                    <td class="td-part">{{ number_format($p->nominal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="td-angka"><b>TOTAL</b></td>
                    <td class="td-part">{{ number_format($getReport->sum('nominal'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    </body>
</html>