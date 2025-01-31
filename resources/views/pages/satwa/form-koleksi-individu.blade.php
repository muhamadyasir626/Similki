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
  <div class="col-md-12 grid-margin stretch-card">
    @include('components.notifikasi-action')
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h4>Pendataan Satwa Individu - Koleksi</h4>
          <div>
            <button class="btn btn-warning" onclick="upload(this)">Upload</button>
            <button class="btn btn-info">Template Upload</button>
          </div>
        </div>
        <form id="form-satwa" enctype="multipart/form-data" method="POST" action="{{ route('satwa-koleksi.store') }}">
          <div class="form">
            <section>
                @csrf
                <div class="sub-section">
                      {{-- Input Lembaga Konservasi --}}
                  <div class="section-input" id="nama_lk">
                    <h5 id="title-input">Lembaga Konservasi</h5>
                    @if ($user->role && $user->role->tag == 'LK')
                        <input type="text" name="nama_lk_display" placeholder="Lembaga Konservasi" 
                               value="{{$user->lk->nama }}" 
                              id="{{ $user->id_lk }}" readonly required>  
                    @else
                        <input type="text" list="lk_options" name="nama_lk_display" id="nama_lk_display" placeholder="Cari Lembaga Konservasi" 
                              required title="Tolong dipilih Lembaga Konservasi!"
                              onblur="validateSelection(this)" value="{{ old('nama_lk_display')}}">
                        <datalist id="lk_options" style="background-color: white;">
                            @foreach($lks as $lk)
                                <option value="{{ $lk->nama }}" id="{{ $lk->id }}">
                            </option>
                            @endforeach
                        </datalist>  
                        @error('id_lk')
                          <div class="text-danger"  style="color: red;">{{ $message }}</div>
                        @enderror       
                    @endif
                    {{-- value input lembaga konservasi --}}
                    <input type="hidden" name="id_lk" id="id_lk" value="{{ old('id_lk')}}">
                  </div>
                    {{-- Input ListSpecies Satwa --}}
                  <div class="section-input" >
                    {{-- <span class="error-message" style="color: red; display: none;"></span> --}}
                    <div id="form-ListSpecies">
                      <div class="input-spesies">
                        <label for="scientific-name">Scientific Name</label>
                        <input type="text" 
                          list="list_namaIlmiah" 
                          name="nama_ilmiah" 
                          id="input_ListSpecies" 
                          placeholder="Cari Nama ilmiah Satwa" 
                          required
                          onblur="validateSelection(this)"
                          value="{{ old('nama_ilmiah') }}"
                        >
                        <datalist id="list_namaIlmiah">
                          @foreach($namaIlmiah as $ni)
                            <option value="{{ $ni->nama_ilmiah }}" id="{{ $ni->id }}" title="Tolong dipilih scientific name satwa!"></option>
                          @endforeach
                        </datalist>
                        @error('nama_ilmiah')
                          <div class="text-danger"  style="color: red;">{{ $message }}</div>
                        @enderror  
                        {{-- input value id_spesies --}}
                        <input type="hidden" id="id_spesies" name="id_spesies" value="{{ old('id_spesies') }}">
                      </div>               
                      <div class ="input-spesies">
                        <label for="english-name">English Name</label>
                        <input type="text" name="english-name" id="input_ListSpecies" placeholder="English Name Satwa" value="{{ old('english-name') }}" readonly>
                        @error('nama_internasional')
                        <div class="text-danger"  style="color: red;">{{ $message }}</div>
                        @enderror 
                      </div>
                    </div>

                    <div id="form-ListSpecies">
                      <div class="input-spesies">
                        <label for="nama-lokal">Nama Lokal</label>
                        <input type="text" name="nama-lokal" id="input_ListSpecies" placeholder="Nama Lokal Satwa" value="{{ old('nama-lokal') }}" readonly>
                        @error('nama_lokal')
                        <div class="text-danger"  style="color: red;">{{ $message }}</div>
                        @enderror 
                      </div>
                      <div class="input-spesies">
                        <label for="asal_usul">Asal-Usul Satwa (Silsilah)</label>
                        <input type="text" name="asal_usul" id="input_ListSpecies" placeholder="Pilih Asal-Usul Satwa" value="{{ old('asal-usul') }}">               
                        @error('asal_usul')
                        <div class="text-danger"  style="color: red;">{{ $message }}</div>
                        @enderror   
                      </div>  
                    </div>
                  </div>
                </div>

                <div class="sub-section">
                  <div class="section-input">
                    <label for="perolehan-satwa-koleksi">Cara Perolehan Satwa Koleksi</label>
                    <select name="cara_perolehan_koleksi" class="perolehan_satwa_koleksi" id="input_ListSpecies" required>
                      <option value="" hidden selected>Pilih Cara Perolehan Satwa Koleksi</option>
                      @foreach ($perolehanKoleksiIndividu as $cara)
                      <option value="{{ $cara->id }}" 
                        @if (old('cara_perolehan_koleksi') == $cara->id) selected @endif>
                        {{ $cara->nama }}</option>
                      @endforeach
                    </select>
                    @error('cara_perolehan_koleksi')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror 
                  </div>
                    <div class="section-input">
                      <h5 id="title-input">Upload Dokumen Asal Usul Satwa (Silsilah)</h5>
                      {{-- <span class="error-message" style="color: red; display: none;"></span> --}}
                      <input type="file" id="doc_asal_usul" name="doc_asal_usul" class="upload_file" required  accept=".pdf"> 
                      @error('doc_asal_usul')
                      <div class="text-danger"  style="color: red;">{{ $message }}</div>
                      @enderror 
                    </div>
                    <div class="section-input">
                      <h5 id="title-input">Upload Dokumen BAP Kelahiran</h5>
                      {{-- <span class="error-message" style="color: red; display: none;"></span> --}}
                      <input type="file" id="doc_bap_kelahiran" name="doc_bap_kelahiran" class="upload_file" required  accept=".pdf">
                      @error('doc_bap_kelahiran')
                      <div class="text-danger"  style="color: red;">{{ $message }}</div>
                      @enderror 
                    </div>
                </div>
            </section>
          </div>

          <div class="form">
            <section >
              <div class="sub-section">
                <div class="section-input" id="nama_panggilan">
                  <h5 id="title-input">Nama Panggilan</h5>
                  <input type="text" class="nama_panggilan" id="input_ListSpecies" name="nama_panggilan" placeholder="Nama Panggilan Satwa" value="{{ old('nama_panggilan') }}">
                  @error('nama_panggilan')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="section-input" id="jenis_kelamin">
                  <h5 id="title-input">Jenis Kelamin</h5>
                    @error('jenis_kelamin')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                  <div class="input-radio">
                    <input type="radio" class="jenis_kelamin" name="jenis_kelamin" id="jantan" value="1" {{ old('jenis_kelamin') == '1'? 'checked':'' }} required title="Tolong pilih jenis kelamin satwa!" >
                    <label for="jantan" class="jenis-kelamin">Jantan</label>
                  </div>
                  <div class="input-radio">
                    <input type="radio" class="jenis_kelamin" name="jenis_kelamin" id="betina" value="0" {{ old('jenis_kelamin') == '0'? 'checked':'' }} required title="Tolong Pilih jenis kelamin satwa!">
                    <label for="betina"class="jenis-kelamin" >Betina</label>
                  </div>
                </div>
              </div>

              <div class="sub-section">
                <div class="section-input" id="tagging">
                  <div id="form-ListSpecies">
                    <div class="input-spesies">
                      <h5 id="title-input">Jenis/Bentuk Tagging</h5>
                      @error('bentuk_tagging')
                      <div class="text-danger"  style="color: red;">{{ $message }}</div>
                      @enderror
                      {{-- <span class="error-message" style="color: red; display: none;"></span> --}}
                      <select name="bentuk_tagging" id="jenis_tagging"  required title="Tolong pilih jenis/bentuk tagging satwa!">
                        <option value="" hidden selected>Pilih Jenis Tagging</option>
                        @foreach ($tagging as $tag)
                        <option value="{{ $tag->id }}"
                          @if (old('bentuk_tagging') == $tag->id) selected @endif >{{ $tag->jenis_tagging }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="input-spesies">
                      <h5 id="title-input">Kode Tagging</h5>
                      @error('kode_tagging')
                      <div class="text-danger"  style="color: red;">{{ $message }}</div>
                      @enderror
                      {{-- <span class="error-message" style="color: red; display: none;"></span> --}}
                      <input type="text" name="kode_tagging" id="kode-tagging" placeholder="Masukan Kode Tagging" required  value="{{ old('kode_tagging') }}" title="Tolong isi kode tagging satwa!">   
                    </div>  
                  </div>
                  <div id="form-ListSpecies">
                    <div class="input-spesies">
                      <h5 id="title-input">Umur Satwa</h5>
                      @error('umur')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                      <input type="number" id="umur" name="umur" placeholder="Umur Satwa" value="{{ old('umur') }}" required title="Tolong diisi umur satwa!">
                    </div>
                    <div class="input-spesies">
                      <h5 id="title-input">Tanggal Lahir <span class="keterangan">(Opsional)</span></h5>
                      @error('tanggal_lahir')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                      <input type="text" name="tanggal_lahir" id="tanggal-lahir" value="{{ old('tanggal_lahir') }}" placeholder="dd/mm/yyyy">             
                    </div>  
                  </div>
                </div>
              </div>

              <div class="sub-section3">
                <div class="section-input">
                  <div>
                    <h5 id="title-input">Asal Satwa</h5>
                    @error('asal_satwa')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                    {{-- <span class="error-message" style="color: red; display: none;"></span> --}}
                    <div class="input-radio">
                      <input type="radio" class="asal_satwa" name="asal_satwa" id="indonesia" value="1" {{ old('asal_satwa') == '1'?'checked' : '' }} required>
                      <label for="indonesia">Satwa Indonesia</label>
                    </div>
                    <div class="input-radio">
                      <input type="radio" class="asal_satwa" name="asal_satwa" id="asing" value="0" {{ old('asal_satwa') == '0'?'checked':''}} required>
                      <label for="asing">Satwa Asing</label>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="sub-section3">
                <div class="section-input">
                  <div>
                    <h5 id="title-input">Status Satwa</h5>
                    @error('status_perlindungan_satwa')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                    <div class="input-radio">
                      <input type="radio" class="status_perlindungan" name="status_perlindungan_satwa" id="dilindungi" value="1" required>
                      <label for="dilindungi">Dilindungi</label>
                    </div>
                    <div class="input-radio">
                      <input type="radio" class="status_perlindungan" name="status_perlindungan_satwa" id="tidak-dilindungi" value="0" required>
                      <label for="tidak-dilindungi">Tidak Dilindungi</label>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="sub-section3">
                <div class="section-input">
                  @error('sk_perolehan_koleksi_dirjen')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                  <div id="sk-dirjen" style="display: none;">
                    <h5>SK Peroleh Koleksi Dirjen</h5>
                    <input type="text" id="sk-dirjen-input" name="sk_perolehan_koleksi_dirjen" value="{{ old('sk_perolehan_koleksi_dirjen') }}" placeholder="Tolong diisikan nomor SK">
                  </div>
                  <div id="sk-kepala-balai" style="display: none;">
                    <h5>SK Peroleh Koleksi Kepala Balai</h5>
                    @error('sk_perolehan_koleksi_kepala_balai')
                    <div class="text-danger"  style="color: red;">{{ $message }}</div>
                    @enderror
                    <input type="text" id="sk-kepala-balai-input" name="sk_perolehan_koleksi_kepala_balai" value="{{ old('sk_perolehan_koleksi_kepala_balai') }}"  placeholder="Tolong diisikan nomor SK">
                  </div>
                </div>
              </div>
            </section>
          </div>
              
          <button type="submit" id="submit-btn"  class="btn btn-primary">Simpan Data Satwa</button>

        </form>

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