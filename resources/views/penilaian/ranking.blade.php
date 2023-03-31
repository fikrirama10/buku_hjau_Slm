<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class='border'>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kriteria</th>
                        @foreach ($bulan as $b)
                            <th class='text-center'>{{ $b['bulan'] }}</th>
                        @endforeach
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class='text-nowrap fs-2x'>
                    <tr>
                        <td rowspan="{{ count($kriteria_all) + 1 }}">1</td>
                        <td rowspan="{{ count($kriteria_all) + 1 }}">{{ $data->name }}</td>
                    </tr>
                    @php
                        $total = 0;
                        $total_persen = 0;
                    @endphp
                    @foreach ($kriteria_all as $kl)
                        @php
                            $nilai_persen = Penilaian::get_total($data->id, $kl->id, $tahun) / 12;
                            $total += Penilaian::get_total($data->id, $kl->id, $tahun);
                            $total_persen += Penilaian::get_nilai_akhir($nilai_persen, $kl->id);
                        @endphp
                        <tr>
                            <td>{{ $kl->kriteria }}</td>
                            @foreach ($bulan as $b)
                                <td class='text-center'>
                                    {{ Penilaian::get_nilai($data->id, $kl->id, $b['id'], $tahun) }} %</td>
                            @endforeach                           
                            <td>{{ Penilaian::get_total($data->id, $kl->id, $tahun) }}</td>
                            <td>{{ round(Penilaian::get_total($data->id, $kl->id, $tahun) / 12, 2) }} %</td>
                        </tr>
                    @endforeach
                    <tr class='fw-bold'>
                        <td colspan=3>Total</td>
                        @foreach ($bulan as $b)
                            {{-- <td class='text-center'>{{ Penilaian::get_total_all($data->id, $b['id'], $tahun) }} %
                            </td> --}}
                            <td></td>
                        @endforeach
                        {{-- <td>{{ $total }}</td> --}}
                        <td></td>
                        <td>{{ round($total_persen, 2) }} %</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>