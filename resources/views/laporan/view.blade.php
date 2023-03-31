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