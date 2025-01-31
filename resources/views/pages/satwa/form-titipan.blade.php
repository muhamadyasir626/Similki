@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/form-titipan.css') }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan Satwa Titipan</li>
  </ol>
</nav>

@php
  $update = session('update',false);
 @endphp

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h4> {{ $update ? 'Update' :'Pendataan' }}  Satwa Titipan </h4>
          <div class="input-upload">
            @if (!$update) 
            <button class="btn btn-warning" onclick="upload(this)">Upload</button>
            <button class="btn btn-info">Template Upload</button>
            @endif
          </div>
        </div>
        <form action="{{ $update ? route('satwa-titipan.update', $data->id): route('satwa-titipan.store') }}" enctype="multipart/form-data" method="POST">
          @csrf
          @if ($update)
            @method('PUT')
          @endif
          <section>
            <sub-section>
              <div>
                  {{-- takson --}}
                <input type="hidden" name="id_spesies" id="id_spesies" value="{{$update ? $data->id_spesies: old('id_spesies') }}">
                
                <label for="scientific-name">Scientific Name</label>
                <input type="text" 
                list="list_namaIlmiah" 
                name="nama_ilmiah" 
                id="input_ListSpecies" 
                placeholder="Cari Nama ilmiah Satwa" 
                required
                onblur="validateSelection(this)"
                value="{{ $update ? $data->spesies->nama_ilmiah : old('nama_ilmiah') }}">
                <datalist id="list_namaIlmiah">
                  @foreach($namaIlmiah as $ni)
                  <option value="{{ $ni->nama_ilmiah }}" id="{{ $ni->id }}" title="Tolong dipilih scientific name satwa!"></option>
                  @endforeach
                </datalist>
              </div>
              <div>
                <label for="english-name">English Name</label>
                <input type="text" name="english-name" id="english_name" placeholder="English Name Satwa" value="{{ $update ? $data->spesies->nama_internasional : old('nama_internasional') }}" readonly>
              </div>
              <div>
                <label for="nama-lokal">Nama Lokal</label>
                <input type="text" name="nama-lokal" id="nama_lokal" placeholder="Nama Lokal Satwa" value="{{ $update ? $data->spesies->nama_lokal : old('nama-lokal') }}" readonly>
              </div>
            </sub-section>
            <sub-section class="titipan">
              <div class="titipan">
                <label for="no_bap_titipan">Nomor BAP Titipan</label>
                <input type="text" name="no_bap_titipan" id="no_bap_titipan" placeholder="Masukkan Nomor BAP Titipan"
                value="{{ $update ? $data->no_bap_titipan : old('no_bap_titipan') }}"
                 required>
              </div>
              <div class="titipan">
                <label for="asal_satwa_titipan">Asal Satwa TItipan</label>
                <select name="asal_satwa_titipan" id="asal_satwa_titipan" required>
                  <option value="" selected hidden>Pilih Asal Satwa Titipan</option>
                  @foreach ($asaltitipan as $cara )
                    <option value="{{ $cara->id }}"
                      @if ($update && $data->asal_satwa_titipan == $cara->id)
                        selected
                      @elseif (old('asal_satwa_titipan') == $cara->id) 
                          selected
                      @endif
                      id="{{ $cara->nama }}" >{{ $cara->nama }}</option>
                  @endforeach
                </select>
                <input type="hidden" name="nama_asal_titipan" value="{{ $update ? $data->asal_satwa_titipan :old('nama_asal_titipan') }}">
              </div>
              <div class="lk" id="input_lk" style="display: @if ($update && isset($data->id_lk))
                  block
                  @else
                  none
                @endif">
                <input type="hidden" name="id_lk"  value="{{ $update ? $data->id_lk :old('id_lk') }}">
                <label for="nama_lk_display">Lembaga Konservasi</label>
                <input style="" type="text" list="lk_options" name="nama_lk_display" id="nama_lk_display" placeholder="Cari Lembaga Konservasi" 
                      title="Tolong dipilih Lembaga Konservasi!"
                      onblur="validateSelection(this)" value="{{ $update && $data->id_lk ? $data->lk->nama : old('nama_lk_display')}}">
                <datalist id="lk_options" style="background-color: white;">
                    @foreach($lks as $lk)
                        <option value="{{ $lk->nama }}" id="{{ $lk->id }}"></option>
                    @endforeach
                </datalist>  
              </div>
            </sub-section>
            <sub-section>
              <div>
                <label for="jumlah_jantan">Jumlah Jantan</label>
                <input type="number" name="jumlah_jantan" placeholder="Input Jumlah Satwa Jantan" 
                value="{{ $update ? $data->jumlah_jantan : old('jumlah_jantan') }}"
                required id="jumlah_jantan">
              </div>
              <div>
                <label for="jumlah_betina">Jumlah Betina</label>
                <input type="number" name="jumlah_betina" placeholder="Input Jumlah Satwa Betina" 
                value="{{ $update ? $data->jumlah_betina : old('jumlah_betina') }}"
                required  id="jumlah_betina">
              </div>
              <div>
                <label for="jumlah_unknown">Jumlah Unknown</label>
                <input type="number" name="jumlah_unknown" placeholder="Input Jumlah Satwa Unknown" 
                value="{{ $update ? $data->jumlah_unknown : old('jumlah_unknown') }}"
                required  id="jumlah_unknown">
              </div>
            </sub-section>
          </section>
          <section class="upload_file">
            <label for="doc_bap_titipan">Dokumen BAP Titipan</label>
            @if($update)
                <p>File yang sudah diunggah: 
                    <a href="{{ Storage::url($data->path_bap_titipan) }}" target="_blank">{{ $data->doc_bap_titipan }}</a>
                </p>
            @endif

            
            <input type="file" name="doc_bap_titipan" id="doc_bap_titipan" 
            @if (!$update)
            required
            @endif
            accept="application/pdf">
            
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


@endsection

@push('plugin-scripts') 
  {{-- <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>   --}}
  {{-- <script src="{{ asset('assets/js/form-koleksi-individu.js') }}"></script> --}}
  <script src="{{ asset('assets/js/form-titipan.js') }}"></script>

@endpush

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/form-titipan.js') }}"></script>
@endpush