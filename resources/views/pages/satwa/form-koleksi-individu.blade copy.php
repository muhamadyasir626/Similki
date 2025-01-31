@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/form-koleksi-individu.css') }}">

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
  @include('components.notifikasi-action')
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pendataan Satwa Individu - Koleksi</h4>
        <section>
          {{-- <form id="form-satwa" enctype="multipart/form-data"> --}}
          <form id="form-satwa" enctype="multipart/form-data" method="POST" action="{{ route('store-koleksi-individu') }}">
            @csrf

            {{-- Input Lembaga Konservasi --}}
            <div class="section-input" id="nama_lk">
              <h5 id="title-input">Lembaga Konservasi</h5>
              @if ($user->role && $user->role->tag == 'LK')
                  <input type="hidden" name="nama_lk_display" id="{{ $user->lk->id }}" placeholder="Lembaga Konservasi" 
                         style="width: 400px; padding:10px; background-color:white !important;" value="{{ $user->lk->nama }}" 
                         id="{{ $user->id_lk }}" readonly required>  
              @else
                  <input list="lk_options" name="nama_lk_display" id="nama_lk_display" placeholder="Cari Lembaga Konservasi" 
                         required title="Tolong dipilih Lembaga Konservasi!"
                         onblur="validateSelection(this)">
                  <datalist id="lk_options" style="background-color: white;">
                      @foreach($lks as $lk)
                          <option value="{{ $lk->nama }}" id="{{ $lk->id }}"></option>
                      @endforeach
                  </datalist>         
              @endif
            </div>

            {{-- value input lembaga konservasi --}}
            <input type="hidden" name="id_lk" id="id_lk">
          

            {{-- Input ListSpecies Satwa --}}
            <div  class="section-input" id="title-input">
              {{-- <h5 id="title-input">ListSpecies Hewan</h5> --}}
              <span class="error-message" style="color: red; display: none;"></span>
              <div id="form-ListSpecies">
                <div>
                  <label for="scientific-name">Scientific Name</label>
                  <input 
                    type="text" 
                    list="list_namaIlmiah" 
                    name="nama_ilmiah" 
                    id="input_ListSpecies" 
                    placeholder="Cari Nama ilmiah Satwa" 
                    required
                    onblur="validateSelection(this)"
                  >
                  <datalist id="list_namaIlmiah">
                    @foreach($namaIlmiah as $ni)
                      <option value="{{ $ni->nama_ilmiah }}" id="{{ $ni->id }}" title="Tolong dipilih scientific name satwa!"></option>
                    @endforeach
                  </datalist>

                  {{-- input value id_spesies --}}
                  <input type="hidden" id="id_spesies" name="id_spesies">
                </div>               
                <div>
                  <label for="english-name">English Name</label>
                  <input type="text" name="english-name" id="input_ListSpecies" placeholder="English Name Satwa" readonly>
                </div>
              </div>
              <div id="form-ListSpecies">
                <div>
                  <label for="nama-lokal">Nama Lokal</label>
                  <input type="text" name="nama-lokal" id="input_ListSpecies" placeholder="Nama Lokal Satwa" readonly>
                </div>
                <div>
                  <label for="asal_usul">Asal-Usul Satwa (Silsilah)</label>
                  <input type="text" name="asal_usul" id="input_ListSpecies" placeholder="Pilih Asal-Usul Satwa">               
                </div>  
              </div>
              <div id="form-ListSpesies" class="section-input" >
                <label for="perolehan-satwa-koleksi">Cara Perolehan Satwa Koleksi</label>
                <select name="cara_perolehan_koleksi" class="perolehan_satwa_koleksi" id="input_ListSpecies" required>
                  <option value="" hidden selected>Pilih Cara Perolehan Satwa Koleksi</option>
                  @foreach ($perolehanKoleksiIndividu as $cara)
                  <option value="{{ $cara->id }}"  >{{ $cara->nama }}</option>
                  @endforeach
                </select> 
              </div>
            </div> 
            
            {{-- Input Upload dokumen asal usul satwa (silsilah) --}}
            <div  class="section-input" id="upload_dokumen">
              <div>
                <h5 id="title-input">Upload Dokumen Asal Usul Satwa (Silsilah)</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input type="file" id="doc_asal_usul" name="doc_asal_usul" class="upload_file" accept=".pdf"> 
              </div>
              <div>
                <h5 id="title-input">Upload Dokumen BAP Kelahiran</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input type="file" id="doc_bap_kelahiran" name="doc_bap_kelahiran" class="upload_file" accept=".pdf">
              </div>
            </div>

            
            <div id="nama_panggilan">
              <h5 id="title-input">Nama Panggilan</h5>
              <input type="text" class="nama_panggilan" id="input_ListSpecies" name="nama_panggilan" placeholder="Nama Panggilan Satwa">
            </div>
            {{-- input jenis kelamin satwa --}}
            <div class="section-input" id="jenis_kelamin">
              <h5 id="title-input">Jenis Kelamin</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="input-radio">
                <input type="radio" name="jenis_kelamin" id="jantan" value="1" required title="Tolong pilih jenis kelamin satwa!" >
                <label for="jantan" class="jenis-kelamin">Jantan</label>
              </div>
              <div class="input-radio">
                <input type="radio" name="jenis_kelamin" id="betina" value="0" required title="Tolong Pilih jenis kelamin satwa!">
                <label for="betina"class="jenis-kelamin" >Betina</label>
              </div>
            </div>

            {{-- Tagging --}}
            <div class="section-input" id="tagging">
              <div>
                <h5 id="title-input">Jenis/Bentuk Tagging</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <select name="bentuk_tagging" id="jenis_tagging"  required title="Tolong pilih jenis/bentuk tagging satwa!">
                  <option value="" hidden selected>Pilih Jenis Tagging</option>
                  @foreach ($tagging as $tag)
                  <option value="{{ $tag->id }}" >{{ $tag->jenis_tagging }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <h5 id="title-input">Kode Tagging</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input type="text" name="kode_tagging" id="kode-tagging" placeholder="Masukan Kode Tagging" required title="Tolong isi kode tagging satwa!">
              </div>
            </div>

            {{-- Input Umur --}}
            <div class="section-input" id="tempat-tanggal-lahir">
              <div>
                <h5 id="title-input">Umur Satwa</h5>
                <input type="number" id="umur" name="umur" placeholder="Umur Satwa" required title="Tolong diisi umur satwa!">
              </div>
              <div>
                <h5 id="title-input">Tanggal Lahir <span class="keterangan">(Opsional)</span></h5>
                <input type="text" name="tanggal_lahir" id="tanggal-lahir" placeholder="dd/mm/yyyy">
              </div>
              
            </div>

            {{-- Asal Satwa --}}
            <div class="section-input" id="asal-satwa">
              <div>
                <h5 id="title-input">Asal Satwa</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <div class="input-radio">
                  <input type="radio" name="asal_satwa" id="indonesia" value="1" required title="Tolong diisi asal satwa!">
                  <label for="indonesia" class="asal-satwa">Satwa Indonesia</label>
                </div>
                <div class="input-radio">
                  <input type="radio" name="asal_satwa" id="asing" value="0" required title="Tolong diisi asal satwa!">
                  <label for="asing" class="asal-satwa">Satwa Asing</label>
                </div>
              </div>
              <div>
                <h5 id="title-input">Status Satwa</h5>
                <div class="input-radio">
                  <input type="radio" name="status_perlindungan_satwa" id="dilindungi" value="1" required title="Tolong diisi status satwa!">
                  <label for="dilindungi" class="status-satwa">Dilindungi</label>
                </div>
                <div class="input-radio">
                  <input type="radio" name="status_perlindungan_satwa" id="tidak-dilindungi" value="0" required title="Tolong diisi status satwa!">
                  <label for="tidak-dilindungi" class="status-satwa">Tidak Dilindungi</label>
                </div>
              </div>
              <div id="sk-dirjen" style="display: none;">
                <h5 class="title-input">SK Peroleh Koleksi Dirjen</h5>
                <input type="text" id="sk-dirjen-input" name="sk_perolehan_koleksi_dirjen" placeholder="Tolong diisikan nomor SK">
              </div>
              <div id="sk-kepala-balai" style="display: none;">
                <h5 class="title-input">SK Peroleh Koleksi Kepala Balai</h5>
                <input type="text" id="sk-kepala-balai-input" name="sk_perolehan_koleksi_kepala_balai" placeholder="Tolong diisikan nomor SK">
              </div>
              
            <button type="submit" id="submit-btn" style="display: inline-block;" class="btn btn-primary">Simpan Data Satwa</button>
              
          </form>
        </section>

      </div>
      </div>
  </div>
</div>


@endsection

@push('plugin-scripts') 
  {{-- <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>   --}}
@endpush

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/form-koleksi-individu.js') }}"></script>
  {{-- <script src="{{ asset('assets/js/pendataan-satwa.js') }}"></script>   --}}
  {{-- <script src="{{ asset('assets/js/wizard.js') }}"></script>   --}}
@endpush