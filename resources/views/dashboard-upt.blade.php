@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  {{-- <style>
    h3{
        display: flex;
        justify-content: flex-end;
    }

    .card-body-1,.card-body-2{
      padding: 10px;
    }

    .row{
      padding: 10px;
    }

</style> --}}
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">{{ $user->upt->bentuk && $user->upt->wilayah ? $user->upt->bentuk . ' - ' . $user->upt->wilayah : 'Data tidak tersedia' }}
    </h4>
  </div>
  <div class="d-flex align-items-center flex-wrap text-nowrap">
    <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
      <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
      <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
    </div>
    <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
      <i class="btn-icon-prepend" data-feather="printer"></i>
      Print
    </button>
    <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
      <i class="btn-icon-prepend" data-feather="download-cloud"></i>
      Download Report
    </button>
  </div>
</div>

<div class="container-fluid px-0">
    <!-- Baris pertama untuk Kartu 1-6 -->
    <div class="row mb-3">
        <!-- Loop untuk membuat semua kartu dalam satu baris -->
        <div class="col-lg-2 col-md-4 col-sm-6"> <!-- Lebar kolom disesuaikan agar semua kartu muat dalam satu baris -->
            <!-- Kartu 1 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Jumlah LK</h5>
                    <h3>{{ $lk_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <!-- Kartu 2 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Total Jenis Satwa</h5>
                    <h3>{{ $species_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <!-- Kartu 3 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Satwa Koleksi</h5>
                    <h3>{{ $skoleksi_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <!-- Kartu 4 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Satwa Titipan</h5>
                    <h3>{{ $stitipan_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <!-- Kartu 5 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Satwa Belum Tagging</h5>
                    <h3>{{ $sbelumtag_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <!-- Kartu 6 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Satwa Hidup</h5>
                    <h3> {{ $shidup_count }}</h3>
                </div>
            </div>
        </div>
  </div>
</div>

<!-- Row pertama untuk Bentuk LK dan Kelas Satwa -->
<div class="row mb-4"> <!-- Menambahkan margin-bottom untuk memberikan jarak antar row -->
  <!-- Kolom untuk Bentuk LK -->
  <div class="col-lg-6">
    <div class="card h-100 custom-card-size">
      <div class="card-body-2">
        <h5 class="card-title">Bentuk LK</h5>
        <div id="jenisLKChart" data-counts="{{ $total_bentukLk }}"></div>
      </div>
    </div>
  </div>

  <!-- Kolom untuk Kelas Satwa -->
  <div class="col-lg-6">
    <div class="card h-100 custom-card-size">
      <div class="card-body-2">
        <h5 class="card-title">Kelas Satwa</h5>
        <div id="chartContainer2" data-counts="{{ $total_class }}"></div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="card h-100 custom-card-size jumlah-species-individu">
      <div class="card-body">
        <h5 class="card-title">Jumlah Spesies Individu</h5>
        <!-- Input Search -->
        <input 
          type="text" 
          id="searchSpecies" 
          class="form-control mb-3" 
          placeholder="Cari spesies..." 
          oninput="filterChartData()">
        
        <!-- Grafik -->
        <div id="spesiesIndvChart" data-counts="{{ $total_jumlahIndvSpesies }}"></div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard-upt.js') }}"></script>
@endpush