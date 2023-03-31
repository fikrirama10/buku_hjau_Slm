@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title">Data Kepegawaian</h5>

            <button class='btn btn-success' data-bs-toggle="modal" data-bs-target="#exLargeModal"><i
                    class="menu-icon tf-icons ti ti-playlist-add"></i> Tambah Data</button>
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

    <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('post-tambah') }}" id='form_tambah' method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">No Absen</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <select name="kode_absen" id="kode_absen" class='form-select'>
                                                    @foreach ($noabsen as $na)
                                                        <option value="{{ $na->id }}">{{ $na->kode_absen }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input name='no_absen' id='no_absen' class="form-control numeral-mask"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Nama</label>
                                    <div class="col-md-8">
                                        <input type="text" name="nama" id="nama" class='form-control'>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" id="email" class='form-control'>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Alamat</label>
                                    <div class="col-md-8">
                                        <textarea name="alamat" id="alamat" class='form-control' rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-md-8">
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="inlineRadio1" value="l">
                                            <label class="form-check-label" for="inlineRadio1">Laki laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="inlineRadio2" value="p" />
                                            <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Jabatan</label>
                                    <div class="col-md-8">
                                        <select name="jabatan" id="jabatan" class='form-select'>
                                            @foreach ($jabatan as $jb)
                                                <option value="{{ $jb->id }}">{{ $jb->jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Pertama Kerja</label>
                                    <div class="col-md-8">
                                        <input type="text" name='pertama_kerja' class="form-control"
                                            placeholder="Month DD, YYYY" id="flatpickr-human-friendly" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Pengabdian</label>
                                    <div class="col-md-8">
                                        <input type="text" name='pengabdian' class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Pendidikan</label>
                                    <div class="col-md-8">
                                        <input type="text" name='pendidikan' class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="html5-text-input" class="col-md-4 col-form-label">Foto</label>
                                    <div class="col-md-8">
                                        <input type="file" name="foto" accept=".jpg,.png" class='form-control'
                                            id="">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id='btn_simpan' class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        const form = document.querySelector('#form_tambah');
        var validatorPersonalData = FormValidation.formValidation(
            form, {
                fields: {
                    kode_absen: {
                        validators: {
                            notEmpty: {
                                message: 'Kode Absen harus dipilih'
                            },
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email harus diisi'
                            },
                            emailAddress: {
                                message: 'Format email salah',
                            },
                        }
                    },
                    no_absen: {
                        validators: {
                            notEmpty: {
                                message: 'No Absen harus dipilih'
                            },
                        }
                    },
                    nama: {
                        validators: {
                            notEmpty: {
                                message: 'Nama harus diisi'
                            },
                        }
                    },
                    alamat: {
                        validators: {
                            notEmpty: {
                                message: 'Alamat harus diisi'
                            },
                        }
                    },
                    jenis_kelamin: {
                        validators: {
                            notEmpty: {
                                message: 'Jenis kelamin harus dipilih'
                            },
                        }
                    },
                    jabatan: {
                        validators: {
                            notEmpty: {
                                message: 'Jabatan harus dipilih'
                            },
                        }
                    },
                    pertama_kerja: {
                        validators: {
                            notEmpty: {
                                message: 'Pertama kerja harus diisi'
                            },
                        }
                    },
                    pengabdian: {
                        validators: {
                            notEmpty: {
                                message: 'Pengabdian harus diisi'
                            },
                        }
                    },
                    pendidikan: {
                        validators: {
                            notEmpty: {
                                message: 'Pendidikan harus diisi'
                            },
                        }
                    },
                    foto: {
                        validators: {
                            notEmpty: {
                                message: 'Foto harus diisi'
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
        $(document).ready(function() {
            var flatpickrFriendly = document.querySelector("#flatpickr-human-friendly");

            flatpickrFriendly.flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d"
            });
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
