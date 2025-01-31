@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
  <link href="{{ asset('/css/error-silsilah.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan Silsilah Satwa</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Pendataan Silsilah Satwa</h4>
        <x-notifikasi-action class="mb-4"/>

        <div id="wizard">
          <!-- Wizard Form -->
          <h2>Informasi Silsilah Satwa</h2>
          <section>
          <div id="error-container" style="display: none;">
            <h3>Tolong Lengkapi Pendataan Silsilah Satwa!</h3>
            <ul id="error-messages"></ul>
          </div>

            {{-- Nama Satwa --}}
            <div class="form-group">
            <h5 style="margin:10px;">Nama Satwa?</h5>
              <select class="form-control" id="namaSatwa" name="namaSatwa" required>
                <option value=""hidden disabled selected>Pilih Nama Satwa</option>
                @foreach ($listSatwa as $satwa)
                <option value="{{ $satwa->id }}" jenis_kelamin="{{ $satwa->jenis_kelamin }}" id_spesies="{{ $satwa->id_spesies }}">
                  {{ $satwa->nama_panggilan }} - {{ $satwa->species->nama_ilmiah }}</option>
                @endforeach
              </select>
            </div>

            {{-- Nama Ayah --}}
            <div class="form-group">
            <h5 style="margin:10px;">Nama Ayah?</h5>
              <select class="form-control" id="namaAyah" name="namaAyah" required>
                <option value="" hidden disabled selected>Pilih Nama Ayah</option>
                @foreach ($listSatwa as $satwa)
                @if($satwa->jenis_kelamin == 1)
                  <option value="{{ $satwa->id }}" jenis_kelamin="{{ $satwa->jenis_kelamin }}" id_spesies="{{ $satwa->id_spesies }}">
                    {{ $satwa->nama_panggilan }} - {{ $satwa->species->nama_ilmiah }}</option>
                @endif
                @endforeach
              </select>
            </div>

            {{-- Nama Ibu --}}
            <div class="form-group">
            <h5 style="margin:10px;">Nama Ibu?</h5>
              <select class="form-control" id="namaIbu" name="namaIbu" required>
                <option value="" hidden disabled selected>Pilih Nama Ibu</option>
                @foreach ($listSatwa as $satwa)
                @if($satwa->jenis_kelamin == 0)
                <option value="{{ $satwa->id }}" jenis_kelamin="{{ $satwa->jenis_kelamin }}" id_spesies="{{ $satwa->id_spesies }}">
                  {{ $satwa->nama_panggilan }} - {{ $satwa->species->nama_ilmiah }}</option>
                @endif
                @endforeach
              </select>
            </div>

            {{-- Punya pasangan --}}
            <div id="form-punya-pasangan" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah satwa memiliki pasangan?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_sudah" value="sudah" required>
                    <label class="form-check-label" for="status_sudah">
                    Sudah
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_belum" value="belum" required>
                    <label class="form-check-label" for="status_belum">
                    Belum
                    </label>
                </div>
            </div>

            {{-- Pasangan (Jika Sudah Memiliki Pasangan) --}}
            <div class="form-group" id="form-pasangan" style="display: none;">
            <h5 style="margin:10px;">Pilih Pasangan</h5>
              <select class="form-control" id="pasangan" name="pasangan" required>
                <option value="" hidden disabled selected>Pilih Nama Pasangan</option>
                @foreach ($listSatwa as $satwa)
                  <option value="{{ $satwa->id }}" jenis_kelamin="{{ $satwa->jenis_kelamin }}" id_spesies="{{ $satwa->id_spesies }}">
                    {{ $satwa->nama_panggilan }} - {{ $satwa->species->nama_ilmiah }}</option>
                @endforeach
              </select>
            </div>

            {{-- Tanggal Dipasangkan --}}
            {{-- <div class="form-group" id="form-tanggal-dipasangkan" style="display: none;">
            <h5 style="margin:10px;">Tanggal Dipasangkan</h5>
              <input type="date" class="form-control" id="tanggalDipasangkan" name="tanggalDipasangkan" required>
            </div> --}}

            {{-- Punya anak --}}
            <div id="form-punya-anak" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah satwa memiliki anak?</h5>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="punya_anak" id="punya_anak_ya" value="ya" required>
                    <label class="form-check-label" for="punya_anak_ya">
                    Ya
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="punya_anak" id="punya_anak_tidak" value="tidak" required>
                    <label class="form-check-label" for="punya_anak_tidak">
                    Tidak
                    </label>
                </div>
            </div>

            {{-- Anak (jika memiliki anak) --}}
            <div class="form-group" id="form-anak" style="display: none;">
            <h5 style="margin:10px;">Pilih Anak</h5>
              <select class="form-control" id="anak" name="anak" required>
                <option value="" hidden disabled selected>Pilih Nama Anak</option>
                @foreach ($listSatwa as $satwa)
                  <option value="{{ $satwa->id }}" jenis_kelamin="{{ $satwa->jenis_kelamin }}" id_spesies="{{ $satwa->id_spesies }}">
                    {{ $satwa->nama_panggilan }} - {{ $satwa->species->nama_ilmiah }}</option>
                @endforeach
              </select>
            </div>

            {{--Apakah pasangan sudah dipisahkan? --}}
            {{-- <div id="form-dipisahkan" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah pasangan sudah dipisahkan?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="dipisahkan" id="dipisahkan_sudah" value="sudah" required>
                    <label class="form-check-label" for="dipisahkan_sudah">
                    Sudah
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="dipisahkan" id="dipisahkan_belum" value="belum" required>
                    <label class="form-check-label" for="dipisahkan_belum">
                    Belum
                    </label>
                </div>
            </div> --}}

            {{-- Tanggal Dipisahkan --}}
            {{-- <div class="form-group" id="form-tanggal-dipisahkan" style="display: none;">
            <h5 style="margin:10px;">Tanggal Dipisahkan</h5>
              <input type="date" class="form-control" id="tanggalDipisahkan" name="tanggalDipisahkan" required>
            </div> --}}

            {{-- Alasan Dipisahkan --}}
            {{-- <div id="form-alasan-pisah" class="form-alasan-pisah" style="display: none;">
              <label for="additional_notes"><h5 style="margin: 10px;">Alasan Dipisahkan</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="alasan" name="alasan" rows="4" placeholder="Alasan..." required></textarea>
            </div> --}}
          </section>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('custom-scripts')
  <script src="{{ asset('assets/js/silsilah.js') }}"></script>
@endpush

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/silsilah-jquery.steps.min.js') }}"></script>
@endpush
