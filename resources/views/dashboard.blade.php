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
  <div>
        <!-- Dropdown untuk filter kelas satwa -->
        <select id="classFilter">
            <option value="">Pilih Kelas Satwa</option>
            <!-- Opsi kelas satwa akan diisi melalui JS -->
        </select>
        <button id="filterButton">Filter</button>
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

<div id="charts-container">
  <div class="container-fluid px-0">
      <!-- Baris pertama untuk Kartu 1-6 -->
      <div class="row mb-3">
          <!-- Loop untuk membuat semua kartu dalam satu baris -->
          <div class="col-lg-2 col-md-4 col-sm-6"> <!-- Lebar kolom disesuaikan agar semua kartu muat dalam satu baris -->
              <!-- Kartu 1 -->
              <div class="card mb-2 custom-card-size">
                  <div class="card-body-1">
                      <h5 style="" class="card-title">Jumlah LK</h5>
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

    <!-- Baris kedua untuk Jenis LK dan Wilayah LK -->
<div id="charts-container">
  <div class="row mb-4"> <!-- Menambahkan margin-bottom pada baris pertama -->
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

<!-- Baris ketiga untuk Jumlah Spesies Individu dan Kelas Satwa -->
<div class="row mb-4"> <!-- Menambahkan margin-bottom pada baris kedua -->
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
</div>

<!-- Baris keempat untuk Jenis Tagging dan Jenis Koleksi -->
<div class="row"> <!-- Baris ketiga, tanpa margin-bottom untuk menjaga jarak antar elemen -->
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

<script>
    $(document).ready(function() {
    // Mengambil data kelas satwa dari backend dan menambahkannya ke dropdown filter
    $.ajax({
        url: "{{ route('dashboard.filter-class') }}", // URL ke controller filterClass
        method: 'GET',
        success: function(response) {
            // Memasukkan kelas satwa ke dropdown
            var $filterClass = $('#classFilter');
            $filterClass.empty();
            $filterClass.append('<option value="">Pilih Kelas Satwa</option>');
            
            response.forEach(function(classItem) {
                $filterClass.append('<option value="' + classItem + '">' + classItem.charAt(0).toUpperCase() + classItem.slice(1) + '</option>');
            });
        },
        error: function() {
            alert("Terjadi kesalahan saat memuat data kelas satwa.");
        }
    });

    
});

// Fungsi untuk memperbarui grafik
function updateChart(data) {
    // Misalnya menggunakan Chart.js untuk memperbarui grafik
    var ctx = document.getElementById('myChart').getContext('2d');

    // Pastikan untuk menghancurkan chart lama jika ada
    if (window.myChart) {
        window.myChart.destroy();
    }

    // Membuat grafik baru dengan data yang sudah difilter
    window.myChart = new Chart(ctx, {
        type: 'bar', // Misalnya tipe grafik bar
        data: {
            labels: data.labels, // Misalnya data.labels berisi nama kelas atau kategori
            datasets: [{
                label: 'Jumlah Satwa',
                data: data.values, // Misalnya data.values berisi nilai yang akan diplot
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        });
}


</script>
@endsection

@push('plugin-scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush