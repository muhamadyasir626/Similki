@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/form-lk.css') }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan Lembaga Konservasi</li>
  </ol>
</nav>

@php
  $update = session('update',false);
 @endphp

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h4> {{ $update ? 'Update' :'Pendataan' }}  Lembaga Konservasi </h4>
          <div class="input-upload">
            @if (!$update) 
            <button class="btn btn-warning" onclick="upload(this)">Upload</button>
            <button class="btn btn-info">Template Upload</button>
            @endif
          </div>
        </div>
        <form action="{{ $update ? route('lk.update', $data->id): route('lk.store') }}" enctype="multipart/form-data" method="POST">
          @if ($update)
            @method('PUT')
          @endif
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <section>
            <sub-section >  
              <div>
                <label for="nama">Nama Calon LK</label>
                <input type="text" name="nama" 
                id="nama" required 
                value="{{ $update ? $data->nama : old('nama') }}"
                placeholder="Masukkan Calon LK">
              </div>
              <div>
                <label for="bentuk_lk">Bentuk LK</label>
                {{-- <select name="bentuk_lk" id="bentuk_lk" required>
                  <option value="" hidden selected>Pilih Bentuk Calon LK</option>
                    @foreach ($bentuk_lk as $bentuk )
                  <option value="{{ $bentuk->id }}"
                    @if($update && $data->bentuk_lk == $bentuk->id)
                    selected
                    @elseif (old('value') == $bentuk->id)
                    selected
                    @endif
                    >{{ $bentuk->nama }}</option>
                  @endforeach
                  <option value="kebun binatang" >Kebun Binatang</option>
                  <option value="museum zoologi" >Museum Zoologi</option>
                  <option value="taman satwa" >Taman Satwa</option>
                  <option value="taman satwa khusus" >Taman Satwa Khusus</option>
                  <option value="taman safari" >Taman Safari</option>
                </select> --}}
                <select name="bentuk_lk" id="bentuk_lk" required>
                  <option value="" hidden selected>Pilih Bentuk Calon LK</option>
                  <option value="kebun binatang" 
                      @if($update && $data->bentuk_lk == 'kebun binatang') selected @elseif(old('bentuk_lk') == 'kebun binatang') selected @endif>
                      Kebun Binatang
                  </option>
                  <option value="museum zoologi" 
                      @if($update && $data->bentuk_lk == 'museum zoologi') selected @elseif(old('bentuk_lk') == 'museum zoologi') selected @endif>
                      Museum Zoologi
                  </option>
                  <option value="taman satwa" 
                      @if($update && $data->bentuk_lk == 'taman satwa') selected @elseif(old('bentuk_lk') == 'taman satwa') selected @endif>
                      Taman Satwa
                  </option>
                  <option value="taman satwa khusus" 
                      @if($update && $data->bentuk_lk == 'taman satwa khusus') selected @elseif(old('bentuk_lk') == 'taman satwa khusus') selected @endif>
                      Taman Satwa Khusus
                  </option>
                  <option value="taman safari" 
                      @if($update && $data->bentuk_lk == 'taman safari') selected @elseif(old('bentuk_lk') == 'taman safari') selected @endif>
                      Taman Safari
                  </option>
              </select>
              
              </div>
                {{-- input wilayah --}}
                @if (Auth::user()->id_upt)
                <input type="hidden" name="id_upt" id="id_upt" value="{{ Auth::user()->id_upt? 'benar':'salah' }}">
                @else
                <div>
                  <label for="id_upt">Wilayah</label>
                  <select name="id_upt" id="id_upt">
                    <option value=""hidden selected>Pilih Wilayah Calon LK</option>
                    @foreach ($listupt as $upt )
                      <option value="{{ $upt->id }}"
                        @if ($update && $data->id_upt == $upt->id)
                          selected
                          @elseif (old('id_upt') == $upt->id)
                          selected
                        @endif
                        >{{ $upt->wilayah }}</option>
                    @endforeach
                  </select>
                </div>
                @endif
            </sub-section>
            <sub-section>
              <div>
                <label for="nama_direktur">Nama Direktur</label>
                <input type="text" name="nama_direktur"
                required id="nama_direktur" 
                value="{{ $update ? $data->nama_direktur : old('nama_direktur') }}"
                placeholder="Masukan Nama Direktur">
              </div>              
            </sub-section>
            <sub-section>
              <div>
                <label for="email">Email</label>
                <input type="email" name="email" 
                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z]+(\.[a-zA-Z]{2,})+" 
                title="Format email tidak valid. Harus memiliki huruf setelah '@' dan diikuti oleh '.'"
                required
                value="{{ $update ? $data->email : old('email') }}"
                placeholder="example@mail.com">
              </div>
              <div class="no_telp">
                <label for="no_telp">Nomor Telepon</label>
                <input type="no_telp" name="no_telp" required oninput='this.value=this.value.replace(/[^0-9]/g,"")' 
                placeholder="628123456789"
                value="{{ $update ? $data->no_telp : old('no_telp') }}"
                pattern="^62[0-9]{9,11}$">
              </div>
            <div class="nib">
              <label for="nib">NIB</label>
              <input type="text" name="nib"
              value="{{ $update ? $data->nib : old('nib') }}"
              id="nib"required placeholder="Masukan NIB"
              oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
              
            </div>
            <div class="npwp">
              <label for="npwp">NPWP</label>
              <input type="text" name="npwp" 
              value="{{ $update ? $data->npwp : old('npwp') }}"
              id="npwp" required placeholder="Masukan NPWP"
              oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
              
            </div>
            </sub-section>
            <sub-section>
              <div>
                <label for="kode_pos">Kode Pos</label>
                  <input type="text" name="kode_pos" id="kodepos" 
                      placeholder="Isi Kode Pos (5 digit)" 
                      required 
                      pattern="^[0-9]{5}$" 
                      title="Hanya boleh angka dan berjumlah 5 digit" 
                      maxlength="5"
                      value="{{ $update ? $data->kode_pos : old('kode_pos') }}"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
              </div>
              <div>
                <label for="provinsi">Provinsi</label>
                <input type="text" name="provinsi"  
                value="{{ $update ? $data->provinsi : old('provinsi') }}"
                required id="provinsi" readonly placeholder="Isi Kode Pos">
              </div>
              <div>
                <label for="kota_kab">Kota/Kabuapten</label>
                <input type="text" name="kota_kab" 
                value="{{ $update ? $data->kota_kab : old('kota_kab') }}"
                required id="kota_kab" readonly placeholder="Isi Kode Pos">
              </div>
              <div>
                <label for="kecamatan">Kecamatan</label>
                <input type="text" name="kecamatan" required 
                value="{{ $update ? $data->kecamatan : old('kecamatan') }}"
                id="kecamatan" readonly placeholder="Isi Kode Pos">
              </div>
              <div>
                <label for="kelurahan">Kelurahan/Desa</label>
                <Select id="kelurahan" class="option-input-kelurahan" name="kelurahan" data-selected="{{$update ? $data->kelurahan : old('kelurahan') }}" required >
                    <option value=""hidden> Pilih Kelurahan/Desa</option>
                  
                  </Select>
              </div>
            </sub-section>
            <sub-section>
              <div>
                <label for="alamat">Alamat Lengkap</label>
                <input type="text" name="alamat"
                value="{{ $update ? $data->alamat : old('alamat') }}"
                id="alamat" required placeholder="Masukan Alamat Lengkap">
              </div>
            </sub-section>
            <sub-section class="jumlah">
              <div>
                <label for="jumlah_investasi">Jumlah Investasi</label>
                <input type="text" name="jumlah_investasi" required
                  value="{{ $update ? $data->jumlah_investasi : old('jumlah_investasi') }}"
                  id="jumlah_investasi" min="0" step="0.01" maxlength="20" placeholder="1.000.000">
              </div>
              <div>
                <label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja</label>
                <input type="text" name="jumlah_tenaga_kerja"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                required
                value="{{ $update ? $data->jumlah_tenaga_kerja : old('jumlah_tenaga_kerja') }}"
                id="jumlah_tenaga_kerja" min="0" placeholder="Masukan Jumlah Tenaga Kerja">
              </div>
              <div>
                <label for="luas_wilayah">Luas Wilayah (Hektar)  </label>
                <input type="number" name="luas_wilayah" 
                value="{{ $update ? $data->luas_wilayah : old('luas_wilayah')}}"
                id="luas_wilayah" step="0.01" min="0" placeholder="Masukan Luas Wilayah (Ha)">
              </div>
            </sub-section>
            <sub-section>
              <div>
                <label for="doc_site_plan">Upload Site Plan </label>
                @if($update)
                <p>File yang sudah diunggah: 
                    <a href="{{ Storage::url($data->path_site_plan) }}" target="_blank">{{ $data->doc_site_plan }}</a>
                </p>
                @endif
                <input type="file" accept="application/pdf" 
                @if (!$update)
                  required
                @endif
                name="doc_site_plan" id="doc_site_plan">
              </div>
              <div>
                <label for="doc_persetujuan_lingkungan">Upload Persetujuan Lingkungan (UKL/Amdal) </label>
                @if($update)
                <p>File yang sudah diunggah: 
                    <a href="{{ Storage::url($data->path_persetujuan_lingkungan) }}" target="_blank">{{ $data->doc_persetujuan_lingkungan }}</a>
                </p>
                @endif
                <input type="file" accept="application/pdf" 
                @if (!$update)
                  required
                @endif
                 name="doc_persetujuan_lingkungan" id="doc_persetujuan_lingkungan">
              </div>
            </sub-section>
            <sub-section>
              <div>
                <label for="doc_draft_rkp">Upload Dokumen Draft RKP </label>
                @if($update)
                <p>File yang sudah diunggah: 
                    <a href="{{ Storage::url($data->path_draft_rkp) }}" target="_blank">{{ $data->doc_draft_rkp }}</a>
                </p>
                @endif
                <input type="file" accept="application/pdf" 
                @if (!$update)
                  required
                @endif
                 name="doc_draft_rkp" id="doc_draft_rkp">
              </div>
              <div>
                <label for="doc_surat_permohonan">Upload Surat Permohonan </label>
                @if($update)
                <p>File yang sudah diunggah: 
                    <a href="{{ Storage::url($data->path_surat_permohonan) }}" target="_blank">{{ $data->doc_surat_permohonan }}</a>
                </p>
                @endif
                <input type="file" accept="application/pdf" 
                @if (!$update)
                  required
                @endif
                 name="doc_surat_permohonan" id="doc_surat_permohonan">
              </div>
            </sub-section>
          </section>

          <section>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            @if ($update)
              <button type="button" id="submit-btn"  class="btn btn-danger" onclick="cancel()">Cancel</button>
            @endif
          </section>

        </form>

      </div>
      </div>
  </div>
</div>
<script>
  function cancel(){
    if(confirm("Apakah ingin membatalkan perubahan?")){
      window.history.back();
      // window.location.href = '/daftar-koleksi-individu';
    }
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js/dist/cleave.min.js"></script>
<script>
    new Cleave('#jumlah_investasi', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        delimiter: '.',
        numeralDecimalMark: ',',
        numeralDecimalScale: 0,
    });
</script>


@endsection

@push('plugin-scripts') 
  {{-- <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>   --}}
  {{-- <script src="{{ asset('assets/js/form-koleksi-individu.js') }}"></script> --}}
  <script src="{{ asset('assets/js/form-lk.js') }}"></script>
  <script src="{{ asset('assets/js/kodepos.js') }}"></script>

@endpush

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/form-titipan.js') }}"></script>
@endpush