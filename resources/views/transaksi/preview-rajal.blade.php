<html>

<head>
    <style>
        body {
            font-family: arial;
            font-size: 14px;
        }

        .header {
            width: 100%;
            min-height: 120px;
            overflow: hidden;
            border-bottom: 1px solid;
            padding-bottom: 5px;
            text-transform: ;
        }

        .header-logo {

            width: 11%;
            float: left;
            padding-right: 10px;
        }

        .header-logo img {
            width: 50%;
        }

        .header-kop {
            width: 50%;
            float: left;
            text-align: left;
            font-size: 10px;
        }

        .header-kop2 {
            width: 35%;
            float: left;
            text-align: right;
            font-size: 10px;
        }

        .header2 {
            width: 100%;
            text-align: center;
            padding-top: 10px;
            font-size: 10px;
        }

        .bodykop {
            width: 100%;
            text-align: center;
            text-transform: uppercase;
        }

        .datapasien {
            margin-top: 12px;
            min-height: 120px;
            overflow: hidden;
            width: 100%;
            float: left;
            font-size: 12px;
        }

        .tandatangan {
            margin-top: 20px;
            width: 40%;
            float: right;
            text-align: center;
        }

        .olab {
            width: 100%;
            float: left;
            position: absolute;
        }

        .olab th {
            text-align: center;
            font-size: 10px;
            height: 20px;
            line-height: 10px;
        }

        .olab td {
            font-size: 10px;
            text-indent: 10px;
            padding: 2px;
        }

        .olab table {
            width: 100%;
            border-bottom: 1px solid;
            border-collapse: collapse;
        }

        #re {
            background: red;
            width: 100%;
            float: left;
            height: 100px;
            position: absolute;

        }
    </style>
</head>

<body>
    <h5>RSAU LANUD SULAIMAN</h5>
    <div style='margin-bottom:10px;'>
        <table style='font-size:10px; width:100%;'>
            <tr>
                <td>Nama Pasien</td>
                <td>:</td>
                <td>{{ $transaksi->nama_pasien }}</td>

                <td>No Faktur</td>
                <td>:</td>
                <td>{{ $transaksi->id_transaksi }}</td>
            </tr>
            <tr>
                <td>No RM</td>
                <td>:</td>
                <td>{{ $transaksi->no_rm }}</td>

                <td>Tgl Masuk</td>
                <td>:</td>
                <td>{{ $transaksi->tgl_masuk }}</td>
            </tr>
            <tr>
                <td>Poli / Ruangan</td>
                <td>:</td>
                <td>{{ $transaksi->poli_ruangan }}</td>

                <td>Tgl Keluar</td>
                <td>:</td>
                <td>{{ date('Y-m-d',strtotime($transaksi->tgl_keluar )) }}</td>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <td>{{ $transaksi->nama_dokter }}</td>
            </tr>


        </table>
    </div>
    <b>{{ $title }}</b>
    <hr>
    <div class='olab'>
        <table>
            <tr>
                <td style='border-top:1px solid; font-size:9px;background:#ececec; border-bottom:1px solid; text-transform:uppercase;'
                    colspan=4><b>Deskripsi</b></td>
                <td align=right
                    style='background:#ececec; border-bottom:1px solid; border-top:1px solid; font-size:9px; text-transform:uppercase;'
                    colspan=2><b>TOTAL</b></td>
            </tr>
            @foreach ($transaksi_detail as $item)
                <tr>
                    <td colspan=2 style='font-size:12px;'>{{ $item->nama_tarif }}</td>
                    <td width=50>({{ $item->jumlah }})</td>
                    <td>:</td>
                    <td align=right colspan=2 style='font-size:12px;'>Rp.
                        {{ number_format($item->harga_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan=2 style='font-size:12px;'></td>
                <td width=50></td>
                <td> </td>
                <td align=right colspan=2 style='font-size:12px;'></td>
            </tr>
            <tr>
                <td style='border-top:1px solid;  text-transform:uppercase;' colspan=4>
                    Total Tagihan</td>
                <td align=right
                    style='border-top:1px solid; text-transform:uppercase; font-size:12px;'
                    colspan=2>Rp. {{ number_format($transaksi_detail_total, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style='text-transform:uppercase;' colspan=4>
                    Total DP</td>
                <td align=right
                    style=' text-transform:uppercase; font-size:12px;'
                    colspan=2>Rp. {{ number_format($transaksi_dp, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style=' border-bottom:1px solid; text-transform:uppercase;' colspan=4>
                   Total Diskon</td>
                <td align=right
                    style='border-bottom:1px solid;   text-transform:uppercase; font-size:12px;'
                    colspan=2>Rp. {{ number_format($transaksi->diskon, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style='border-top:1px solid;  font-weight:bold;  text-transform:uppercase;' colspan=4>
                    Total Tagihan Pasien</td>
                <td align=right
                    style='border-top:1px solid;  font-weight:bold;  text-transform:uppercase; font-size:12px;'
                    colspan=2>Rp. {{ number_format($transaksi_detail_total - $transaksi->diskon - $transaksi_dp, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style=' border-bottom:1px solid;  font-weight:bold;  text-transform:uppercase;' colspan=4>
                   Total Sudah Dibayar Pasien</td>
                <td align=right
                    style='border-bottom:1px solid;  font-weight:bold;   text-transform:uppercase; font-size:12px;'
                    colspan=2>Rp. {{ number_format($transaksi_dp, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style=' border-bottom:1px solid;  font-weight:bold;  text-transform:uppercase;' colspan=4>
                   Total Yang Harus Dibayar Pasien</td>
                <td align=right
                    style='border-bottom:1px solid;  font-weight:bold;   text-transform:uppercase; font-size:12px;'
                    colspan=2>Rp. {{ number_format($transaksi_detail_total-$transaksi_dp, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    <footer>
        <div style='text-align:right; margin-bottom:30px;'>Yang Menyerahkan</div>
       <div style='color:darkgrey; font-size:12px;'>Printed : {{ date('Y-m-d H:i:s') }}</div>
       <div style='color:darkgrey; font-size:12px;'>Kasir : {{ $transaksi->nama_user }}</div>
    </footer>
</body>

</html>
