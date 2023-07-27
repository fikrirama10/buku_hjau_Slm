@extends('main')

@section('content')
    <div class="row">

        <div class="col-md-8">

            <div class="card border">
                <div class="card-header d-flex justify-content-between pb-1">
                    <h5 class="mb-0 card-title">Transaksi {{ $transaksi->id_transaksi }}</h5>
                    @if ($transaksi->status_transaksi < 3)
                        <button class='btn btn-warning text-white' data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                class="menu-icon tf-icons ti ti-playlist-add"></i> Tambah DP</button>
                    @endif
                </div>

                <div class="card-body">
                    @if ($transaksi->status_transaksi < 3)
                        <form id='form_trx' action="{{ route('post-tambah-tarif', $transaksi->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Masukan Nama Tarif</label>
                                    <select id="tag_list" name="tarif" class="form-select"></select>
                                </div>
                            </div>
                    @endif
                </div>

            </div>
            @if ($transaksi->status_transaksi < 3)
            
            <br>
                <div class="card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Nama Tarif</label>
                                <input type="text" name='nama_tarif' readonly id='nama_tarif' class='form-control'>
                            </div>
                            <div class="col-md-2">
                                <label for="">Tarif</label>
                                <input type="text" name='harga_tarif' readonly id='harga_tarif' class='form-control'>
                            </div>
                            <div class="col-md-4">
                                <label for="">Dokter</label>
                                <select id="tag_list2" class='form-select' name="id_dokter" class="form-select"></select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Jumlah</label>
                                <input type="text" name='jumlah' id='jumlah' class='form-control'>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            </form>
            <br>
            <div class="card border">
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Nama Tarif</th>
                                    <th>Tarif</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($transaksi_detail as $td)
                                    <tr>
                                        <td>
                                            {{ $td->nama_tarif }}
                                            @if ($td->dokter)
                                                <br> <a class='text-primary'>( {{ $td->dokter }} )</a>
                                            @endif
                                        </td>
                                        <td>Rp. {{ number_format($td->nominal_tarif, 2, ',', '.') }}</td>
                                        <td>{{ $td->jumlah }} x</td>
                                        <td>Rp. {{ number_format($td->harga_total, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($transaksi->status_transaksi < 3)
                                                <a href="{{ route('delete-item-tarif', $td->id) }}"
                                                    class='btn btn-danger btn-xs'>Hapus</a>
                                            @endif

                                        </td>
                                    </tr>
                                    @php
                                        $total += $td->harga_total;
                                    @endphp
                                @endforeach
                                <tr>

                                    <td colspan="3" class="text-end pe-3 py-4">
                                        <p class="mb-2 pt-2">Subtotal:</p>
                                        {{-- <p class="mb-2">Discount %:</p> --}}
                                        {{-- <p class="mb-0 pb-3">Total:</p> --}}
                                    </td>
                                    <td colspan="2" class="ps-2 py-4">
                                        <p class="fw-semibold mb-2 pt-3"><input type="text" class='form-control' readonly
                                                name='sub_total' value='{{ $total }}'></p>
                                        {{-- <p class="fw-semibold mb-2"><input type="text" class='form-control'
                                                name='diskon' value='0'></p> --}}
                                        {{-- <p class="fw-semibold mb-0 pb-3"><input type="text" class='form-control' readonly
                                                name='total' value='{{ $total }}'> </p> --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="col-md-4">
            <div class="card border mb-2">
                <div class="card-body">
                    <table class='table'>
                        <tbody>
                            <tr>
                                <td>{{ $transaksi->no_rm }} - {{ $transaksi->nama_pasien }}</td>
                            </tr>
                            <tr>
                                <td>{{ $transaksi->tgl_transaksi }}</td>
                            </tr>
                            <tr>
                                <td>{{ $transaksi->nama_dokter }}</td>
                            </tr>
                            <tr>
                                <td>{{ $transaksi->jenis_rawat }} - {{ $transaksi->poli_ruangan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    @if (count($transaksi_dp) > 0)
                        <div class="added-cards">
                            @foreach ($transaksi_dp as $dp)
                                <div class="cardMaster bg-lighter p-3 rounded mb-3">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                                        <div class="card-information me-2">
                                            <div class="d-flex align-items-center mb-2 flex-wrap gap-2">
                                                <p class="mb-0 me-2">{{ $dp->nama_dp }}</p>
                                                <span class="badge bg-label-secondary">{{ $dp->status }}</span>
                                            </div>
                                            <span class="card-number">Rp.{{ number_format($dp->nominal, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column text-start text-lg-end">
                                            <div class="d-flex order-sm-0 order-1 mt-sm-0 mt-3">
                                                @if ($transaksi->status_transaksi != 4)
                                                    @if ($dp->status == 'Aktif')
                                                        <a target="_blank" href='{{ route('kwitansi-dp', $dp->id) }}'
                                                            class="btn btn-label-primary me-2 waves-effect">Print</a>
                                                        <a href='{{ route('delete-dp', $dp->id) }}' id='btn-delete'
                                                            class="btn btn-label-danger waves-effect">Delete</a>
                                                    @endif
                                                @endif
                                            </div>
                                            <small class="mt-sm-auto mt-2 order-sm-1 order-0">Tgl.DP
                                                {{ date('d/m/Y', strtotime($dp->tgl_dp)) }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    @if ($transaksi->status_transaksi == 4)
                        <div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
                            <span class="alert-icon alert-icon-lg text-danger me-2">
                                <i class="ti ti-user ti-sm"></i>
                            </span>
                            <div class="d-flex flex-column ps-1">
                                <h5 class="alert-heading mb-2">Transaksi Telah dibatalkan</h5>
                                <p class="mb-0">Alasan Batal : </p>
                            </div>
                        </div>
                    @else
                        @if ($transaksi->status_transaksi < 3)
                            <button class="btn btn-primary d-grid w-100 mb-2 waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#backDropModal">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="ti ti-send ti-xs me-1"></i>Bayar</span>
                            </button>
                            @if (auth()->user()->role_id == 1)
                            <a href="{{ route('preview-rajal',$transaksi->id) }}" target="_blank" class="btn btn-label-secondary d-grid w-100 mb-2 waves-effect">Preview</a>
                            @endif
                            
                            <a href="{{ route('transaksi') }}"
                                class="btn btn-label-secondary d-grid w-100 waves-effect">Simpan</a>
                            <a
                                href='{{ route('batal-transaksi', $transaksi->id) }}'class="btn btn-danger d-grid w-100 mt-2 waves-effect waves-light">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="ti ti-trash ti-xs me-1"></i>Batal</span>
                            </a>
                        @else
                            <a target="_blank" href="{{ route('faktur-rajal',$transaksi->id) }}" class="btn btn-label-warning d-grid w-100 mb-2 waves-effect">Print</a>
                            <a target="_blank" href="{{ route('kwitansi-akhir',$transaksi->id) }}" class="btn btn-info d-grid w-100 mb-2 waves-effect">Print Kwitansi AKhir</a>
                            <a href="{{ route('transaksi') }}" class="btn btn-label-secondary d-grid w-100 waves-effect">Kembali</a>
                            @if (auth()->user()->role_id == 1)
                            <a
                            href='{{ route('edit-transaksi', $transaksi->id) }}'class="btn btn-warning d-grid w-100 mt-2 waves-effect waves-light">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="ti ti-pencil ti-xs me-1"></i>Edit</span>
                        </a>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Pembayaran </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id='form_lunas' action="{{ route('post-bayar', $transaksi->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBackdrop" class="form-label">Nama Petugas</label>
                                <input type="text" id="nameBackdrop" value="{{ $transaksi->nama_user }}" name='nama_petugas' class="form-control"
                                    placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="dobBackdrop" class="form-label">Tgl. Keluar</label>
                                <input type="date" name='tgl_keluar' value="{{ date('Y-m-d'.strtotime($transaksi->tgl_keluar)) }}" id="dobBackdrop"
                                    min='{{ $transaksi->tgl_masuk }}' max='{{ date('Y-m-d') }}' class="form-control"
                                   >
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col">
                            <div class="card border">
                                <div class="card-body">
                                    <table class='table'>
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td width=10>:</td>
                                                <td>Rp. {{ number_format($total, 2, ',', '.') }}</td>
                                            </tr>
                                            @php
                                                $total_dp = 0;
                                            @endphp
                                            @if (count($transaksi_dp) > 0)
                                                @foreach ($transaksi_dp as $tdp)
                                                    @php
                                                        $total_dp += $tdp->nominal;
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <td>DP</td>
                                                    <td>:</td>
                                                    <td>Rp. {{ number_format($total_dp, 2, ',', '.') }}</td>
                                                </tr>
                                            @endif
                                            <tr class='fw-bold'>
                                                <td>Total yang harus di bayar</td>
                                                <td>:</td>
                                                <td>Rp. {{ number_format($total - $total_dp, 2, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id='btn_lunas' class="btn btn-primary">Lunas</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('post-dp', $transaksi->id) }}" id='form_dp' method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Tanggal DP</label>
                                <input type="date" class="form-control" name='tgl_dp'>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Nama DP</label>
                                <input type="text" name='nama_dp' class='form-control'>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Nominal DP</label>
                                <input type="text" name='nominal' class='form-control'>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Nama Kasir</label>
                                <input type="text" name="nama_kasir" class='form-control'>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id='btn_simpan' class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('scripts')
        <script>
            $(document).on('keypress', function(e) {
                if (e.which == 13) {
                    const form = document.querySelector('#form_trx');
                    var jumlah = $('#jumlah').val();
                    form.submit();
                }
            });
            $('#tag_list2').change(function() {
                $.get().done(function() {
                    $('#jumlah').val(1);
                    $('#jumlah').focus();
                });

            });
            $('#tag_list').change(function() {
                let url = '{{ route('get-tarif-id', ':post_id') }}';
                url = url.replace(':post_id', this.value);
                $.get(url).done(function(data) {
                    console.log(data);
                    $('#nama_tarif').val(data.nama_tarif);
                    $('#harga_tarif').val(data.nominal_tarif);
                    $('#jumlah').val(1);
                    $('#jumlah').focus();
                })
            });
            $('#tag_list').select2({
                placeholder: "Masukan Nama Tarif",
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route('get-tarif') }}',
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
            const form_lunas = document.querySelector('#form_lunas');
            var validatorLunas = FormValidation.formValidation(
                form_lunas, {
                    fields: {
                        nama_petugas: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Petugas harus diisi'
                                },
                            }
                        },
                        tgl_keluar: {
                            validators: {
                                notEmpty: {
                                    message: 'Tgl keluar harus diisi'
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
                }
            )
            const form = document.querySelector('#form_dp');
            var validatorPersonalData = FormValidation.formValidation(
                form, {
                    fields: {
                        nama_dp: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama DP harus diisi'
                                },
                            }
                        },
                        tgl_dp: {
                            validators: {
                                notEmpty: {
                                    message: 'Tanggal DP harus diisi'
                                },
                            }
                        },
                        nominal: {
                            validators: {
                                notEmpty: {
                                    message: 'Nominal DP harus diisi'
                                },
                            }
                        },
                        nama_kasir: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Kasir harus diisi'
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
            var confirmLunas = document.querySelector('#btn_lunas');
            confirmLunas.addEventListener('click', function(e) {
                e.preventDefault();
                if (validatorLunas) {
                    validatorLunas.validate().then(function(status) {
                        if (status == 'Valid') {
                            Swal.fire({
                                title: '',
                                text: "Yakin menyelesaikan transaksi ? ",
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
                                        form_lunas.submit();
                                    }, 1000);
                                }
                            })
                        }
                    });
                }

            });
            var confirmSave = document.querySelector('#btn_simpan');
            confirmSave.addEventListener('click', function(e) {
                e.preventDefault();
                if (validatorPersonalData) {
                    validatorPersonalData.validate().then(function(status) {
                        if (status == 'Valid') {
                            Swal.fire({
                                title: '',
                                text: "Yakin menambah DP ? ",
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

            // var flatpickrDateTime = document.querySelector("#flatpickr-datetime");

            // flatpickrDateTime.flatpickr({
            //     enableTime: true,
            //     dateFormat: "Y-m-d H:i"
            // });
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
        </script>
    @endpush
