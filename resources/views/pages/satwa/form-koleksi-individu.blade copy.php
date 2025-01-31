@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
<<<<<<< Updated upstream:resources/views/pages/satwa/pendataan-satwa.blade.php
=======
  <link rel="stylesheet" href="{{ asset('css/form-koleksi-individu.css') }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

>>>>>>> Stashed changes:resources/views/pages/satwa/form-koleksi-individu.blade copy.php
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan Satwa</li>
  </ol>
</nav>

<div class="row">
  @include('components.notifikasi-action')
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
<<<<<<< Updated upstream:resources/views/pages/satwa/pendataan-satwa.blade.php
        <h4 class="card-title">Pendataan Satwa</h4>
        {{-- <p class="text-muted mb-3">Read the <a href="http://www.jquery-steps.com/GettingStarted" target="_blank"> Official jQuery Steps Documentation </a>for a full list of instructions and other options.</p> --}}
        <div id="wizard">
          <h2>Informasi Status Satwa</h2>
          <section id="pendataan1">
            {{-- NAMA LK --}}
           @if ($user->role && $user->role->tag == 'LK')           
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
              <input class="" type="text" name="{{ $user->lk->slug }}" id="{{ $user->lk->id }}" placeholder="Lembaga Konservasi" style="width: 400px; padding:10px;" value="{{ $user->lk->name }}" >
              {{-- <div id="nama_lk" style="width: 400px; padding:10px; outline:1px solid rgb(120, 119, 119); color:rgb(120, 119, 119);">
                Lembaga Konservasi
              </div> --}}
            </div>
            @else
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
              <select class="select2" name="lembaga_konservasi" id="lembaga_konservasi" style="width: 400px; padding: 10px;">
                <option value="" hidden>Pilih Unit LK</option>
                @foreach ($lk as $lk)
                    <option value="{{ $lk->id }}">{{ $lk->nama }}</option>
                @endforeach
            </select>
            
              
            </div>

            @endif 
            

            {{-- JENIS KOLEKSI SATWA --}}
              <div id="form-satwa_koleksi" style="margin-bottom: 10px">
                <h5 style="margin:10px;">Jenis satwa yang akan dikoleksi?</h5>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi" value="Ya">
                  <label class="form-check-label">
                    Satwa Hidup
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi" value="Tidak">
                  <label class="form-check-label">
                    Satwa Awetan
                  </label>
                </div>
              </div>

            {{-- JENIS SATWA YANG AKAN DI DATA --}}
            <div id="form-jenis_koleksi">
              <h5 style="margin-bottom:10px;">Jenis satwa hidup yang akan di data :</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi">
                <label class="form-check-label">
                  Satwa Koleksi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi">
                <label class="form-check-label">
                  Satwa Titipan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi">
                <label class="form-check-label">
                  Breeding Loan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi">
                <label class="form-check-label">
                  Rehabilitasi
                </label>
              </div>
            </div>


            {{-- ASAL SATWA --}}
            <div id="form-asal_satwa">
              <h5 style="margin:10px 0px;">Apakah satwa yang akan di data satwa asli dari Indonesia?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="asal_satwa" id="asal_satwa" value="Ya">
                <label class="form-check-label">
                  Endemik (Asli Indonesia)
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="asal_satwa" id="asal_satwa" value="Tidak">
                <label class="form-check-label">
                  Eksotik (Bukan asli Indonesia)
                </label>
              </div>
            </div>

            {{-- STATUS PERLINDUNGAN --}}
            <div id="form-status_perlindungan" style="display: none">
              <h5 style="margin:10px 0px;">Apakah satwa statusnya dilindungi?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_perlindungan" id="status_perlindungan" value="Ya">
                <label class="form-check-label">
                  Ya, statusnya dilindungi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_perlindungan" id="status_perlindungan" value="Tidak">
                <label class="form-check-label">
                  Tidak
                </label>
=======
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
>>>>>>> Stashed changes:resources/views/pages/satwa/form-koleksi-individu.blade copy.php
              </div>
            </div>


            {{-- CONFIRM NO SATS LN --}}
            <div id="form-confirm_no_sats-ln" style="display: none">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki No. SATS-LN</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln" value="Ya">
                <label class="form-check-label">
                  Ya, sudah ada
                </label>
              </div>
<<<<<<< Updated upstream:resources/views/pages/satwa/pendataan-satwa.blade.php
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln" value="Tidak">
                <label class="form-check-label">
                  Tidak ada
                </label>
=======
              <div>
                <h5 id="title-input">Tanggal Lahir <span class="keterangan">(Opsional)</span></h5>
                <input type="text" name="tanggal_lahir" id="tanggal-lahir" placeholder="dd/mm/yyyy">
>>>>>>> Stashed changes:resources/views/pages/satwa/form-koleksi-individu.blade copy.php
              </div>
              
            </div>

<<<<<<< Updated upstream:resources/views/pages/satwa/pendataan-satwa.blade.php
            {{-- NO SATS LN --}}
            <div id="form-no_sats-ln" style="margin:10px 0px; padding-bottom:30px;">
              <h5>No. Surat SATS-LN</h5>
              <input class="" type="text" name="no_sats-ln" id="no_sats-ln" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;">
            </div>
            
                    
            {{-- PENGAMBILAN SATWA --}}
            <div id="form-pengambilan_satwa">
              <h5 style="margin:10px 0px;">Apakah Satwa pengambilan dari Alam?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengambilan_satwa" id="pengambilan_satwa" value="Ya">
                <label class="form-check-label">
                  Ya, satwa diambil dari alam
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengambilan_satwa" id="pengambilan_satwa" value="Tidak">
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>

            {{-- CONFIRM SK MENTERI --}}
            <div id="form-confirm_sk_menteri">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki SK Menteri LHK?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_menteri" id="confirm_sk_menteri" value="Ya">
                <label class="form-check-label">
                  Ya, Sudah Memiliki SK Menteri
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_menteri" id="confirm_sk_menteri" value="Tidak">
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>

            {{-- SK MENTERI --}}
            <div id="form-sk_menteri" style="margin:10px 0px; padding-bottom:30px;">
              <h5>No. Surat Keputusan Menteri</h5>
              <input class="" type="text" name="sk_menteri" id="sk_menteri" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;">
            </div>   

            {{-- CONFIRM SK KEPALA BALAI --}}
            <div id="form-confirm_sk_kepala">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki SK Kepala Balai?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_kepala" id="confirm_sk_kepala" value="Ya">
                <label class="form-check-label">
                  Ya, Sudah memiliki SK Kepala Balai
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_kepala" id="confirm_sk_kepala" value="Tidak">
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>

            {{-- SK KEPALA BALAI --}}
            <div id="form-sk_kepala" style="margin:10px 0px; padding-bottom:30px;">
              <h5>No. Surat Keputusan Kepala Balai</h5>
              <input class="" type="text" name="sk_kepala" id="sk_kepala" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;">
            </div>


            {{-- CONFIRM SK KSDAE --}}
            <div id="form-confirm_sk_ksdae">
              <h5 style="margin:10px 0px;">Apakah Satwa memiliki SK Dirjen KSDAE?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_ksdae" id="confirm_sk_ksdae" value="Ya">
                <label class="form-check-label">
                  Ya, Sudah Memiliki SK Dirjen KSDAE
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_ksdae" id="confirm_sk_ksdae" value="Tidak">
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>

            {{-- SK KSDAE --}}
            <div id="form-sk_ksdae" style="margin:10px 0px; padding-bottom:30px;">
              <h5>No. Surat Keputusan Dirjen KSDAE</h5>
              <input class="" type="text" name="sk_ksdae" id="sk_ksdae" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;">
            </div>                

          </section>

          <h2>Data-data Satwa</h2>
          <section id="pendataan2">
            {{-- <h2>Second Step</h2> --}}

            {{-- PERILAKU SATWA --}}
              <div id="form-perilaku_satwa" style="margin-bottom: 10px">
                <h5 style="margin-bottom:10px;">Apakah Satwa Memiliki Perilaku Berkelompok?</h5>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa" value="Ya">
                  <label class="form-check-label">
                    Ya
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa" value="Tidak">
                  <label class="form-check-label">
                    Tidak
                  </label>
                </div>
              </div>

              {{-- JUMLAH SATWA --}}
              <div id="form-jumlah" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Jumlah Hewan</h5>
                <div style="display: flex; gap: 10px;">
                  <input type="number" name="jumlah_male" id="jumlah_male" placeholder="Jumlah Jantan" style="width: 180px; padding:10px;" min="0">
                  <input type="number" name="jumlah_female" id="jumlah_female" placeholder="Jumlah Betina" style="width: 180px; padding:10px;" min="0">
                  <input type="number" name="jumlah_unsex" id="jumlah_unsex" placeholder="Jumlah Unisex" style="width: 180px; padding:10px;" min="0">
                </div>
              </div>

              {{-- JUMLAH KESELURUHAN HEWAN --}}
              <div id="form-jumlah_keseluruhan_gender" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Jumlah Keseluruhan Hewan</h5>
                <div style="display: flex; gap: 10px;">
                  <input type="number" name="jumlah_keseluruhan_gender" id="jumlah_keseluruhan_gender" placeholder="Jumlah seluruh hewan" style="width: 180px; padding:10px;" min="0">
                  </div>
              </div>

              {{-- JENIS KELAMIN SATWA --}}
              <div id="form-satwa_koleksi" style="margin-bottom: 10px">
                <h5 style="margin-bottom:10px;">Jenis kelamin satwa?</h5>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi" value="Ya">
                  <label class="form-check-label">
                    Jantan
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi" value="Ya">
                  <label class="form-check-label">
                    Betina
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi" value="Tidak">
                  <label class="form-check-label">
                    Belum diketahui
                  </label>
                </div>
              </div>

              

              {{-- SATWA DI TAGGING --}}
              <div id="form-confirm_tagging" style="margin-bottom: 10px">
                <h5 style="margin-bottom:10px;">Apakah Satwa Telah Ditagging?</h5>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="confirm_tagging" id="confirm_tagging" value="Ya">
                  <label class="form-check-label">
                    Sudah
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="confirm_tagging" id="confirm_tagging" value="Tidak">
                  <label class="form-check-label">
                    Belum
                  </label>
                </div>
              </div>

              {{-- ALASAN BELUM TAGGING --}}
              <div class="form-alasan_belum_tagging" style="margin-bottom: 10px">
                <label for="additional_notes"><h5>Alasan satwa belum dilakukan tagging</h5></label>
                <textarea class="form-control" id="alasan_belum_tagging" name="alasan_belum_tagging" rows="4" placeholder="Alasan..."></textarea>
            </div>
            
              
              {{-- JENIS TAGGING --}}
              <div id="form-jenis_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Jenis Tagging dan Jumlah</h5>
                <div style="display: flex; gap: 10px;">
                  <!-- Dropdown for selecting tagging type -->
                  <select name="jenis_tagging" id="jenis_tagging" style="width: 180px; padding:10px;">
                    <option value="" disabled selected>Pilih Jenis Tagging</option>
                    <option value="ring">Ring</option>
                    <option value="chip">Chip</option>
                    <option value="eartag">Eartag</option>
                    <option value="label">Label</option>
                    <option value="tattoo">Tattoo</option>
                  </select>
                  
                  <!-- Number input for quantity -->
                  <input type="text" name="kode_tagging" id="kode_tagging" placeholder="Kode Tagging" style="width: 180px; padding:10px;" min="0">
                </div>
              </div>
              
              {{-- BERITA ACARA TAGGING --}}
              <div id="form-ba_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Berita Acara Tagging</h5>
                <input class="" type="text" name="ba_tagging" id="ba_tagging" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
              </div> 

              {{-- TANGGAL TAGGING --}}
              <div id="form-tanggal_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Tanggal Tagging</h5>
                <input class="" type="date" name="tanggal_tagging" id="tanggal_tagging" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;">
              </div> 

              {{-- NO BA TITIPAN --}}
            <div id="form-no_ba_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NO BA TITIPAN</h5>
              <input class="" type="text" name="no_ba_titipan" id="no_ba_titipan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- NO BA KELAHIRAN --}}
            <div id="form-no_ba_kelahiran" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NO BA KELAHIRAN</h5>
              <input class="" type="text" name="no_ba_kelahiran" id="no_ba_kelahiran" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- NO BA KEMATIAN --}}
            <div id="form-no_ba_kematian" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NO BA KEMATIAN</h5>
              <input class="" type="text" name="no_ba_kematian" id="no_ba_kematian" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- NAMA PANGGILAN --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA PANGGILAN</h5>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- VALIDASI TANGGAL --}}
            <div id="form-validasi_tanggal" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Validasi Tanggal</h5>
              <input class="" type="date" name="validasi_tanggal" id="validasi_tanggal" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- Tahun Titipan --}}
            <div id="form-tahun_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tahun Titipan</h5>
              <input class="" type="date" name="tahun_titipan" id="tahun_titipan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- Keterangan --}}
            <div class="form-keterangan" style="margin-bottom: 10px">
              <label for="additional_notes"><h5>Keterangan</h5></label>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan..."></textarea>
            </div>

            {{-- NAMA SATWA INDONESIA --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA PANGGILAN</h5>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- S A T W A  I N D I V I D U --}}
            {{-- NAMA SATWA DALAM INDONESIA  --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA SATWA DALAM INDONESIA</h5>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- NAMA PANGGILAN SATWA  --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA PANGGILAN SATWA</h5>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div> 

            {{-- TAKSON SATWA --}}
            <div class="takson-hewan" style="padding-bottom: 20px;">
              <h5 style="margin-bottom: 8px;">TAKSON HEWAN</h5>        
              <div style="display: flex; gap: 10px;">          
                <div class="dropdown">
                    <button class="btn dropdown-toggle custom-dropdown" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Class
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Another action 1</a>
                        <a class="dropdown-item" href="#">Something else here 1</a>
                    </div>
                </div>
                
                <div class="dropdown">
                    <button class="btn dropdown-toggle custom-dropdown" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Genus
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <a class="dropdown-item" href="#">Action 2</a>
                        <a class="dropdown-item" href="#">Another action 2</a>
                        <a class="dropdown-item" href="#">Something else here 2</a>
                    </div>
                </div>
                
                <div class="dropdown">
                    <button class="btn dropdown-toggle custom-dropdown" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Species
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                        <a class="dropdown-item" href="#">Action 3</a>
                        <a class="dropdown-item" href="#">Another action 3</a>
                        <a class="dropdown-item" href="#">Something else here 3</a>
                    </div>
                </div>
                
                <div class="dropdown">
                    <button class="btn dropdown-toggle custom-dropdown" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sub Species
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                        <a class="dropdown-item" href="#">Action 4</a>
                        <a class="dropdown-item" href="#">Another action 4</a>
                        <a class="dropdown-item" href="#">Something else here 4</a>
                    </div>
                </div>
              </div>
            </div>  

            {{-- S A T W A  B E R K E L O M P O K --}}
            {{-- TOTAL SATWA KELOMPOK --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Total Satwa</h5>
              <input class="" type="number" name="total_satwa" id="total_satwa" placeholder="Total Satwa" style="width: 400px; padding:10px;" min="0">
            </div> 
          </section>

        </div>
      </div>
    </div>
=======
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
>>>>>>> Stashed changes:resources/views/pages/satwa/form-koleksi-individu.blade copy.php
  </div>
</div>




@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
<<<<<<< Updated upstream:resources/views/pages/satwa/pendataan-satwa.blade.php
  <script src="{{ asset('assets/js/wizard.js') }}"></script>  
  <script src="{{ asset('assets/js/pendataan-satwa.js') }}"></script>  
=======
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/form-koleksi-individu.js') }}"></script>
  {{-- <script src="{{ asset('assets/js/pendataan-satwa.js') }}"></script>   --}}
  {{-- <script src="{{ asset('assets/js/wizard.js') }}"></script>   --}}
>>>>>>> Stashed changes:resources/views/pages/satwa/form-koleksi-individu.blade copy.php
@endpush