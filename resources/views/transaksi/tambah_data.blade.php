@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex border-bottom justify-content-between pb-2">
            <h5 class="mb-0 card-title">Tambah Transaksi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('post-tambah') }}" id="form_tambah" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Tgl Masuk</label>
                                <input type="date" name='tgl_masuk' max='{{ date('Y-m-d') }}' class="form-control"
                                    id="defaultFormControlInput" placeholder="John Doe"
                                    aria-describedby="defaultFormControlHelp" />
                                <div id="defaultFormControlHelp" class="form-text">Tgl Masuk / Tgl Daftar</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="defaultFormControlInput" class="form-label">No RM</label>
                                <select id="tag_list" name="no_rm" class="form-select"></select>
                                <div id="defaultFormControlHelp" class="form-text">Isikan nomer RM Pasien</div>
                            </div>
                            <div class="col-md-6">
                                <label for="defaultFormControlInput" class="form-label">Dokter</label>
                                <select id="tag_list2" class='' name="id_dokter" class="form-select"></select>
                                <div id="defaultFormControlHelp" class="form-text">Isikan nomer RM Pasien</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="defaultFormControlInput" class="form-label">Jenis Pelayanan</label>
                                <select name="jenis_rawat" class='form-select' id="jenis_rawat">
                                    {{-- @foreach ($jenis_rawat as $jr)
                                        <option value="{{ $jr->id_jenis }}">{{ $jr->jenis_rawat }}</option>
                                    @endforeach --}}
                                    <option value="">Pilih Jenis Pelayanan</option>
                                    <option value="Rawat Inap">Rawat Inap</option>
                                    <option value="Rawat Jalan">Rawat Jalan</option>
                                    <option value="UGD">UGD</option>
                                    <option value="LAB">LAB</option>
                                    <option value="Radiologi">Radiologi</option>
                                    <option value="Rikkes">Rikkes</option>
                                    <option value="Tes Kesehatan">Tes Kesehatan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="defaultFormControlInput" class="form-label">Poli / Ruangan</label>
                                <input type="text" class='form-control' name='poli_ruangan'>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Penanggung Jawab</label>
                                <input type="text" class='form-control' name='penanggung_jawab'>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <small class="text-light fw-semibold d-block">Input SIMRS</small>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" name='input_simrs' type="checkbox" id="inlineCheckbox1" value="1" />
                                    <label class="form-check-label" for="inlineCheckbox1">Input Simrs ?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button class='btn btn-success' id='btn_simpan' type="button">Simpan</button>
            <button class='btn btn-secondary'>Batal</button>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#tag_list').select2({
            placeholder: "Masukan nomer RM pasien",
            minimumInputLength: 2,
            ajax: {
                url: '{{ route('get-pasien') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        $('#tag_list2').select2({
            placeholder: "Masukan nama dokter",
            minimumInputLength: 2,
            ajax: {
                url: '{{ route('get-dokter') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        const form = document.querySelector('#form_tambah');
        var validatorPersonalData = FormValidation.formValidation(
            form, {
                fields: {
                    penanggung_jawab: {
                        validators: {
                            notEmpty: {
                                message: 'Nama penanggung jawab harus diisi'
                            },
                        }
                    },
                    poli_ruangan: {
                        validators: {
                            notEmpty: {
                                message: 'Poli / Ruangan harus diisi'
                            },

                        }
                    },
                    jenis_rawat: {
                        validators: {
                            notEmpty: {
                                message: 'Jenis rawat harus dipilih'
                            },
                        }
                    },
                    id_dokter: {
                        validators: {
                            notEmpty: {
                                message: 'Dokter harus dipilih'
                            },
                        }
                    },
                    no_rm: {
                        validators: {
                            notEmpty: {
                                message: 'RM harus diisi'
                            },
                        }
                    },
                    tgl_masuk: {
                        validators: {
                            notEmpty: {
                                message: 'Tgl masuk harus diisi'
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
    </script>
@endpush
