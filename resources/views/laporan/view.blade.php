<a target='_blank' href="{{ route('all-laporan',[$bulan,$tahun]) }}" class='btn btn-info'>Print Semua Laporan</a>
<br>
<hr>
<table class='table table-bordered'>
    <thead>
        <tr>
            <th>Unit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($unit as $u)
            <tr>
                <td>{{ $u->unit }}</td>
                <td><a target='_blank' href="{{ route('unit-laporan',[$bulan,$tahun,$u->id]) }}" class='btn btn-success'>Print</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- <h2>Dokter</h2>
<table class='table table-bordered'>
    <thead>
        <tr>
            <th>Dokter</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dokter as $dr)
            <tr>
                <td>{{ $dr->dokter }}</td>
                <td><a target='_blank' href="{{ route('laporan-dokter-ugd',[$bulan,$tahun,$dr->id_dokter]) }}" class='btn btn-success'>Print</a></td>
            </tr>
        @endforeach
    </tbody>
</table> -->