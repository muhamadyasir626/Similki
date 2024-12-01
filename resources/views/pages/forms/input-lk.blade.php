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
        <form class="forms-sample" action="{{ route('lembaga-konservasi.store') }}" method="POST">
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
            <div class="form-alamat-lk row d-flex flex-wrap mb-3">
              <h5 class="mb-2">Alamat</h5>
              <div class="col-md-2">
                <label for="kode-pos" class="form-label">Kode Pos</label>
                <input type="text" class="form-control" id="kode-pos" autocomplete="off" placeholder="kode pos">
              </div>
              <div class="col-md-2">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" autocomplete="off" placeholder="Kecamatan">
              </div>
              <div class="col-md-2">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <input type="text" class="form-control" id="kelurahan" autocomplete="off" placeholder="Kelurahan">
              </div>
              <div class="col-md-2">
                <label for="kabupaten" class="form-label">Kabupaten</label>
                <input type="text" class="form-control" id="kabupaten" autocomplete="off" placeholder="Kabupaten">
              </div>
              <div class="col-md-2">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" autocomplete="off" placeholder="Provinsi">
              </div>
            </div>
            <div class="form-alamat-lengkap-lk">
              <label for="alamat-lengkap-lk"><h5>Alamat lengkap</h5></label>
              <input type="text" class="form-control" id="alamat-lengkap-lk" autocomplete="off" placeholder="Alamat lengkap">
            </div>
            <div class="row d-flex flex-wrap mt-3">
              <div class="form-tahun-izin col-md-4">
                <label for="tahun-izin">Tahun Izin</label>
                <select class="form-control" id="tahun-izin" name="tahun_izin" required>
                    <option value="">Pilih Tahun</option>
                    @for ($year = date('Y'); $year >= 1990; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
              <div class="form-no_izin_peroleh col-md-4">
                <label for="no_izin_peroleh">No Izin Peroleh</label>
                <input type="text" class="form-control" name="" id="no_izin_peroleh" autocomplete="off" placeholder="No Izin Peroleh">
              </div>
              <div class="form-link_sk col-md-4">
                <label for="link_sk">Link SK</label>
                <input type="text" class="form-control" name="" id="link_sk" autocomplete="off" placeholder="Link SK">
              </div>
            </div>
            <div class="row d-flex flex-wrap mt-3">
              <div class="form-legalitas_perizinan col-md-4">
                <label for="legalitas_perizinan">Legalitas Perizinan</label>
                <input type="text" class="form-control" id="legalitas_perizinan" autocomplete="off" placeholder="Legalitas Perizinan">
              </div>
              <div class="form-nomor_tanggal_surat col-md-4">
                <label for="nomor_tanggal_surat">No Tanggal Surat</label>
                <input type="text" class="form-control" name="" id="nomor_tanggal_surat" autocomplete="off" placeholder="No Tanggal Surat">
              </div>
              <div class="form-bentuk_lk col-md-4">
                <label for="bentuk_lk">Bentuk LK</label>
                <input type="text" class="form-control" name="" id="bentuk_lk" autocomplete="off" placeholder="Bentuk LK">
              </div>
            </div>
            <div class="row d-flex flex-wrap mt-3">
              <div class="form-pengelola col-md-4">
                <label for="pengelola">Pengelola</label>
                <input type="text" class="form-control" id="pengelola" autocomplete="off" placeholder="Pengelola">
              </div>
              <div class="form-nama_pimpinan col-md-4">
                <label for="nama_pimpinan">Nama Pimpinan</label>
                <input type="text" class="form-control" name="" id="nama_pimpinan" autocomplete="off" placeholder="Nama Pimpinan">
              </div>
              <div class="form-izin_perolehan_tsl col-md-4">
                <label for="izin_perolehan_tsl">Izin Perolehan TSL</label>
                <input type="text" class="form-control" name="" id="izin_perolehan_tsl" autocomplete="off" placeholder="Izin Perolehan TSL">
              </div>
            </div>
            <div class="row d-flex flex-wrap mt-3">
              <div class="row d-flex flex-wrap mt-3">
                <div class="form-tahun_akreditasi col-md-4">
                  <label for="tahun-akreditasi">Tahun Akreditasi</label>
                  <select class="form-control" id="tahun-akreditasi" name="tahun_akreditasi" autocomplete="off" required>
                      <option value="">Pilih Tahun</option>
                      @for ($year = date('Y'); $year >= 1990; $year--)
                          <option value="{{ $year }}">{{ $year }}</option>
                      @endfor
                  </select>
              </div>
              <div class="form-nilai_akreditasi col-md-4">
                <label for="nilai_akreditasi">Nilai Akreditasi</label>
                <input type="text" class="form-control" name="" id="nilai_akreditasi" autocomplete="off" placeholder="Nilai Akreditasi">
              </div>
              <div class="form-pks_dengan_lk_lain col-md-4">
                <label for="pks_dengan_lk_lain">PKS dengan LK lain</label>
                <input type="text" class="form-control" name="" id="pks_dengan_lk_lain" autocomplete="off" placeholder="PKS dengan LK lain">
              </div>
            </div>
            
          <div class="mt-4" style="display: flex; justify-content:end">
            <button type="submit" class="btn btn-primary me-2" >Submit</button>
            <button class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection

@push('custom-scripts')
<script src="{{ asset('assets/js/input-lk.js') }}"></script>  
@endpush