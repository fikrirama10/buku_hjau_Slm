@extends('main')

@section('content')
    <div class="card border">
        <div class="card-header d-flex justify-content-between pb-1">
            <h5 class="mb-0 card-title">Laporan</h5>
        </div>
        <div class="card-body">
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
                        <div class="col-md-4">
                            <label class='form-label' for="">Bulan</label>
                            <div class="input-group mb-3">
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
                                <button class="btn btn-outline-primary" type="button"
                                    id="button-addon2">Lihat</button>
                                
                            </div>
                            
                        </div>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
@endsection