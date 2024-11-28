@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">{{ $user->lk->nama }}</h4>
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
    <div class="row mb-3">
    <!-- Baris pertama untuk Kartu 1-6 -->
    <div class="col-lg-2 col-md-4 col-sm-6">
            <!-- Kartu 6 -->
            <div class="card mb-2 custom-card-size">
                <div class="card-body-1">
                    <h5 class="card-title">Bentuk LK</h5>
                    <h3> {{ $bentuk_lk }}</h3>
                </div>
            </div>
        </div>
        <!-- Loop untuk membuat semua kartu dalam satu baris -->
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

<!-- Baris kedua untuk Jenis LK dan Wilayah LK -->
<div class="row">
  <div class="col-lg-6">
    <div class="card h-1000 custom-card-size jumlah-species-individu">
        <div class="card-body">
            <h5 class="card-title">Jumlah Spesies Individu</h5>
            <div id="spesiesIndvChart" data-counts="{{ $total_jumlahIndvSpesies }}"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card h-100 custom-card-size">
      <div class="card-body-3">
        <h5 class="card-title">Kelas Satwa</h5>
        <div id="chartContainer1" data-counts="{{ $total_class }}"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card h-100 custom-card-size">
      <div class="card-body-3">
        <h5 class="card-title">Jenis Tagging</h5>
        <div id="chartContainer2" data-counts="{{ $total_tagging }}"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card h-100 custom-card-size">
      <div class="card-body-3">
        <h5 class="card-title">Jenis Koleksi</h5>
        <div id="chartContainer3" data-counts="{{ $total_jenis_koleksi }}"></div>
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
  <script src="{{ asset('assets/js/dashboard-lk.js') }}"></script>
@endpush
