@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Input Investasi</li>
  </ol>
</nav>

<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <h6 class="card-title">Input Investasi</h6>

        <form class="forms-sample">
          <div class="mb-3">
            <label for="jumlah_karyawan_laki" class="form-label">Jumlah Karyawan Laki-laki</label>
            <input type="number" class="form-control" id="jumlah_karyawan_laki" autocomplete="off" placeholder="Jumlah Karyawan Laki-laki" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label for="jumlah_karyawan_perempuan" class="form-label">Jumlah Karyawan Perempuan</label>
            <input type="number" class="form-control" id="jumlah_karyawan_perempuan" placeholder="Jumlah Karyawan Perempuan" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label for="jumlah_dokter_hewan" class="form-label">Jumlah Dokter Hewan</label>
            <input type="number" class="form-control" id="jumlah_dokter_hewan" placeholder="Jumlah Dokter Hewan" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label for="luas_lahan_konservasi" class="form-label">Luas Lahan Konservasi</label>
            <input type="number" class="form-control" id="luas_lahan_konservasi" placeholder="Luas Lahan Konservasi" step="0.01" min="0">
          </div>
          <div class="mb-3">
            <label for="jumlah_investasi" class="form-label">Jumlah Investasi</label>
            <input type="number" class="form-control" id="jumlah_investasi" placeholder="Jumlah Investasi" step="0.01" min="0">
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
          <button class="btn btn-secondary">Cancel</button>
        </form>
      </div>
    </div>
  </div>

  @endsection
