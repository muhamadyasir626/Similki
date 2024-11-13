@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Input Lembaga Konservasi</li>
  </ol>
</nav>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Input Lembaga Konservasi</h6>
        <form class="forms-sample">
            <div class="row d-flex flex-wrap mb-3">
                <div class="col-md-6 mb-3">
                    <label for="nama_lk" class="form-label">Nama Lembaga Konservasi</label>
                    <input type="text" class="form-control" id="nama_lk" autocomplete="off" placeholder="Isi Nama Lembaga Konservasi">
                </div>
            
                <div class="col-md-6 mb-3">
                    <label for="status_lk" class="form-label">Status LK</label>
                    <div class="dropdown" style="outline: 1px solid #e0e0e0; border-radius:5px;">
                        <button class="btn dropdown-toggle custom-dropdown w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Status LK
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="#">Umum</a>
                            <a class="dropdown-item" href="#">Khusus</a>
                        </div>
                    </div>
                </div>
            </div>
            
          <div style="display: flex; justify-content:end">
            <button type="submit" class="btn btn-primary me-2" >Submit</button>
            <button class="btn btn-secondary">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection

@push('custom-scripts')
<script src="{{ asset('assets/js/input-lk.js') }}"></script>  
@endpush