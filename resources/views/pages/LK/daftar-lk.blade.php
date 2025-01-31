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
        <h6 class="card-title">Daftar Lembaga Konservasi</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <div class="searchbar">
              <form action="{{ route('lk-search') }}" method="GET" class="mb-4">
                <div class="input-group">
                  <input type="text" name="query" class="form-control" placeholder="Cari Lembaga Konservasi..." value="{{session('query') }}">
                  {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
                </div>
              </form>
            </div>
            <thead>
                <tr>
                  <th style="text-align: center;>">Nama</th>
                  <th style="text-align: center;>">Bentuk LK</th>
                  <th style="text-align: center;>">Alamat</th>
                  <th style="text-align: center;>">Wilayah</th>
                  <th style="text-align: center;>">Jumlah Investasi</th>
                  <th style="text-align: center;>">Jumlah Tenaga Kerja</th>
                  <th style="text-align: center;>">Luas Wilayah</th>
                  <th style="text-align: center;>">Doc Site Plan</th>
                  <th style="text-align: center;>">Doc Persetujuan Lingkungan</th>
                  <th style="text-align: center;>">Doc Permohonan</th>
                  <th style="text-align: center;>">Draft RKP</th>
                  <th style="text-align: center;>">Nama Direktur</th>
                  <th style="text-align: center;>">NIB</th>
                  <th style="text-align: center;>">NPWP</th>
                  <th style="text-align: center;>">Email</th>
                  <th style="text-align: center;>">Nomor Telepon</th>
                  <th style="text-align: center;>">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ListLK as $lk)
                    <tr>
                        <td>{{ Str::limit($lk->nama, 30, '...') }}</td>
                        <td style="text-align: center;>">{{ $lk->bentuk_lk}}</td>
                        <td style="text-align: center;>">{{ $lk->kode_pos }} - {{$lk->alamat }}</td>
                        <td style="text-align: center;>">{{ $lk->upt->wilayah}}</td>
                        <td style="text-align: center;>" >Rp{{ number_format($lk->jumlah_investasi, 0, ',', '.') }}</td>
                        <td style="text-align: center;>" >{{$lk->jumlah_tenaga_kerja }}</td>
                        <td style="text-align: center;>" >{{$lk->luas_wilayah }} Ha</td>
                        <td>{{ $lk->doc_site_plan }} - <a href="{{ Storage::url( $lk->doc_site_plan) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a></td>
                        <td>{{ $lk->doc_persetujuan_lingkungan }} - <a href="{{ Storage::url( $lk->doc_persetujuan_lingkungan) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a></td>
                        <td>{{ $lk->doc_permohonan }} - <a href="{{ Storage::url( $lk->doc_permohonan) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a></td>
                        <td>{{ $lk->doc_draft_rkp }} - <a href="{{ Storage::url( $lk->doc_draft_rkp) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a></td>
                        <td style="text-align: center;>" >{{$lk->nama_direktur }}</td>
                        <td style="text-align: center;>" >{{$lk->nib }}</td>
                        <td style="text-align: center;>" >{{$lk->npwp }}</td>
                        <td style="text-align: center;>" >{{$lk->email }}</td>
                        <td style="text-align: center;"><a href="https://wa.me/{{ preg_replace('/\D/', '', $lk->no_telp) }}" target="_blank">{{ $lk->no_telp }}</a></td>
                        <td> 
                          <button class="btn btn-primary" onclick="window.location.href='{{ route('detail-pengajuan-lk', ['id' => $lk->id, 'status' => $status]) }}'">
                          Detail
                        </button>
                      </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $ListLK->links('pagination::bootstrap-5') }}
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
              <div class="detail-item">
                  <label for="last_update">Terakhir update</label>
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
@endpush