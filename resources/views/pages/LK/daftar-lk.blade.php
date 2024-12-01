@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Lembaga Konservasi</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Daftar Nama Lembaga Konservasi</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
                <tr>
                    <th >Nama</th>
                    <th>UPT</th>
                    <th>Bentuk Lembaga Konservasi</th>
                    <th style="text-align: center;>">Akreditasi</th>
                    <th style="text-align: center;>">Tahun izin</th>
                    <th style="text-align: center;>">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ListLK as $lk)
                    <tr>
                        <td class="name-column" >{{ $lk->nama }}</td>
                        {{-- <td class="name-column">{{ Str::limit($lk->nama, 30, '...') }}</td> --}}
                        <td>{{ $lk->upt->wilayah}}</td> <!-- Nama UPT melalui relasi, gunakan null check -->
                        <td>{{ $lk->bentuk_lk }}</td>
                        <td style="text-align: center;>">{{ $lk->nilai_akred ?? '-' }}</td>
                        <td style="text-align: center;>">{{ $lk->tahun_izin }}</td>
                        <td style="text-align: center;>">
                          <div class="button-group">
                              <button 
                                  class="btn detail-button" 
                                  id="{{ $lk->id }}" 
                                  data-nama="{{ $lk->nama }}" 
                                  data-upt="{{ $lk->upt->wilayah }}" 
                                  data-bentuk="{{ $lk->bentuk_lk }}" 
                                  data-akreditasi="{{ $lk->nilai_akred ?? '-' }}" 
                                  data-tahun="{{ $lk->tahun_izin }}"
                                  data-alamat=""
                                  data-status=""
                                  data-tahun-izin="">Detail</button>
                      
                              <button 
                                  class="btn btn-danger delete-button" 
                                  id="delete-{{ $lk->id }}" 
                                  data-id="{{ $lk->id }}"
                                  onclick="confirmDelete(this)">Delete</button>
                          </div>
                      </td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Popup Modal for Detail -->
{{-- <div id="detailPopup" class="modal" style="display:none;">
  <div class="modal-content">
      <div class="modal-header">
          <h4>Detail Lembaga Konservasi</h4>
          <span class="close" onclick="closePopup()">&times;</span>
      </div>
      <div id="popupContent"></div>
  </div>
</div> --}}
<!-- Popup Modal for Detail -->
<div id="detailPopup" class="modal" style="display:none;">
  <div class="modal-content">
      <div class="modal-header">
          <h4>Detail Lembaga Konservasi</h4>
          <span class="close" onclick="closePopup()">&times;</span>
      </div>
      <div id="popupContent"></div>
      <button id="editDataButton" class="btn btn-primary" style="display:none;">Edit Data</button>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deletePopup" class="modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Konfirmasi Penghapusan Data</h4>
            <span class="close" onclick="closeDeletePopup()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Anda yakin ingin menghapus data ini?</p>
        </div>
        <div class="modal-footer">
            <button id="confirmDeleteButton" class="btn btn-danger">Hapus</button>
            <button class="btn btn-secondary" onclick="closeDeletePopup()">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <!-- Include your custom scripts -->
  <script src="{{ asset('assets/js/data-table.js') }}"></script>

  <!-- Popup and Delete Logic -->
  <script src="{{ asset('assets/js/popup.js') }}"></script>
  <link rel="stylesheet" href="css/popup.css" />

@endpush