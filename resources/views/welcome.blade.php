@extends('main')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                  <div class="badge p-2 bg-label-success mb-2 rounded">
                    <i class="ti ti-currency-dollar ti-md"></i>
                  </div>
                  <h4 class="card-title mb-1 pt-2">Total Transaksi Lunas</h4>
                  <small class="text-muted">Hari ini : {{ date('d/F/Y') }}</small>
                  <h5 class="mb-2 mt-1">Rp. {{ number_format($transaksi['transaksi_selesai_total'],2,',','.') }}</h5>
                  <div class="pt-1">
                    <span class="badge bg-label-secondary"></span>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                  <div class="badge p-2 bg-label-primary mb-2 rounded">
                    <i class="ti ti-currency-dollar ti-md"></i>
                  </div>
                  <h4 class="card-title mb-1 pt-2">Total DP Masuk</h4>
                  <small class="text-muted">Hari ini : {{ date('d/F/Y') }}</small>
                  <h5 class="mb-2 mt-1">Rp. {{ number_format($transaksi['transaksi_dp_total'],2,',','.') }}</h5>
                  <div class="pt-1">
                    <span class="badge bg-label-secondary"></span>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-1">
                    <h5 class="mb-0 card-title">Transaksi Lunas</h5>
                </div>
                <div class="card-body">
                    <table class='table table-border'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pasien</th>
                                <th>Jenis Pelayanan</th>
                                <th>Poli / Ruangan</th>
                                <th>Total Transaksi</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi['transaksi_selesai'] as $trx)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $trx->nama_pasien }} - {{ $trx->no_rm }}</td>
                                    <td>{{ $trx->jenis_rawat }}</td>
                                    <td>{{ $trx->poli_ruangan }}</td>
                                    <td>Rp. {{ number_format($trx->total_transaksi , 2 ,',','.') }}</td>
                                    <td>{{ $trx->nama_user }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-1">
                    <h5 class="mb-0 card-title">Transaksi DP</h5>
                </div>
                <div class="card-body">
                    <table class='table table-border'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pasien</th>
                                <th>Jenis Pelayanan</th>
                                <th>Nama DP</th>
                                <th>Nominal</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi['transaksi_dp'] as $dp)
                                <tr>
                                    <td>{{ $no2++ }}</td>
                                    <td>{{ $dp->nama_pasien }} - {{ $dp->no_rm }}</td>
                                    <td>{{ $dp->jenis_rawat }}</td>
                                    <td>{{ $dp->nama_dp }}</td>
                                    <td>Rp. {{ number_format($dp->nominal , 2 ,',','.') }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
@endsection