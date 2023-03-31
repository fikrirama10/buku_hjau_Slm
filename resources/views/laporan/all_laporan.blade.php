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
<center>
    <h1>Laporan</h1>
</center>
<table>
    <tr>
        <th>Unit</th>
        <th>Nominal</th>
    </tr>
    @php
        $total = 0;
    @endphp
    @foreach ($arrunit as $au)
        <tr>
            <td>{{ $au['unit'] }}</td>
            <td>Rp. {{$au['total'] == 0 ? '-':number_format($au['total'] , 2 ,',','.')  }}</td>
        </tr>
        @php
            $total += $au['total'];
        @endphp
    @endforeach
    <tr style='font-weight:bold;'>
        <td>Total</td>
        <td>Rp. {{ number_format($total , 2 ,',','.') }}</td>
    </tr>
</table>