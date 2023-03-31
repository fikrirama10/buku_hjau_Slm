<style>
    @page {
        margin: 0px;
    }

    body {
        margin: 0px;
    }

    .utama {
        width: 100%;
        height: 97%;
    }

    .left {
        width: 10%;
        margin: 10px 0px 10px 10px;
        height: 260px;
        float: left;
        border: 1px solid #5656e6;
        position: relative;
    }
    .right {
        width: 85%;
        margin: 10px 0px 10px 10px;
        height: 260px;
        border: 1px solid #5656e6;
        float: left;
        position: relative;
        color: #5656e6 ;
    }

    .left h3{
        display:inline-block;
        -webkit-transform:rotate(-90deg);
        text-align:center;
        color: #5656e6 ;
        font-family: 'Gill Sans', 'Gill Sans MT','Trebuchet MS', sans-serif;
        -webkit-transform-origin:90px 60px;
   }
   #watermark {
        position: fixed;
        opacity: 0.1;
              
        left: 450px;

        /** Change image dimensions**/
        width: 10cm;
        height: 10cm;

        /** Your watermark should be behind every content**/
        z-index: -1000;
    }

    .top{
        width:95%;
        min-height: 10px;
        border-bottom:1px solid;
        padding:10px 10px 10px 10px;
    }
</style>
<div id="watermark">
    <img src="{{ asset('storage/BIRUPUTIH.png') }}" height="100%" width="100%" />
</div>
<div class="left">
    <h3>KWITANSI</h3>
</div>
<div class="right">
    <div class="top">
        No. Kwitansi : <b>{{ $transaksi->id_transaksi }}-{{ $dp->id }}</b>      
    </div>
    <div class="top">
        <table>
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
    </div>
    <div class="top"></div>
    <div style="width:40%; margin: 28px 0px 10px 10px; float:left;">
        <div style="width:100%; padding: 10px 0px 10px 10px; background:#5656e6; font-weight:bold; color:#fff;">Rp. {{ number_format($dp->nominal,2,',','.') }}</div>
    </div>
    <div style="width:40%; margin: 10px 0px 10px 10px; float:right; text-align:center;">Tanda Tangan</div>
</div>
