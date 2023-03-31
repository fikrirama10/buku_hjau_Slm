@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title">Edot Tarif</h5>
            <a class='btn btn-secondary' href='{{ route('tarif') }}'>Kembali</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('post-edit-tarif', $tarif->id) }}" id='tambah_tarif' method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Nama Tarif</label>
                                <input type="text" class='form-control' value='{{ $tarif->nama_tarif }}'
                                    name='nama_tarif'>
                            </div>
                            <div class="col-md-12">
                                <label for="">Kategori Tarif</label>
                                <select name="kategori_tarif" class='form-select' id="kategori_tarif">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $kt)
                                        <option value="{{ $kt->id }}"
                                            {{ $tarif->kategori_tarif == $kt->id ? 'selected' : '' }}>
                                            {{ $kt->kategori_tarif }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Harga Tarif</label>
                                <input type="text" value='{{ $tarif->nominal_tarif }}' class='form-control'
                                    name='harga_tarif'>
                            </div>
                            <div class="col-md-12">
                                <label for="">Status Tarif</label>
                                <select name="status_tarif" class='form-select' id="">
                                    <option value="Aktif" {{ $tarif->status_tarif == 'Aktif' ? 'selected':'' }}>Aktif</option>
                                    <option value="Non Aktif" {{ $tarif->status_tarif == 'Non Aktif' ? 'selected':'' }}>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('tarif') }}" class="btn btn-secondary">Close</a>
            <button type="button" id='btn_simpan' class="btn btn-primary">Save changes</button>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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
                    status_tarif: {
                        validators: {
                            notEmpty: {
                                message: 'Status Tarif Harus Dipilih'
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
                            text: "Yakin mengubah data ? ",
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
