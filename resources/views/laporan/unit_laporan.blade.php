<style>
    table {
        border-collapse: collapse;
        width:100%;
    }

    table,
    td,
    th {
        border: 1px solid;
    }
</style>
<h3>Laporan Bulan {{ date('F',strtotime($bulan)) }} Tahun {{ $tahun }} Unit : {{ $unit }}</h3>
<table>
    <tr>
        <th>{{ $unit }}</th>
        <th>Rp. {{ number_format($total , 2,',','.') }}</th>
    </tr>
</table>
<hr>
<table>
    <tr>
        <th>Pasien</th>
        <th>Tgl</th>
        <th>Nama Tarif </th>
        <th>Tarif </th>
        <th>Jumlah </th>
        <th>Total </th>
    </tr>
    @foreach ($data_transaksi as $dt)
        <tr>
            <td>{{ $dt->nama_pasien }} - {{ $dt->no_rm }}</td>
            <td align=center>{{ date('Y/m/d',strtotime($dt->tgl_keluar)) }}</td>
            <td>{{ $dt->nama_tarif }}</td>
            <td align=right>Rp. {{ number_format($dt->nominal , 2,',','.') }}</td>
            <td align=center>{{ $dt->sekali == 1 ? '@1':'@'.$dt->jumlah }}</td>
            <td align=right>Rp. {{ $dt->sekali == 1 ?  number_format($dt->nominal*1 , 2,',','.'): number_format($dt->nominal*$dt->jumlah , 2,',','.') }}</td>
        </tr>
    @endforeach
    <tr>
        <th colspan=5 align=right>Grand Total</th>
        <th align=right>Rp. {{ number_format($total , 2,',','.') }}</th>
    </tr>
</table>