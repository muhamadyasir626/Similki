@extends('layouts.master')

@push('plugin-styles')
  <link rel="stylesheet" href="{{ asset('css/pendataan-satwa-koleksi.css') }}">
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Input Satwa Titipan</li>
  </ol>
</nav>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pendataan Satwa Titipan</h5>
            <form action="{{ route('store-satwa-titipan') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nama_ilmiah" class="form-label"><h6>Nama ilmiah</h6></label>
                    <select class="form-select" name="nama_ilmiah">
                        <option selected>Nama ilmiah</option>
                        <option value="lala">Opsi 1</option>
                        <option value="lili">Opsi 2</option>
                        <option value="lulu">Opsi 3</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="nama_lokal" class="form-label"><h6>Nama lokal</h6></label>
                    <select class="form-select" name="nama_lokal">
                        <option selected>Nama lokal*</option>
                        <option value="lala">Opsi 1</option>
                        <option value="lili">Opsi 2</option>
                        <option value="lulu">Opsi 3</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="english_name" class="form-label"><h6>English name</h6></label>
                    <select class="form-select" name="english_name">
                        <option selected>English name*</option>
                        <option value="lala">Opsi 1</option>
                        <option value="lili">Opsi 2</option>
                        <option value="lulu">Opsi 3</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="no_bap_titipan" class="form-label"><h6>No BAP Titipan</h6></label>
                        <input type="text" name="no_bap_titipan" id="no_bap_titipan" placeholder="No BAP" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="asal_satwa" class="form-label"><h6>Asal satwa</h6></label>
                    <select class="form-select" name="asal_satwa">
                        <option selected>Asal satwa titipan</option>
                        <option value="penyerahan">Penyerahan</option>
                        <option value="sitaan">Sitaan</option>
                        <option value="konflik satwa-manusia">Konflik satwa-manusia</option>
                        <option value="repatriasi">Repatriasi</option>
                        <option value="rampasan">Rampasan</option>
                        <option value="temuan">Temuan</option>
                        <option value="tegahan">Tegahan</option>
                        <option value="dampak bencana">Dampak bencana alam, bencana non alam atau kegiatan manusia</option>
                        <option value="wilayah terisolir">Wilayah yang terisolir</option>                        </option>
                        <option value="lk">LK</option>
                        <option value="penangkaran">Penangkaran</option>
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="form-group col-md-4">
                    <label for=""><h6>Jumlah Jantan</h6></label>
                    <input type="number" name="jumlah_satwa_jantan" id="jumlah_satwa_jantan" placeholder="Jumlah Satwa Jantan" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for=""><h6>Jumlah Betina</h6></label>
                    <input type="number" name="jumlah_satwa_betina" id="jumlah_satwa_betina" placeholder="Jumlah Satwa Betina" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for=""><h6>Jumlah Unknown</h6></label>
                    <input type="number" name="jumlah_satwa_unknown" id="jumlah_satwa_unknown" placeholder="Jumlah Unknown" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <label for="bap_file" class="form-label"><h6>Upload BAP</h6></label>
                    <input type="file" class="form-control" id="bap_file" name="bap_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>


@endsection

@push('custom-scripts')
<script src="{{ asset('assets/js/pendataan-koleksi-satwa.js') }}"></script>  
@endpush