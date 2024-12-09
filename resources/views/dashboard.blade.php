@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-10">Welcome to SIMILKI</h4>
  </div>
  <div class="d-flex align-items-center flex-wrap text-nowrap">
  
    {{-- <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
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
  </div> --}}
</div>

  <div class="container-fluid px-0">
      <!-- Baris pertama untuk Kartu 1-6 -->
      <div class="row mb-3">
          <!-- Kartu 1 -->
          <div class="col-lg-2 col-md-4 col-sm-6">
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 class="card-title">Jumlah LK</h5>
                      <h3 data-lkcount="{{ $lk_count }}">{{ $lk_count }}</h3>
                  </div>
              </div>
          </div>
          <!-- Kartu 2 -->
          <div class="col-lg-2 col-md-4 col-sm-6">
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 class="card-title">Total Jenis Satwa</h5>
                      <h3 data-species="{{ $species_count }}">{{ $species_count }}</h3>
                  </div>
              </div>
          </div>
          <!-- Kartu 3 -->
          <div class="col-lg-2 col-md-4 col-sm-6">
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 class="card-title">Satwa Koleksi</h5>
                      <h3 data-skoleksi="{{ $skoleksi_count }}">{{ $skoleksi_count }}</h3>
                  </div>
              </div>
          </div>
          <!-- Kartu 4 -->
          <div class="col-lg-2 col-md-4 col-sm-6">
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 class="card-title">Satwa Titipan</h5>
                      <h3 data-stitipan="{{ $stitipan_count }}">{{ $stitipan_count }}</h3>
                  </div>
              </div>
          </div>
          <!-- Kartu 5 -->
          <div class="col-lg-2 col-md-4 col-sm-6">
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 class="card-title">Satwa Belum Tagging</h5>
                      <h3 data-sbelumtag="{{ $sbelumtag_count }}">{{ $sbelumtag_count }}</h3>
                  </div>
              </div>
          </div>
          <!-- Kartu 6 -->
          <div class="col-lg-2 col-md-4 col-sm-6">
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 class="card-title">Satwa Hidup</h5>
                      <h3 data-shidup="{{ $shidup_count }}">{{ $shidup_count }}</h3>
                  </div>
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
    <div class="card h-100 custom-card-size jumlah-species-individu">
        <div class="card-body-3">
            <h5 class="card-title">Jumlah Spesies Individu</h5>
            <div id="spesiesIndvChart" data-counts="{{ $total_jumlahIndvSpesies }}"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card h-100 custom-card-size">
      <div class="card-body-3">
        <h5 class="card-title">Taksa</h5>
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
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/search-filter.js') }}"></script>
@endpush
