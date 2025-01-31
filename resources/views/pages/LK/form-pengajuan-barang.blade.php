@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
<link href="{{ asset('css/form-persetujuan.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('components.notifikasi-action')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Persetujuan Pembebasan BEA {{ $update?? '- Update' }}</li>
  </ol>
</nav>

@php
  $update = session('update',false);
 @endphp

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h1 class="card-title">Persetujuan Pembebasan BEA untuk Barang Konservasi {{ $update? '- Update' : '' }}</h4>
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          
          <form method="POST" class="form" enctype="multipart/form-data" action="{{ $update ? route('barang-konservasi.update', $data->id) : route('barang-konservasi.store', Auth::user()->id_lk) }}">
          {{-- <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('barang-konservasi.store',1) }}"> --}}
            @csrf
              @if ($update)
                @method('PUT')
              @endif
             <div class="col-mb-6" style="max-width: 50%">
              <label for="jenis_barang">Jenis Barang</label>
              <select id="jenis_barang" name="jenis_barang" class="form-control" required>
                <option value="" hidden selected>Pilih Jenis Barang</option>
                @foreach($listjenisbarang as $item)
                  <option value="{{ $item->id }}" 
                    @if ($update && $data->jenis_barang == $item->id)
                    selected
                  @elseif (old('jenis_barang') == $item->id) 
                      selected
                  @endif
                    >{{ $item->nama }}</option>
                @endforeach
              </select>
            </div> 

            <!-- Nama Barang & Jumlah Barang -->
            <div class="form-group  mb-3">
              <div class="col-md-6">
                <label for="nama">Nama Barang</label>
                <input type="text" class="form-control" 
                value="{{ $update ? $data->nama : old('nama') }}"
                id="nama_barang" name="nama" placeholder="Masukkan nama barang" required>
              </div>

              <div class="col-md-6">
                <label for="jumlah">Jumlah Barang</label>
                <input type="number" class="form-control" 
                value="{{ $update ? $data->jumlah : old('jumlah') }}"
                id="jumlah_barang" name="jumlah" placeholder="Masukkan jumlah barang" min="1" required>
              </div>
            </div>
  
            <!-- Negara Asal -->
            <div class="form-group mb-3">
              <div class="col-md-6">
                <label for="negara">Negara Asal</label>
                <select id="negara" name="negara_asal" class="form-control" data-selected ="{{ $update?$data->negara_asal : old('negara_asal') }}" required>
                  <option value="" selected hidden>Pilih Negara</option>
                </select>
              </div>
            </div>
  
            <!-- Perkiraan Nilai Pabean -->
            <div class="form-group mb-3">
              <label for="nilaiPabean">Perkiraan Nilai Pabean</label>
              <div class="input-group" style="max-width: 50% !important">
                <div class="input-group-prepend" >
                  <span class="input-group-text" id="format-uang">Rp</span>
                </div>
                <input type="string" 
                class="form-control" id="nilaiPabean" name="perkiraan_nilai"
                min="0" step="0.01" maxlength="20"
                placeholder="Masukkan Nilai Pabean" 
                value="{{ $update ? $data->perkiraan_nilai : old('perkiraan_nilai') }}" required>
              </div>
            </div>
  
            <!-- Pelabuhan Masuk -->
            <div class="form-group mb-3" style="max-width: 50%">
              <label for="namaPelabuhan">Pelabuhan Masuk</label>
              <small id="pelabuhanError" class="text-danger" style="display: none;">Pilih pelabuhan yang sesuai dari daftar.</small>
              <input type="text"
              value="{{ $update? $data->pelabuhan_masuk : old('pelabuhan_masuk') }}"
               name="pelabuhan_masuk"  
               id="namaPelabuhanInput" 
               list="namaPelabuhanList" 
               class="form-control" placeholder="Cari pelabuhan..." required />
              <datalist id="namaPelabuhanList"></datalist>
            </div>
  
            <!-- Upload Surat -->
            <div class="form-group row mb-3" style="width: 100%">
              <div class="col-md-6">
                  <label for="surat_permohonan">Upload Surat Permohonan</label>
                  @if($update)
                      <p>File yang sudah diunggah: 
                          <a href="{{ Storage::url($data->path_surat_permohonan) }}" target="_blank">{{ $data->doc_surat_permohonan }}</a>
                      </p>
                  @endif
                  <input type="file" accept="application/pdf" class="form-control" id="surat_permohonan" name="doc_surat_permohonan" 
                      accept=".pdf"
                      @if (!$update)
                      required                      
                      @endif
                      @if(session('doc_surat_permohonan') && !$update) 
                      value="{{ session('doc_surat_permohonan') }}"
                      @endif>
                  
                      @error('doc_surat_permohonan')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="surat_pernyataan">Upload Surat Pernyataan untuk Konservasi</label>
                  @if($update)
                      <p>File yang sudah diunggah: 
                          <a href="{{ Storage::url($data->path_surat_pernyataan) }}" target="_blank">{{ $data->doc_surat_pernyataan}}</a>
                      </p>
                  @endif
                  <input type="file" accept="application/pdf" class="form-control" id="surat_pernyataan" name="doc_surat_pernyataan" 
                      accept=".pdf" 
                      @if (!$update)
                      required                      
                      @endif
                      @if(session('doc_surat_pernyataan') && !$update) 
                      value="{{ session('doc_surat_pernyataan') }}"
                      @endif>
                  @error('doc_surat_pernyataan')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          </div>
          
  
            <!-- Submit Button -->
            <div class="form-group text-right" style="width:fit-content; display:flex; flex-direction:row">
              <button type="submit" class="btn btn-primary">{{$update ? 'Simpan Perubahan' : 'Ajukan Permohonan' }}</button>
              @if ($update)
              <button type="button" id="submit-btn"  class="btn btn-danger" onclick="cancel()">Cancel</button>
            @endif
            </div>
          </form>
        
      </div>
    </div>
  </div>
</div>

<!-- Menyertakan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js/dist/cleave.min.js"></script>
<script src="{{ asset('/assets/js/pelabuhan-indonesia.js') }}"></script>
<script>

function cancel(){
    if(confirm("Apakah ingin membatalkan perubahan?")){
      window.history.back();
      // window.location.href = '/daftar-koleksi-individu';
    }
  }

new Cleave('#nilaiPabean', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        delimiter: '.',
        numeralDecimalMark: ',',
        numeralDecimalScale: 0,
    });

    async function loadCountries() {
  try {
    const response = await fetch('https://restcountries.com/v3.1/all');
    const countries = await response.json();

    const sortedCountries = countries.sort((a, b) => {
      const nameA = a.name.common.toUpperCase();
      const nameB = b.name.common.toUpperCase();
      return nameA < nameB ? -1 : nameA > nameB ? 1 : 0;
    });

    const negaraSelect = document.getElementById('negara');
    const selectedValue = negaraSelect.dataset.selected; // Mendapatkan nilai negara yang dipilih

    sortedCountries.forEach((country) => {
      const option = document.createElement('option');
      option.value = country.name.common;
      option.textContent = country.name.common;

      // Menambahkan kondisi untuk memilih negara yang sesuai dengan selectedValue
      if (country.name.common === selectedValue) {
        option.selected = true; // Menandakan bahwa negara tersebut dipilih
      }

      negaraSelect.appendChild(option);
    });
  } catch (error) {
    console.error("Error fetching countries:", error);
  }
}

loadCountries();


loadCountries();

</script>

@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
  
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard-4.js') }}"></script>    
@endpush