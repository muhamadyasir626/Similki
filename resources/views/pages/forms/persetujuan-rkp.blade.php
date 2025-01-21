@extends('layouts.master')

@push('plugin-styles')
  <link rel="stylesheet" href="{{ asset('css/pendataan-satwa-koleksi.css') }}">
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Persetujuan RKP</li>
  </ol>
</nav>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">PERSETUJUAN RKP</h4>
            <form action="{{ route('store-satwa-titipan') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="row mb-3">
                <div class="form-group col-md-3">
                    <label for=""><h6>Nama calon LK</h6></label>
                    <input type="text" name="nama_calon_lk" id="nama_calon_lk" placeholder="Nama calon LK" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for=""><h6>Bentuk LK</h6></label>
                    <input type="text" name="bentuk_lk" id="bentuk_lk" placeholder="Bentuk LK" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for=""><h6>Nama direktur</h6></label>
                    <input type="text" name="nama_direktur" id="nama_direktur" placeholder="Nama Direktur" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for=""><h6>Email</h6></label>
                    <input type="email" name="email_lk" id="email_lk" placeholder="Email" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-md-12">
                    <label for=""><h6>Alamat LK</h6></label>
                    <input type="text" name="alamat_lk" id="alamat_lk" placeholder="Alamat Lembaga Konservasi" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-md-3">
                    <label for=""><h6>NIB</h6></label>
                    <input type="text" name="nib" id="nib_lk" placeholder="NIB" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for=""><h6>NPWP</h6></label>
                    <input type="text" name="npwp" id="npwp_lk" placeholder="NPWP" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for=""><h6>Jumlah investasi</h6></label>
                    <input type="number" name="jumlah_investasi" id="jumlah_investasi" placeholder="Jumlah investasi" class="form-control" value="Rp" required>
                </div>
                <div class="form-group col-md-3">
                    <label for=""><h6>Jumlah tenaga kerja</h6></label>
                    <input type="number" name="jumlah_tenaga_kerja" id="jumlah_tenaga_kerja" placeholder="Jumlah tenaga kerja" class="form-control" required>
                </div>
            </div>

            <h5 style="margin-bottom: 10px">Dokumen yang dibutuhkan</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="site_plan" class="form-label"><h6>Upload site plan</h6></label>
                    <input type="file" class="form-control" id="site_plan" name="site_plan" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                </div>
                <div class="col-md-6">
                    <label for="dokumen_persetujuan_lingkungan" class="form-label"><h6>Upload dokumen persetujuan lingkungan (UKL UPL / Amdal)</h6></label>
                    <input type="file" class="form-control" id="dokumen_persetujuan_lingkungan" name="dokumen_persetujuan_lingkungan" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="draft_rkp" class="form-label"><h6>Upload dokumen draft RKP</h6></label>
                    <input type="file" class="form-control" id="draft_rkp" name="draft_rkp" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                </div>
                <div class="col-md-6">
                    <label for="surat_permohonan" class="form-label"><h6>Surat permohonan</h6></label>
                    <input type="file" class="form-control" id="surat_permohonan" name="surat_permohonan" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                </div>  
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Ajukan Permohonan</button>
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
