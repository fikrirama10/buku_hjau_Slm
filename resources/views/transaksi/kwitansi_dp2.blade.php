<style>
     @page {
        margin: 10px;
    }

    body {
        margin: 0px;
        color: blue;
    }
    #watermark {
        position: fixed;
        opacity: 0.1;
        top:30px; 
        left: 100px;

        /** Change image dimensions**/
        width: 10cm;
        height: 10cm;

        /** Your watermark should be behind every content**/
        z-index: -1000;
    }
</style>
<div id="watermark">
    <img src="{{ asset('storage/BIRUPUTIH.png') }}" height="50%" width="50%" />
</div>
<center>
    <h3>Kwitansi</h3>
    <hr>
</center>
<table style='font-size:12px;'>
    <tr>
        <td>Telah Terima Dari</td>
        <td>:</td>
        <td><b>{{ $transaksi->nama_penanggung }}</b></td>
    </tr>
    <tr>
        <td>Uang Sejumlah</td>
        <td>:</td>
        <td style='border-bottom:1px solid;'><b><i>{{ Penilaian::penyebut($dp->nominal) }} Rupiah</i></b></td>
    </tr>
    <tr>
        <td>Untuk Pembayaran</td>
        <td>:</td>
        <td><b>{{ $dp->nama_dp }}</b></td>
    </tr>
</table>

<div style="width:40%; margin: 28px 0px 10px 10px; float:left;">
    <div style="width:100%; padding: 10px 0px 10px 10px; background:#5656e6; font-weight:bold; color:#fff;">Rp. {{ number_format($dp->nominal,2,',','.') }}</div>
</div>
<div style="width:40%; margin: 10px 0px 10px 10px; float:right; text-align:center;">Tanda Tangan</div>