<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sales Order</title>
    <style>
    h4,h2{
        font-family:'Times New Roman', Times;
    }
        body{
            font-family:'Times New Roman', Times;
            margin: 0;
            padding: 0;
        }
        table{
        border-collapse: collapse;
        width:100%;
      }
      table, th, td{
        border: 0.5px solid black;
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
          padding-top:5px;
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
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        border-left: none;
        border-right: none;

      }
      br{
          margin-bottom: 2px !important;
      }
      .table-bawah{
        border-left: none;
        border-right: none;
      }
     .judul{
         text-align: center;
     }
     .header{
         margin-bottom: 0;
         text-align: center;
         height: 95px;
         padding: 0px;
     }
     .ttd{
        text-align: center;
        text-transform: uppercase;
     }
     .text-right{
         text-align:right;
     }
     .kanan{
        float:right;
     }
     .isi{
         padding:0px;
     }
     .kotak {
        width: 20px;
        height: 14px;
        background-color: black;
        color: #fff;
        text-align: center;
        line-height: 14px;
        border: none;
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
        <table class="atas">
            <tr>
                <td class="atas" style="width: 350px;">
                    <table class="atas" style="line-height: 13px;">
                        <tr>
                            <td class="atas">PT. KCP</td>
                        </tr>
                        <tr>
                            <td class="alamat-kcp">Jl. Sutoyo S. No. 144 Banjarmasin</td>
                        </tr>
                        <tr>
                            <td class="alamat-kcp">Hp. 0811 517 1595, 0812 5156 2768</td>
                        </tr>
                        <tr>
                            <td class="alamat-kcp">Telp. 4417127</td>
                        </tr>
                    </table>
                </td>
                <td class="atas">
                    <table class="atas" style="line-height: 13px;">
                        <tr>
                            <td class="atas"><b>SALES ORDER</b></td>
                        </tr>
                        <tr>
                            <td class="atas"></td>
                        </tr>
                        <tr>
                            <td class="atas">{{ $header->outlet->nm_outlet }} ({{ $header->outlet->kd_outlet }})</td>
                        </tr>
                        <tr>
                            <td class="atas">{{ $header->outlet->almt_pengiriman }},
                                @if($header->outlet->kode_prp == 6300)
                                Kalimantan Selatan
                                @else
                                Kalimantan Tengah
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="line-height: 13px;">
                <td class="nops">
                    <table class="atas">
                        <tr>
                            <td class="atas">No. SO</td>
                            <td class="atas">:</td>
                            @if($header->outlet->kode_prp == 6200)
                            <td class="atas">KCP/NON/{{ $header->area_so }}/{{ $header->noso }}</td>

                            @else
                            <td class="atas">KCP/NON/{{ $header->area_so }}/{{ $header->noso }}</td>
                            @endif
                        </tr>
                    </table>
                </td>
                <td class="nops">
                    <table class="atas">
                        <tr>
                            <td class="atas">Tanggal SO</td>
                            <td class="atas">:</td>
                            <td class="atas">{{ $header->crea_date }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="isi">
            <table class="table table-bawah" style="line-height: 13px;">
                <thead>
                    <tr>
                        <th class="th-header">No.</th>
                        <th class="th-header">Part No</th>
                        <th class="th-header">Nama Barang</th>
                        <th class="th-header">Qty</th>
                        <th class="th-header">Check</th>
                    </tr>
                </thead>
                <tbody style="line-height: 15px;">
                    @foreach ($data_details as $p)
                    <tr>
                        <td class="td-qty" style="width: 6px;">{{$loop->iteration}}.</td>
                        <td class="td-part">{{$p->part_no}}</td>
                        <td class="td-part">{{$p->nama_part->part_nama}}</td>
                        <td class="td-angka">{{$p->qty}}</td>
                        <td class="td-qty"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="kanan col-6">
                <table class="atas">
                    <tr>
                        <td class="atas">
                            <div class="ttd">
                                <br>
                                <h6 style="text-decoration:underline; margin:0px; color:white">xxxx</h6>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="kanan col-6">
                <table class="atas">
                    <tr>
                        <td class="atas">
                            <div class="ttd">
                                <br>
                                <h6 style="text-decoration:underline; margin:0px">Approve by System</h6>
                            </div>
                        </td>
                    </tr>
                </table>
            </div> 
        </div>
    </body>
</html>