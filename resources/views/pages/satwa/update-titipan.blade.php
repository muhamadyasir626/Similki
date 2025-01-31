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
    <li class="breadcrumb-item active" aria-current="page">Pendataan Satwa Koleksi (individu)</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h4>Update Satwa Titipan </h4>
          <div class="input-upload">
            <button class="btn btn-warning" onclick="upload(this)">Upload</button>
            <button class="btn btn-info">Template Upload</button>
          </div>
        </div>
        <form action="{{ route('satwa-titipan.store') }}" enctype="multipart/form-data" method="POST">
          <section>
            <sub-section>
              <div>
                  {{-- takson --}}
                <input type="hidden" name="id_spesies" id="id_spesies" value="{{ old('id_spesies') }}">
                
                <label for="scientific-name">Scientific Name</label>
                <input type="text" 
                list="list_namaIlmiah" 
                name="nama_ilmiah" 
                id="input_ListSpecies" 
                placeholder="Cari Nama ilmiah Satwa" 
                required
                onblur="validateSelection(this)"
                value="{{ old('nama_ilmiah') }}">
                <datalist id="list_namaIlmiah">
                  @foreach($namaIlmiah as $ni)
                  <option value="{{ $ni->nama_ilmiah }}" id="{{ $ni->id }}" title="Tolong dipilih scientific name satwa!"></option>
                  @endforeach
                </datalist>
              </div>
              <div>
                <label for="english-name">English Name</label>
                <input type="text" name="english-name" id="english_name" placeholder="English Name Satwa" value="{{ old('nama_internasional') }}" readonly>
              </div>
              <div>
                <label for="nama-lokal">Nama Lokal</label>
                <input type="text" name="nama-lokal" id="nama_lokal" placeholder="Nama Lokal Satwa" value="{{ old('nama-lokal') }}" readonly>
              </div>
            </sub-section>
            <sub-section class="titipan">
              <div class="titipan">
                <label for="no_bap_titipan">Nomor BAP Titipan</label>
                <input type="text" name="no_bap_titipan" id="no_bap_titipan" placeholder="Masukkan Nomor BAP Titipan" required>
              </div>
              <div class="titipan">
                <label for="asal_satwa_titipan">Asal Satwa TItipan</label>
                <select name="asal_satwa_titipan" id="asal_satwa_titipan" required>
                  <option value="" selected hidden>Pilih Asal Satwa Titipan</option>
                  @foreach ($asaltitipan as $cara )
                    <option value="{{ $cara->id }}" id="{{ $cara->nama }}" >{{ $cara->nama }}</option>
                  @endforeach
                </select>
                <input type="hidden" name="nama_asal_titipan">
              </div>
              <div class="lk" id="input_lk" style="display: none">
                <input type="hidden" name="id_lk"  value="{{ old('id_lk') }}">

                <label for="nama_lk_display">Lembaga Konservasi</label>
                <input style="" type="text" list="lk_options" name="nama_lk_display" id="nama_lk_display" placeholder="Cari Lembaga Konservasi" 
                      title="Tolong dipilih Lembaga Konservasi!"
                      onblur="validateSelection(this)" value="{{ old('nama_lk_display')}}">
                <datalist id="lk_options" style="background-color: white;">
                    @foreach($lks as $lk)
                        <option value="{{ $lk->nama }}" id="{{ $lk->id }}">
                    </option>
                    @endforeach
                </datalist>  
              </div>
            </sub-section>
            <sub-section>
              <div>
                <label for="jumlah_jantan">Jumlah Jantan</label>
                <input type="number" name="jumlah_jantan" placeholder="Input Jumlah Satwa Jantan" required id="jumlah_jantan">
              </div>
              <div>
                <label for="jumlah_betina">Jumlah Betina</label>
                <input type="number" name="jumlah_betina" placeholder="Input Jumlah Satwa Betina" required  id="jumlah_betina">
              </div>
              <div>
                <label for="jumlah_unknown">Jumlah Unknown</label>
                <input type="number" name="jumlah_unknown" placeholder="Input Jumlah Satwa Unknown" required  id="jumlah_unknown">
              </div>
            </sub-section>
          </section>
          <section class="upload_file">
            <label for="doc_bap_titipan">Dokumen BAP Titipan</label>
            <input type="file" name="doc_bap_titipan" id="doc_bap_titipan" required>
          </section>

          <section>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
          </section>

        </form>

      </div>
      </div>
  </div>
</div>


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