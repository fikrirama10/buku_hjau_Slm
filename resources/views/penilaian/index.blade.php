@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title">Data Kepegawaian</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbl_list" class="table table-striped " cellspacing="0" width="100%">
                    <thead class='text-nowrap'>
                        <tr>
                            <th>No</th>
                            <th>No Presesnsi</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Jabatan</th>
                            <th>Pertama Kerja</th>
                            <th>Pendidikan</th>
                            <th>Pengabdian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class='text-nowrap'>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
@endsection
@push('scripts')
    <script type="text/javascript">
        
        $(document).ready(function() {
            
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                fixedColumns: {
                    left: 0,
                    right: 1
                },
                'columnDefs': [{
                        "targets": 0,
                        "className": "text-center"
                    },
                    {
                        "targets": 1,
                        "className": "text-center"
                    },
                    {
                        "targets": 3,
                        "className": "text-center"
                    },
                    {
                        "targets": 4,
                        "className": "text-center"
                    },
                    {
                        "targets": 5,
                        "className": "text-center"
                    },
                    {
                        "targets": 6,
                        "className": "text-center"
                    },
                    {
                        "targets": 7,
                        "className": "text-center"
                    },
                ],
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta, no) {
                            no = meta.row + meta.settings._iDisplayStart + 1;
                            return no;
                        }
                    },
                    {
                        data: 'no_presensi',
                        name: 'no_presensi'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        render: function(data, type, row) {
                            if (data == 'l') {
                                return 'Laki - Laki';
                            } else {
                                return 'Perempuan';
                            }
                        }
                    },
                    {
                        data: 'jabatan',
                        name: 'tbl_jabatan.jabatan'
                    },
                    {
                        data: 'pertama_kerja',
                        name: 'pertama_kerja'
                    },
                    {
                        data: 'pendidikan',
                        name: 'pendidikan'
                    },
                    {
                        data: 'pengabdian',
                        name: 'pengabdian',
                        render: function(data, type, row) {
                            return data + ' Tahun';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            });
        });
    </script>
@endpush
