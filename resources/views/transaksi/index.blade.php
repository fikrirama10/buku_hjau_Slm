@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title col-md-8">Data Transaksi</h5>

            <a href='{{ route('tambah.transaksi') }}' class='btn btn-success text-white'><i
                    class="menu-icon tf-icons ti ti-playlist-add"></i> Tambah Data</a>
            <a href='{{ route('tambah.transaksi') }}' class='btn btn-warning text-white'><i
                    class="menu-icon tf-icons ti ti-playlist-add"></i> Tambah Manual</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbl_list" class="table table-striped " cellspacing="0" width="100%">
                    <thead class='text-nowrap fs-8'>
                        <tr>
                            <th>No</th>                            
                            <th>Tgl Transaksi</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Rawat</th>
                            <th>Ruangan / Poli</th>
                            <th>Nama Dokter</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class='text-nowrap fs-8'>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                fixedColumns: {
                    left: 0,
                    right: 3
                },
                'columnDefs': [{
                        "targets": 0,
                        "className": "text-center"
                    },
             
                ],
                columns: [
                    {
                        data: 'id',
                        render: function(data, type, row, meta, no) {
                            no = meta.row + meta.settings._iDisplayStart + 1;
                            return no;
                        }
                    },
                    // {data:'id_transaksi', name:'id_transaksi'},                      
                    {data:'tgl_transaksi', name:'tgl_transaksi'},
                    {data:'no_rm', name:'no_rm'},                  
                    {data:'nama_pasien', name:'nama_pasien'},
                    {data:'jenis_rawat', name:'jenis_rawat'},
                    {data:'poli_ruangan', name:'poli_ruangan'},
                    {data:'nama_dokter', name:'nama_dokter'},
                    {data:'total_transaksi', name:'total_transaksi'},
                    {data:'status', name:'transaksi_status.status'},
                    {data:'action', name:'action'},               

                ]
            });
    </script>
@endpush
