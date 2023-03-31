@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title">Data Tarif</h5>

            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class='btn btn-success text-white'><i
                    class="menu-icon tf-icons ti ti-playlist-add"></i> Tambah Tarif</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbl_list" class="table table-striped " cellspacing="0" width="100%">
                    <thead class='text-nowrap fs-8'>
                        <tr>
                            <th>No</th>
                            <th>Kode Tarif</th>
                            <th>Nama Tarif</th>
                            <th>Tarif</th>
                            <th>Kategori Tarif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class='text-nowrap fs-8'>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tarif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('post-tarif') }}" id='tambah_tarif' method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Nama Tarif</label>
                                <input type="text" class='form-control' name='nama_tarif'>
                            </div>
                            <div class="col-md-12">
                                <label for="">Kategori Tarif</label>
                                <select name="kategori_tarif" class='form-select' id="kategori_tarif">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $kt)
                                        <option value="{{ $kt->id }}">{{ $kt->kategori_tarif }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Harga Tarif</label>
                                <input type="text" class='form-control' name='harga_tarif'>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id='btn_simpan' class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        const form = document.querySelector('#tambah_tarif');
        var validatorPersonalData = FormValidation.formValidation(
            form, {
                fields: {
                    nama_tarif: {
                        validators: {
                            notEmpty: {
                                message: 'Nama tarif harus diisi'
                            },
                        }
                    },
                    harga_tarif: {
                        validators: {
                            notEmpty: {
                                message: 'Harga Tarif  harus diisi'
                            },

                        }
                    },
                    kategori_tarif: {
                        validators: {
                            notEmpty: {
                                message: 'Kategori harus dipilih'
                            },
                        }
                    },
                },
                plugins: {
                    autoFocus: new FormValidation.plugins.AutoFocus(),
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-3'
                    }),

                },
            });
        var confirmSave = document.querySelector('#btn_simpan');
        confirmSave.addEventListener('click', function(e) {
            e.preventDefault();
            if (validatorPersonalData) {
                validatorPersonalData.validate().then(function(status) {
                    if (status == 'Valid') {
                        Swal.fire({
                            title: '',
                            text: "Yakin menambah data ? ",
                            showCancelButton: false,
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: "Simpan",
                            customClass: {
                                confirmButton: 'btn btn-primary me-1',
                                cancelButton: 'btn btn-label-danger'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function() {
                                    form.submit();
                                }, 1000);
                            }
                        })
                    }
                });
            }

        });

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
            columns: [{
                    data: 'id',
                    render: function(data, type, row, meta, no) {
                        no = meta.row + meta.settings._iDisplayStart + 1;
                        return no;
                    }
                },
                // {data:'id_transaksi', name:'id_transaksi'},                      
                {
                    data: 'kode_tarif',
                    name: 'kode_tarif'
                },
                {
                    data: 'nama_tarif',
                    name: 'nama_tarif'
                },
                {
                    data: 'nominal_tarif',
                    name: 'nominal_tarif'
                },
                {
                    data: 'tarif_kategori',
                    name: 'tarif_kategori.kategori_tarif'
                },
                {
                    data: 'action',
                    name: 'action'
                },

            ]
        });
    </script>
@endpush
