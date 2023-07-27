<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table,
    td,
    th {
        border: 1px solid;
    }
</style>
@php
    $no=1;
@endphp
<h3>Laporan Bulan {{ date('F', strtotime($tahun.'-'.$bulan.'-01')) }} Tahun {{ $tahun }} Unit : {{ $unit }}</h3>
<table>
    <tr>
        <th>{{ $unit }}</th>
        <th>Rp. {{ number_format($total, 2, ',', '.') }}</th>
    </tr>
</table>
<hr>
<table>
    <tr>
        <th>Pasien</th>
        <th>Tgl</th>
        <th>Nama Tarif </th>
        <th>Dokter</th>
        <th>Tarif </th>
        <th>Jumlah </th>
        <th>Total </th>
    </tr>
    @foreach ($data_transaksi as $dt)
        <tr>
            <td>{{ $dt->nama_pasien }} - {{ $dt->no_rm }}</td>
            <td align=center>{{ date('Y/m/d', strtotime($dt->tgl_keluar)) }}</td>
            <td>{{ $dt->nama_tarif }} </td>
            <td>({{$dt->nama_dokter}}) </td>
            <td align=right>Rp. {{ number_format($dt->nominal, 2, ',', '.') }}</td>
            <td align=center>{{ $dt->sekali == 1 ? '@1' : '@' . $dt->jumlah }}</td>
            <td align=right>Rp.
                {{ $dt->sekali == 1 ? number_format($dt->nominal * 1, 2, ',', '.') : number_format($dt->nominal * $dt->jumlah, 2, ',', '.') }}
            </td>
        </tr>
    @endforeach
    {{-- @if ($id_unit == 9)
        <tr>
            <th colspan=6 align=right>Potongan UGD</th>
            <th align=right> <a style='color:red;'>- Rp. {{ number_format(15000*count($data_transaksi), 2, ',', '.') }}</a> </th>
        </tr>
    @endif --}}
    <tr>
        <th colspan=6 align=right>Grand Total</th>
        <th align=right>Rp. {{ number_format($total, 2, ',', '.') }}</th>
    </tr>
</table>
@if($id_unit == 1)
<hr>
<table>
    <tr>
        <th>No</th>
        <th>Nama Dokter</th>
        <th>Tindakan</th>
        <th>Total</th>
    </tr>
    @foreach($dokter as $dr)
    
    @php
    $totalnya = 0;
    $detail_dokter = DB::table('tarif_detail')->leftJoin('transaksi_detail','tarif_detail.id_tarif','=','transaksi_detail.id_tarif')->join('transaksi','transaksi_detail.id_transaksi','=','transaksi.id')->whereMonth('transaksi_detail.tgl_transaksi', '=', $bulan)->whereYear('transaksi_detail.tgl_transaksi', '=', $tahun)->where('transaksi_detail.bayar', 1)->where('tarif_detail.id_unit',1)->where('transaksi_detail.id_dokter',$dr->id_dokter)->get();
    
    @endphp
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{$dr->dokter}}</td>
        <td>
            <ol>
                @foreach ($detail_dokter as $dd)
                @php
                    $totalnya += $dt->nominal;
                @endphp
                    <li>{{ $dd->nama_tarif }} - Rp. {{ number_format($dt->nominal, 2, ',', '.') }}</li>
                @endforeach
            </ol>
        </td>
        <td>
            Rp. {{ number_format($totalnya, 2, ',', '.') }}
        </td>
    </tr>
        
          
    @endforeach
</table>
@endif