@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title">Detail Tarif</h5>
            <a class='btn btn-secondary' href='{{ route('tarif') }}'>Kembali</a>
        </div>
        <div class="card-body">            
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card border">        
                      
                <div class="card-body">    
                    <table class='table table-border'>
                        <tbody>
                            <tr>
                                <td>Tarif</td>                                
                                <td>{{ $tarif->nama_tarif }}</td>
                            </tr>
                            <tr>
                                <td>Harga</td>                                
                                <td>Rp. {{  number_format($tarif->nominal_tarif,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>                                
                                <td>{{ $tarif->tarif_kategori }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border">     
                <div class="card-header d-flex justify-content-between pb-1">
                    <h5 class="mb-0 card-title">Rincian Tarif</h5>
                    <button class='btn btn-success' data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                        class="menu-icon tf-icons ti ti-playlist-add"></i> Tambah Rincian</button>
                </div>           
                <div class="card-body">
                    <br>   
                    <table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th width=10>No</th>
                                <th>Unit</th>
                                <th>Nominal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                                $total = 0;
                            @endphp
                            @foreach ($tarif_detail as $td)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $td->unit }}</td>
                                    <td>{{  number_format($td->nominal,2,',','.') }}</td>
                                    <td>
                                        <a href="" class='btn btn-info btn-xs'>Edit</a>
                                        <a href="{{ route('delete-detail-tarif',$td->id) }}" class='btn btn-danger btn-xs'>Hapus</a>
                                    </td>
                                </tr>
                                @php
                                    $total += $td->nominal;
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan =2 class='text-end fw-bold' >Total</td>
                                <td class='text-start fw-bold'>{{ number_format($total ,2,',','.') }}</td>
                                <td>{!! $tarif->nominal_tarif < $total ? '<span class="text-danger fw-bold">Total rincian melebihi tarif !!</span>':'' !!}</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Rincian Tarif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('post-detail-tarif',$tarif->id) }}" id='tambah_tarif' method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Unit</label>
                                <select id="select2Basic" class="select2 form-select" name='unit' data-allow-clear="true">
                                    @foreach ($unit as $unt)
                                        <option value="{{ $unt->id }}">{{ $unt->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Nominal</label>
                                <input type="text" class='form-control' name='nominal'>
                            </div>
                           
                            <div class="col-md-12">
                                <small class="text-light fw-semibold d-block">Sekali</small>
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" name='sekali' type="checkbox" id="inlineCheckbox1" value="1" />
                                    <label class="form-check-label" for="inlineCheckbox1">Sekali ?</label>
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                                <label for="">Keterangan</label>
                                <input type="text" class='form-control' name='ketarangan'>
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
    <script>
        $(".select2").select2({
            dropdownParent: $('#exampleModal')
        });
        const form = document.querySelector('#tambah_tarif');
        var validatorPersonalData = FormValidation.formValidation(
            form, {
                fields: {
                    unit: {
                        validators: {
                            notEmpty: {
                                message: 'Unit harus dipilih'
                            },
                        }
                    },
                    nominal: {
                        validators: {
                            notEmpty: {
                                message: 'Nominal harus diisi'
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