@extends('main')

@section('content')
    <div class="card border">
        <div class="card-body">
            Detail {{ $data->name }}
        </div>
    </div>
    <br>
    <div class="card border">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class='form-label' for="">Tahun</label>
                    <div class="input-group mb-3">
                        <select name="tahun" id='tahun_ranking' class='form-select' id="">
                            <option value="">Tahun</option>
                            <option {{ date('Y') == 2022 ? 'selected' : '' }} value="2022">2022</option>
                            <option {{ date('Y') == 2023 ? 'selected' : '' }} value="2023">2023</option>
                            <option {{ date('Y') == 2024 ? 'selected' : '' }} value="2024">2024</option>
                        </select>
                        <button class="btn btn-outline-success" type="button" id="button_ranking">Ranking</button>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            <br>
            <div id="ranking_hasil">
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
                                        <tr>
                                            <td>{{ $kl->kriteria }}</td>
                                            @foreach ($bulan as $b)
                                                <td class='text-center'>
                                                    {{ Penilaian::get_nilai($data->id, $kl->id, $b['id'], $tahun) }} %</td>
                                            @endforeach
                                            @php
                                                $nilai_persen = Penilaian::get_total($data->id, $kl->id, $tahun) / 12;
                                                $total += Penilaian::get_total($data->id, $kl->id, $tahun);
                                                $total_persen += Penilaian::get_nilai_akhir($nilai_persen, $kl->id);
                                            @endphp
                                            <td>{{ Penilaian::get_total($data->id, $kl->id, $tahun) }}</td>
                                            <td>{{ round(Penilaian::get_total($data->id, $kl->id, $tahun) / 12, 2) }} %
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class='fw-bold'>
                                        <td colspan=3>Total</td>
                                        @foreach ($bulan as $b)
                                            <td class='text-center'>
                                            </td>
                                        @endforeach
                                        <td></td>
                                        <td>{{ round($total_persen, 2) }} %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card border">
        <div class="card-header border-bottom d-flex justify-content-between pb-1">
            <h5 class="mb-2 card-title">Penilaian</h5>
        </div>
        <div class="card-body">
            <br>
            <form action="{{ route('post-nilai', $data->id) }}" method="post">
                @csrf
                <input type="hidden" name='id_user' value='{{ $data->id }}'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <label class='form-label' for="">Tahun</label>
                                <select name="tahun" required id='tahun' class='form-select' id="">
                                    <option value="">Tahun</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class='form-label' for="">Bulan</label>
                                <select required name="bulan" id='bulan' class='form-select' id="">
                                    <option value="">Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class='form-label' for="">Presensi <i>(max 27)</i></label>
                                <input type="number" required name='presensi' id='presesnsi' min='1' max='27'
                                    class='form-control'>
                            </div>
                            <div class="col-md-3">
                                <label class='form-label' for="">Poin</label>
                                <div class="input-group mb-3">
                                    <input type="number" required name='poin_absen' id='poin' readonly
                                        class='form-control disabled'>

                                    <span class="input-group-text">%</span>
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="button-addon2">Jumlah</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name='poin_angka' required id='poin_angka' readonly class=''>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class='border'>
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Bobot</th>
                                        <th>Sub Kriteria</th>
                                        <th>Poin</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class='border'>
                                    @foreach ($array_kriteria as $k)
                                        <tr>
                                            <td rowspan="{{ count($k['sub']) + 1 }}">{{ $k['kriteria'] }}</td>
                                            <td width=10 rowspan="{{ count($k['sub']) + 1 }}">{{ $k['bobot'] }} %</td>
                                        </tr>
                                        @foreach ($k['sub'] as $sub)
                                            <tr>
                                                <td>{{ $sub['sub_kriteria'] }}</td>
                                                <td width=10>{{ $sub['poin'] }}</td>
                                                <td width=10>
                                                    <div class="form-check form-check-primary mt-3">
                                                        <input class="form-check-input" name='poin[]' type="checkbox"
                                                            value="{{ $sub['id_sub_kriteria'] }}"
                                                            id="customCheckPrimary">
                                                        <label class="form-check-label" for="customCheckPrimary"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <button class='btn btn-success'>Save</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#button_ranking').click(function() {
            var tahun = $('#tahun_ranking').val();
            var id = {{ $data->id }};

            let url = '{{ route('ranking-pegawai', ['id' => ':post_id', 'tahun' => ':vote']) }}';
            url = url.replace(':post_id', id);
            url = url.replace(':vote', tahun);
            $.get(url).done(function(data) {
                $('#ranking_hasil').html(data);
            })
        })

        $('#presesnsi').click(function() {
            $('#presesnsi').val('');
            $('#poin').val('');
            $('#poin_angka').val('');
        })
        $('#button-addon2').click(function() {
            var presesnsi = $('#presesnsi').val();
            if (presesnsi == '') {
                Swal.fire({
                    type: 'warning',
                    title: 'Warning!',
                    text: 'Presensi belum di isi',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
                $('#presesnsi').val('');
                $('#poin').val('');
                $('#poin_angka').val('');
            } else if (presesnsi > 27) {
                Swal.fire({
                    type: 'warning',
                    title: 'Warning!',
                    text: 'Presensi melebihi 27',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
                $('#presesnsi').val('');
                $('#poin').val('');
                $('#poin_angka').val('');
            } else {
                var hasil = (presesnsi / 27) * 100;
                var poin = Math.floor(hasil);
                var total = Math.floor(0.3 * poin);
                $('#poin').val(total);
                $('#poin_angka').val(poin);
            }


        })
    </script>
@endpush
