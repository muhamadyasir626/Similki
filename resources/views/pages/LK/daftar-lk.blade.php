@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('/css/popup.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('components.notifikasi-action')
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
                    <th>Nama</th>
                    <th>UPT</th>
                    <th>Bentuk Lembaga Konservasi</th>
                    <th style="text-align: center;>">Akreditasi</th>
                    <th style="text-align: center;>">Tahun izin</th>
                    <th style="text-align: center;>">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ListLK as $lk)
                    <tr data-id="{{ $lk->id }}">
                        <td class="nama">{{ Str::limit($lk->nama, 30, '...') }}</td>
                        <td class="upt">{{ $lk->upt->wilayah}}</td> <!-- Nama UPT melalui relasi, gunakan null check -->
                        <td class="bentuk_lk">{{ $lk->bentuk_lk }}</td>
                        <td class="nilai_akred" style="text-align: center;">{{ !empty($lk->nilai_akred) ? $lk->nilai_akred : '-' }}</td>
                        <td class="tahun_izin" style="text-align: center;">{{ !empty($lk->tahun_izin) ? $lk->tahun_izin : '-' }}</td>                                               
                        <td style="text-align: center;>">
                          <button 
                            class="btn btn-success detail-button" 
                            id="{{ $lk->id }}" 
                            data-nama="{{ $lk->nama }}" 
                            data-upt="{{ $lk->upt->wilayah}}" 
                            data-bentuk="{{ $lk->bentuk_lk}}" 
                            data-akreditasi="{{ !empty($lk->nilai_akred) ? $lk->nilai_akred : '-' }}" 
                            data-tahun_akred="{{ !empty($lk->tahun_akred) ? $lk->tahun_akred : '-' }}" 
                            data-pengelola="{{ !empty($lk->pengelola) ? $lk->pengelola : '-' }}" 
                            data-nama_pimpinan="{{ !empty($lk->nama_pimpinan) ? $lk->nama_pimpinan : '-' }}" 
                            data-tahun="{{ !empty($lk->tahun_izin) ? $lk->tahun_izin : '-' }}" 
                            data-legalitas_perizinan="{{ !empty($lk->legalitas_perizinan) ? $lk->legalitas_perizinan : '-' }}" 
                            data-link_sk="{{ !empty($lk->link_sk) ? $lk->link_sk : '-' }}" 
                            data-nomor_tanggal_surat="{{ !empty($lk->nomor_tanggal_surat) ? $lk->nomor_tanggal_surat : '-' }}" 
                            data-pks_dengan_lk_lainnya="{{ !empty($lk->pks_dengan_lk_lainnya) ? $lk->pks_dengan_lk_lainnya : '-' }}" 
                            data-izin_perolehan_tsl="{{ !empty($lk->izin_perolehan_tsl) ? $lk->izin_perolehan_tsl : '-' }}" 
                            data-alamat="{{ !empty($lk->alamat) ? $lk->alamat : '-' }}"
                          >Detail</button>
            
                        <button 
                            class="btn btn-danger delete-button" 
                            id="delete-{{ $lk->id }}" 
                            data-id="{{ $lk->id }}"
                            onclick="confirmDelete(this)">Delete</button>
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
<!-- Popup Modal -->
<div id="detailPopup" class="modal" style="display:none;">
  <div class="modal-container">
      <div class="popup-header">
          <h4>Detail Lembaga Konservasi</h4>

            <div class="action-popup" style="gap: 10px;">
              <button class="btn btn-popup btn-danger edit-button" id="edit-button" onclick="openEditForm()" value=""> Edit</button>
              <button class="btn btn-popup btn-secondary close" id="close-button" onclick="closePopup()">Close</button>
              <button class="btn btn-popup btn-success submit-btn" id="submit-button" onclick="submitForm()" style="display: none">Submit</button>
              <button class="btn btn-popup btn-secondary cancel-btn" id="cancel-button" onclick="cancelEditForm()" style="display: none">Cancel</button>
            </div>
      </div>
      
          <div id="popupContent">

              <div class="detail-item">
                  <label for="nama">Nama</label>
                  <input type="text" id="nama" value="" disabled/>
              </div>
              <div class="detail-item">
                  <label for="upt">UPT</label>
                  <input type="text" id="upt" value="" disabled/>
              </div>
              <div class="detail-item">
                  <label for="bentuk_lembaga">Bentuk Lembaga</label>
                  <input type="text" id="bentuk_lembaga" value="" disabled/>
              </div>
              <div class="detail-item">
                  <label for="nama_pimpinan">Nama Pimpinan</label>
                  <input type="text" id="nama_pimpinan" value="" disabled/>
              </div>
              <div class="detail-item">
                  <label for="akreditasi">Akreditasi</label>
                  <span class="" id="badges-akreditasi"></span>
                  <input type="text" id="akreditasi" value="" disabled style="display: none"/>
              </div>
              <div class="detail-item">
                  <label for="akreditasi">Tahun Akreditas</label>
                  <input type="text" id="tahun_akred" value="" disabled />
              </div>
              <div class="detail-item">
                  <label for="tahun_izin">Tahun Izin</label>
                  <input type="text" id="tahun_izin" value="" disabled/>
              </div>
              <div class="detail-item">
                  <label for="pengelola">Pengelola</label>
                  <input type="text" id="pengelola" value="" disabled/>
              </div>
              <div class="detail-item">
                <label for="sk">SK</label>
                <a href="" id="link_sk"></a>
                <input type="url" id="input_sk" value="" disabled style="display: none"/>
              </div>
              <div class="detail-item">
                  <label for="alamat">Alamat</label>
                  <textarea type="text" rows="2" cols="500"id="alamat" value="" disabled></textarea>
              </div>
              <div class="detail-item">
                  <label for="legalitas_perizinan">Legalitas Perizinan</label>
                  <textarea type="text" id="legalitas_perizinan" value="" disabled></textarea>
              </div>
              <div class="detail-item">
                  <label for="nomor_tanggal_surat">Nomor Tanggal Surat</label>
                  <input type="text" id="nomor_tanggal_surat" value="" disabled></textarea>
              </div>
              <div class="detail-item">
                  <label for="izin_tsl">Izin TSL</label>
                  <textarea type="text" rows="5" cols="500" id="izin_tsl" value="" disabled></textarea>
              </div>
              <div class="detail-item">
                  <label for="perjanjian_kerja_sama">Perjanjian Kerja Sama</label>
                  <textarea id="pks" rows="10" cols="500" disabled></textarea>
              </div>
        </div>
  </div>
</div>



<!-- Delete Confirmation Modal -->
<div id="deletePopup" class="modal" style="display:none;">
    <div class="modal-container">
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
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/popup.js') }}"></script>
@endpush