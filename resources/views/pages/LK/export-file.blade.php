@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('/css/popup.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/export-file.css') }}">
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Lembaga Konservasi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Export File</li>
  </ol>
</nav>

<div class="container">
  {{-- <h3 class="mb-4">Export File</h3> --}}

  <!-- Form Ekspor -->
  <form id="exportForm" method="POST" action="/export-data">
      @csrf 

      <div class="mb-3 flex text-start col-md-6">
        <label for="data_type" class="form-label"><h6>Mau export data apa?</h6></label>
        <select id="data_type" name="data_type" class="form-select" required>
            <option value="" disabled selected>Pilih Data</option>
            <option value="lembaga_konservasi">Lembaga Konservasi</option>
            <option value="monitoring_lk">Monitoring LK</option>
            <option value="monitoring_investasi">Monitoring Investasi</option>
            <option value="satwa">Satwa</option>
        </select>
      </div>
      
      <div class="mb-3 d-flex text-start col-md-6">
          <div class="flex-grow-1 me-2">
              <label for="start_date" class="form-label"><h6>Dari Tanggal:</h6></label>
              <input type="date" id="start_date" name="start_date" class="form-control form-control-sm" required>
          </div>
          <div class="flex-grow-1 ms-2">
              <label for="end_date" class="form-label"><h6>Hingga Tanggal:</h6></label>
              <input type="date" id="end_date" name="end_date" class="form-control form-control-sm" required>
          </div>
      </div>

      <div class="mb-3 flex text-start col-md-6">
          <label for="format" class="form-label"><h6>Pilih Format </h6></label>
          <select id="format" name="format" class="form-select" required>
              <option value="" disabled selected>Pilih Format</option>
              <option value="csv">CSV</option>
              <option value="excel">Excel</option>
              <option value="pdf">PDF</option>
          </select>
      </div>
      
      <div class="mb-3 flex text-start">
          <label for="preview" class="form-label"><h6>Preview Data :</h6></label>
          <textarea id="preview" class="form-control" rows="8" readonly></textarea>
      </div>
      
      <button type="button" id="previewBtn" class="btn btn-secondary">Preview Data</button>
      <button type="submit" class="btn btn-primary">Export Data</button>
  </form>
</div>

@endsection

@push('custom-scripts')
<script src="{{ asset('assets/js/export-file.js') }}"></script>
@endpush