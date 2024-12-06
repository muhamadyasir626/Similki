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
<div class="d-flex justify-content-between aliingn-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
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

    <!-- Baris kedua untuk Jenis LK dan Wilayah LK -->
    <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-6">
            <div class="card h-100 custom-card-size">
                <div class="card-body-2">
                    <h5 class="card-title">Bentuk Lembaga Konservasi</h5>
                    <div id="jenisLKChart" data-counts="{{ $total_bentukLk }}">                      
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
          <div class="card h-100 custom-card-size">
              <div class="card-body-2">
                  <h5 class="card-title">Wilayah Lembaga Konservasi</h5>
                  <div id="wilayahLKChart" data-counts="{{ $total_wilayahLk }}"></div>
              </div>
          </div>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="card h-200 custom-card-size">
      <div class="card-body-3">
        <h5 class="card-title">Taksa</h5>
        <div id="chartContainer1" data-counts="{{ $total_taksa }}"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card h-200 custom-card-size">
      <div class="card-body-3">
        <h5 class="card-title">Jenis Tagging</h5>
        <div id="chartContainer2" data-counts="{{ $total_tagging }}"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="card h-100 custom-card-size">
      <div class="card-body-2">
        <h5 class="card-title">Jenis Koleksi</h5>
        <div id="chartContainer3"></div>
      </div>
    </div>
  </div>
</div> 

<div class="row">
    <div class="col-lg-12">
        <div class="card h-100 custom-card-size">
            <div class="card-body">
                <h5 class="card-title">Jumlah Spesies Individu</h5>
                <div id="spesiesIndvChart"></div>
            </div>
        </div>
    </div>
</div>
  
      

<!-- <div class="row">
  <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Monthly sales</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <p class="text-muted">Sales are activities related to selling or the number of goods or services sold in a given time period.</p>
        <div id="monthlySalesChart"></div>
      </div> 
    </div>
  </div>
  <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Cloud storage</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div id="storageChart"></div>
        <div class="row mb-3">
          <div class="col-6 d-flex justify-content-end">
            <div>
              <label class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Total storage <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
              <h5 class="fw-bolder mb-0 text-end">8TB</h5>
            </div>
          </div>
          <div class="col-6">
            <div>
              <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span class="p-1 me-1 rounded-circle bg-primary"></span> Used storage</label>
              <h5 class="fw-bolder mb-0">~5TB</h5>
            </div>
          </div>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary">Upgrade storage</button>
        </div>
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
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush