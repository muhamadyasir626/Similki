@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('/css/popup.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/import-file.css') }}">
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Lembaga Konservasi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Import File</li>
  </ol>
</nav>

<div class="mb-3 flex text-start col-md-6">
  <label for="data_type" class="form-label"><h6>Mau import data kemana?</h6></label>
  <select id="data_type" name="data_type" class="form-select" required>
      <option value="" disabled selected>Pilih Data</option>
      <option value="lembaga_konservasi">Lembaga Konservasi</option>
      <option value="monitoring_lk">Monitoring LK</option>
      <option value="monitoring_investasi">Monitoring Investasi</option>
      <option value="satwa">Satwa</option>
  </select>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div id="drop-area" class="drop-area">
          <p>Drag and drop a CSV file here or click to select one</p>
          <input type="file" id="fileElem" accept=".csv" style="display:none;">
          <label for="fileElem" class="file-label">Select a file</label>
         </div>
         <h5>Preview Data</h5>
        <div id="preview" class="preview"></div>
        <div class="submit-btn-container">
          <button id="submitFile" class="btn btn-primary submit-btn">Submit File</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('custom-scripts')
<script src="{{ asset('assets\js\import-file.js') }}"></script>
@endpush
