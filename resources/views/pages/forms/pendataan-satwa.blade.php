@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan Satwa</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pendataan Satwa</h4>
        <div id="wizard">
          <h2>Informasi Status Satwa</h2>
          <section>
            {{-- NAMA LK --}}
           @if ($user->role && $user->role->tag == 'LK')           
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
              <input class="" type="text" name="nama_lk" id="nama_lk" placeholder="Lembaga Konservasi" style="width: 400px; padding:10px;" value="{{ $user->lk->id }}" required>
             </div>
            @else
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
                <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
                <select name="lk_id" id="lk_id" style="width: 400px; padding:10px;" required>
                    <option value="" disabled selected>Pilih Lembaga Konservasi</option>
                    @foreach($lks as $lk)
                    <option value="{{ $lk->id }}" required >{{ $lk->nama }}</option>
                    @endforeach

                   
                </select>
            </div>

            @endif 

            {{-- JENIS KOLEKSI SATWA --}}
              <div id="form-satwa_koleksi" style="margin-bottom: 10px">
                <h5 style="margin:10px;">Jenis satwa yang akan dikoleksi?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi_hidup" value="hidup" required>
                  <label class="form-check-label" for="satwa_koleksi_hidup">
                    Satwa Hidup
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi_awetan" value="awetan" required>
                  <label class="form-check-label" for="satwa_koleksi_awetan">
                    Satwa Awetan
                  </label>
                </div>
              </div>
            {{-- JENIS SATWA YANG AKAN DI DATA --}}
            <div id="form-jenis_koleksi">
              <h5 style="margin-bottom:10px;">Jenis satwa hidup yang akan di data :</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="satwa_koleksi" value="koleksi" required>
                <label class="form-check-label" for="satwa_koleksi">
                  Satwa Koleksi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="satwa_titipan" value="titipan" required>
                <label class="form-check-label" for="satwa_titipan">
                  Satwa Titipan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="breeding_loan" value="breeding loan" required>
                <label class="form-check-label" for="breeding_loan">
                  Breeding Loan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="rehabilitasi" value="rehabilitasi" required>
                <label class="form-check-label" for="rehabilitasi">
                  Rehabilitasi
                </label>
              </div>
            </div>

            {{-- Tanggal Titipan --}}
            <div id="form-tanggal_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tanggal Titipan</h5>
              <span class="error-message" style="color: red; display: none;">Masukkan tanggal titipan</span>
              <input type="date" name="tanggal_titipan" id="tanggal_titipan" style="width: 400px; padding:10px;" required>
            </div>

            {{-- NO BA TITIPAN --}}
            <div id="form-no_ba_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">No. BA Titipan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_titipan" id="no_ba_titipan" placeholder="Masukkan nomor berita acara titipan satwa" style="width: 400px; padding:10px;" required>
            </div>

            {{-- NO Perolehan --}}
            <div id="form-perolehan" style="margin:10px 0px; padding-bottom:10px;">
              <h5>No. Perolehan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="perolehan" id="perolehan" placeholder="Masukkan nomor perolehan" style="width: 400px; padding:10px;" required>
            </div>
            {{-- ASAL SATWA --}}
            <div id="form-asal_satwa">
              <span class="error-message" style="color: red; display: none;"></span>
              <h5 style="margin:10px 0px;">Apakah satwa yang akan di data satwa asli dari Indonesia?</h5>
              
              <div class="form-check">
                <input class="form-check-input" type="radio" name="asal_satwa" id="endemik" value="endemik" required>
                <label class="form-check-label" for="endemik">
                  Endemik (Asli Indonesia)
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="asal_satwa" id="eksotik" value="eksotik" required>
                <label class="form-check-label" for="eksotik">
                  Eksotik (Bukan asli Indonesia)
                </label>
              </div>
            </div>
            {{-- STATUS PERLINDUNGAN --}}
            <div id="form-status_perlindungan" style="display: none">
              <h5 style="margin:10px 0px;">Apakah satwa statusnya dilindungi?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_perlindungan" id="status_perlindungan_ya" value="1" required>
                <label class="form-check-label" for="status_perlindungan_ya">
                  Ya, statusnya dilindungi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_perlindungan" id="status_perlindungan_tidak" value="0" required>
                <label class="form-check-label" for="status_perlindungan_tidak">
                  Tidak
                </label>
              </div>
            </div>
            {{-- CONFIRM NO SATS LN --}}
            <div id="form-confirm_no_sats-ln" style="display: none">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki No. SATS-LN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln_ya" value="ya" required>
                <label class="form-check-label" for="confirm_no_sats-ln_ya">
                  Ya, sudah ada
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln_tidak" value="tidak" required>
                <label class="form-check-label" for="confirm_no_sats-ln_tidak">
                  Tidak ada
                </label>
              </div>
            </div>
            {{-- NO SATS LN --}}
            <div id="form-no_sats-ln" style="margin:10px 0px; padding-bottom:10px;">
              <h5>No. Surat SATS-LN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_sats-ln" id="no_sats-ln" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;" required>
            </div>
            {{-- PENGAMBILAN SATWA --}}
            <div id="form-pengambilan_satwa">
              <h5 style="margin:10px 0px;">Apakah Satwa pengambilan dari Alam?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengambilan_satwa" id="pengambilan_satwa_ya" value="1" required>
                <label class="form-check-label" for="pengambilan_satwa_ya">
                  Ya, satwa diambil dari alam
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengambilan_satwa" id="pengambilan_satwa_tidak" value="0" required>
                <label class="form-check-label" for="pengambilan_satwa_tidak">
                  Tidak
                </label>
              </div>
            </div>
            {{-- CONFIRM SK MENTERI --}}
            <div id="form-confirm_sk_menteri">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki SK Menteri LHK?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_menteri" id="confirm_sk_menteri_ya" value="ya" required>
                <label class="form-check-label" for="confirm_sk_menteri_ya">
                  Ya, Sudah Memiliki SK Menteri
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_menteri" id="confirm_sk_menteri_tidak" value="tidak" required>
                <label class="form-check-label" for="confirm_sk_menteri_tidak">
                  Tidak
                </label>
              </div>
            </div>
            {{-- SK MENTERI --}}
            <div id="form-sk_menteri" style="margin:10px 0px; padding-bottom:10px;">
              <h5>No. Surat Keputusan Menteri</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="sk_menteri" id="sk_menteri" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;" required>
            </div>   
            {{-- CONFIRM SK KEPALA BALAI --}}
            <div id="form-confirm_sk_kepala">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki SK Kepala Balai?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_kepala" id="confirm_sk_kepala_ya" value="ya" required>
                <label class="form-check-label" for="confirm_sk_kepala_ya">
                  Ya, Sudah memiliki SK Kepala Balai
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_kepala" id="confirm_sk_kepala_tidak" value="tidak" required>
                <label class="form-check-label" for="confirm_sk_kepala_tidak">
                  Tidak
                </label>
              </div>
            </div>
            {{-- SK KEPALA BALAI --}}
            <div id="form-sk_kepala" style="margin:10px 0px; padding-bottom:10px;">
              <h5>No. Surat Keputusan Kepala Balai</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="sk_kepala" id="sk_kepala" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;" required>
            </div>
            {{-- CONFIRM SK KSDAE --}}
            <div id="form-confirm_sk_ksdae">
              <h5 style="margin:10px 0px;">Apakah Satwa memiliki SK Dirjen KSDAE?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_ksdae" id="confirm_sk_ksdae_ya" value="ya" required>
                <label class="form-check-label" for="confirm_sk_ksdae_ya">
                  Ya, Sudah Memiliki SK Dirjen KSDAE
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_ksdae" id="confirm_sk_ksdae_tidak" value="tidak" required>
                <label class="form-check-label" for="confirm_sk_ksdae_tidak">
                  Tidak
                </label>
              </div>
            </div>
            {{-- SK KSDAE --}}
            <div id="form-sk_ksdae" style="margin:10px 0px; padding-bottom:10px;">
              <h5>No. Surat Keputusan Dirjen KSDAE</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="sk_ksdae" id="sk_ksdae" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;" required>
            </div>                

          </section>



          <h2>Data-data Satwa</h2>
          <section>          
            {{-- PERILAKU SATWA --}}
            <div id="form-perilaku_satwa" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Apakah Satwa Memiliki Perilaku Berkelompok?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa_ya" value="1" required>
                <label class="form-check-label" for="perilaku_satwa_ya">
                  Ya
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa_tidak" value="0" required>
                <label class="form-check-label" for="perilaku_satwa_tidak">
                  Tidak
                </label>
              </div>
            </div>
          
            {{-- JUMLAH SATWA --}}
            <div id="form-jumlah" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Hewan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px;">
                <input type="number" name="jumlah_male" id="jumlah_male" placeholder="Jumlah Jantan" style="width: 180px; padding:10px;" min="0" required>
                <input type="number" name="jumlah_female" id="jumlah_female" placeholder="Jumlah Betina" style="width: 180px; padding:10px;" min="0" required>
                <input type="number" name="jumlah_unsex" id="jumlah_unsex" placeholder="Jumlah Unisex" style="width: 180px; padding:10px;" min="0" required>
              </div>
            </div>
          
            {{-- JENIS KELAMIN SATWA --}}
            <div id="form-jenis_kelamin" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Jenis kelamin satwa?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_jantan" value="1" required>
                <label class="form-check-label" for="jenis_kelamin_jantan">
                  Jantan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_betina" value="0" required>
                <label class="form-check-label" for="jenis_kelamin_betina">
                  Betina
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_belum" value="" required>
                <label class="form-check-label" for="jenis_kelamin_belum">
                  Belum diketahui
                </label>
              </div>
            </div>

            <!-- {{-- JUMLAH KESELURUHAN HEWAN --}}
            <div id="form-jumlah_keseluruhan_gender" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Keseluruhan Gender</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px;">
                <input type="number" name="jumlah_keseluruhan_gender" id="jumlah_keseluruhan_gender" placeholder="Jumlah seluruh hewan" style="width: 180px; padding:10px;" min="0" required>
              </div>
            </div> -->
          
            {{-- SATWA DI TAGGING --}}
            <div id="form-confirm_tagging" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Apakah Satwa telah Ditagging?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_tagging" id="confirm_tagging_ya" value="ya" required>
                <label class="form-check-label" for="confirm_tagging_ya">
                  Sudah
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_tagging" id="confirm_tagging_tidak" value="tidak" required>
                <label class="form-check-label" for="confirm_tagging_tidak">
                  Belum
                </label>
              </div>
            </div>
          
            {{-- ALASAN BELUM TAGGING --}}
            <div id="form-alasan_belum_tagging" class="form-alasan_belum_tagging" style="margin-bottom: 10px">
              <label for="additional_notes"><h5>Alasan satwa belum dilakukan tagging</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="alasan_belum_tagging" name="alasan_belum_tagging" rows="4" placeholder="Alasan..." required></textarea>
            </div>
          
            {{-- JENIS TAGGING --}}
            <div id="form-jenis_tagging" style="margin-bottom:10px; padding-bottom:10px; display: block;">
              <h5 style="margin-bottom: 8px">Jenis Tagging dan Kode Tagging</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px; align-items: center;">
                <select name="jenis_tagging" id="jenis_tagging" style="width: 180px; padding:10px; cursor: pointer;" required>
                  <option value="" disabled selected>Pilih Jenis Tagging</option>
                  @foreach($taggings as $jenis_tagging)
                    <option id="{{ $jenis_tagging }}" value="{{ $jenis_tagging }}" required>{{ $jenis_tagging }}</option>
                  @endforeach
                </select>               
                <input type="text" name="kode_tagging" id="kode_tagging" placeholder="Kode Tagging" style="width: 180px; padding:10px;" required>
              </div>
            </div>
                      
            {{-- BERITA ACARA TAGGING --}}
            <div id="form-ba_tagging" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Berita Acara Tagging</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="ba_tagging" id="ba_tagging" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- TANGGAL TAGGING --}}
            <div id="form-tanggal_tagging" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tanggal Tagging</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="date" name="tanggal_tagging" id="tanggal_tagging" style="width: 400px; padding:10px;" required>
            </div>
          
            <!-- {{-- NO BA TITIPAN --}}
            <div id="form-no_ba_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">No. BA Titipan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_titipan" id="no_ba_titipan" placeholder="Masukkan nomor berita acara titipan satwa" style="width: 400px; padding:10px;" required>
            </div> -->
          
            {{-- NO BA KELAHIRAN --}}
            <div id="form-no_ba_kelahiran" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">No. BA Kelahiran</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_kelahiran" id="no_ba_kelahiran" placeholder="Masukkan nomor berita acara kelahiran satwa" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- NO BA KEMATIAN --}}
            <div id="form-no_ba_kematian" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">No. BA Kematian</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_kematian" id="no_ba_kematian" placeholder="Masukkan nomor berita acara kematian satwa" style="width: 400px; padding:10px;" required>
            </div>
                   
            {{-- VALIDASI TANGGAL --}}
            <div id="form-validasi_tanggal" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Validasi Tanggal</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="date" name="validasi_tanggal" id="validasi_tanggal" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- Tahun Titipan --}}
            <!-- <div id="form-tahun_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tahun Titipan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="date" name="tahun_titipan" id="tahun_titipan" style="width: 400px; padding:10px;" required>
            </div> -->
            <!-- <div id="form-tahun_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tahun Titipan</h5>
              <span class="error-message" style="color: red; display: none;">Masukkan tahun dalam format yang benar (4 digit)</span>
              <input type="text" name="tahun_titipan" id="tahun_titipan" pattern="^[0-9]{4}$" placeholder="Masukkan tahun" style="width: 400px; padding:10px;" required>
            </div> -->
          
            {{-- Keterangan --}}
            <div id="form-keterangan" class="form-keterangan" style="margin-bottom: 10px">
              <label for="additional_notes"><h5>Keterangan</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan..." required></textarea>
            </div>
          
            {{-- SATWA INDIVIDU --}}
            {{-- NAMA SATWA DALAM INDONESIA --}}
            <div id="form-nama_satwa_ina" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Nama Satwa dalam Bahasa Indonesia</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="nama_satwa_ina" id="nama_satwa_ina" placeholder="Masukkan nama satwa dalam bahasa Indonesia" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- NAMA PANGGILAN SATWA --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Nama Panggilan Satwa</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan nama panggilan satwa" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- TAKSON SATWA --}}
            <div id="takson_hewan" class="takson-hewan" style="padding-bottom: 20px;">
                <h5 style="margin-bottom: 8px;">Takson Hewan</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <div style="display: flex; gap: 10px;">
                    
                    <select name="class" id="class" style="width: 180px; padding:10px;" required>
                          <option value="" disabled selected>Pilih Kelas</option>
                          @foreach($classes as $class)
                            <option id="{{ $class }}"  value="{{ $class }}" required>{{ $class }}</option>
                            @endforeach
                      </select>                        

                    <select name="genus" id="genus" style="width: 180px; padding:10px;" required>
                        <option value="" disabled selected>Pilih Genus</option>
                        @foreach($genus as $genus)
                            <option id="{{ $genus }}"  value="{{ $genus }}" required >{{ $genus }}</option>
                            @endforeach
                    </select>

                    <select name="species" id="species" style="width: 180px; padding:10px;" required>
                        <option value="" disabled selected>Pilih Spesies</option>
                        @foreach($spesies as $spesies)
                            <option id="{{ $spesies }}"  value="{{ $spesies }}" required >{{ $spesies }}</option>
                            @endforeach
                    </select>

                    <select name="sub_species" id="sub_species" style="width: 180px; padding:10px;" required>
                        <option value="" disabled selected>Pilih Sub Spesies</option>
                        @foreach($subSpesies as $subSpesies)
                            <option id="{{ $subSpesies }}"  value="{{ $subSpesies }}" required >{{ $subSpesies }}</option>
                            @endforeach
                    </select>
                </div>
            </div>

            {{-- SATWA BERKELOMPOK --}}
            {{-- TOTAL SATWA KELOMPOK --}}
            <div id="form-total_satwa" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Total Satwa Berkelompok</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="total_satwa" id="total_satwa" placeholder="Total Satwa" style="width: 400px; padding:10px;" min="0" required>
            </div>
          </section>          
        </div>

<!-- Menyertakan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- 
<script>
  // AUTO CLEAR VALUE
  function clearInputOnRadioChange(confirmRadioName, inputId) {
    document.querySelectorAll(`input[name="${confirmRadioName}"]`).forEach(function (radio) {
      radio.addEventListener('change', function () {
        // Jika memilih "Tidak", maka clear nilai input yang bersangkutan
        if (document.getElementById(`${confirmRadioName}_tidak`).checked) {
          document.getElementById(inputId).value = '';
        }
        
        // Menyembunyikan atau menampilkan form input berdasarkan pilihan
        if (document.getElementById(`${confirmRadioName}_ya`).checked) {
          document.getElementById(`form-${inputId}`).style.display = 'block';
        } else {
          document.getElementById(`form-${inputId}`).style.display = 'none';
        }
      });
    });
  }


  function fetchJenisTagging() {
    fetch('/get-jenis-tagging')  // Pastikan ini adalah endpoint yang benar
      .then((response) => {
        if (!response.ok) {
          throw new Error('Failed to load jenis_tagging');
        }
        return response.json();
      })
      .then((data) => {
        // Pastikan data yang dikembalikan adalah array
        if (data && Array.isArray(data) && data.length > 0) {
          updateJenisTaggingDropdown(data);
        }
      })
      .catch((error) => {
        console.error('Error fetching jenis_tagging:', error);
      });
  }

  fetchJenisTagging();

  function updateJenisTaggingDropdown(jenis_tagging) {
    const selectElement = $('#jenis_tagging');
    selectElement.empty();  // Kosongkan dropdown

    // Tambahkan opsi default
    selectElement.append('<option value="" disabled selected>Pilih Jenis Tagging</option>');

    // Filter dan ubah nilai menjadi uppercase
    jenis_tagging
      .filter(tagging => tagging !== null && tagging !== "") // Menghilangkan nilai null dan empty string
      .map(tagging => tagging.charAt(0).toUpperCase() + tagging.slice(1).toLowerCase()) // Mengubah huruf pertama menjadi uppercase
      .forEach((tagging) => {
        selectElement.append(new Option(tagging, tagging));
      });
  }

  //FETCHING SATWA
  $(document).ready(function() {
      // Load kelas data pertama kali
      fetchClassData();

      // Event ketika dropdown kelas berubah
      $('#class').on('change', function() {
          const selectedClass = $(this).val();
          if (selectedClass) {
              fetchGenus(selectedClass);
              $('#genus').prop('disabled', false);
              $('#species, #sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih</option>');
          } else {
              $('#genus, #species, #sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih</option>');
          }
      });

      // Event ketika dropdown genus berubah
      $('#genus').on('change', function() {
          const selectedGenus = $(this).val();
          if (selectedGenus) {
              fetchSpecies(selectedGenus);
              $('#species').prop('disabled', false);
              $('#sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih</option>');
          } else {
              $('#species, #sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih</option>');
          }
      });

      // Event ketika dropdown species berubah
      $('#species').on('change', function() {
          const selectedSpecies = $(this).val();
          if (selectedSpecies) {
              fetchSubSpecies(selectedSpecies);
              $('#sub_species').prop('disabled', false);
          } else {
              $('#sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih</option>');
          }
      });
  });

  // Fungsi untuk memuat data kelas
  function fetchClassData() {
      fetch('/get-takson-satwa')
          .then(response => response.json())
          .then(data => {
              const classSelect = $('#class');
              const classes = [...new Set(data.map(item => item.class))]; // Ambil kelas unik
              classes.forEach(cls => {
                  classSelect.append(new Option(toTitleCase(cls), cls));
              });
          })
          .catch(error => console.error('Error loading classes:', error));
  }

  // Fungsi untuk memuat data genus berdasarkan kelas
  function fetchGenus(selectedClass) {
      fetch(`/get-takson-satwa?class=${selectedClass}`)
          .then(response => response.json())
          .then(data => {
              console.log("Received genus data:", data); // Debugging
              const genusSelect = $('#genus');
              genusSelect.empty().append('<option value="" disabled selected>Pilih Genus</option>');
              const genusList = [...new Set(data.map(item => item.genus))]; // Ambil genus unik
              genusList.forEach(genus => {
                  genusSelect.append(new Option(toTitleCase(genus), genus));
              });
          })
          .catch(error => console.error('Error loading genus:', error));
  }

  // Fungsi untuk memuat data spesies berdasarkan genus
  function fetchSpecies(selectedGenus) {
      fetch(`/get-takson-satwa?genus=${selectedGenus}`)
          .then(response => response.json())
          .then(data => {
              console.log("Received species data:", data); // Debugging
              const speciesSelect = $('#species');
              speciesSelect.empty().append('<option value="" disabled selected>Pilih Spesies</option>');
              const speciesList = [...new Set(data.map(item => item.spesies))]; // Ambil spesies unik
              speciesList.forEach(species => {
                  speciesSelect.append(new Option(toTitleCase(species), species));
              });
          })
          .catch(error => console.error('Error loading species:', error));
  }

  // Fungsi untuk memuat data subspesies berdasarkan spesies
  function fetchSubSpecies(selectedSpecies) {
      fetch(`/get-takson-satwa?spesies=${selectedSpecies}`)
          .then(response => response.json())
          .then(data => {
              console.log("Received sub-species data:", data); // Debugging
              const subSpeciesSelect = $('#subspesies');
              subSpeciesSelect.empty().append('<option value="" disabled selected>Pilih Sub Spesies</option>');
              const subSpeciesList = [...new Set(data.map(item => item.subspesies))]; // Ambil subspesies unik
              subSpeciesList.forEach(subSpecies => {
                  subSpeciesSelect.append(new Option(toTitleCase(subSpecies), subSpecies));
              });
          })
          .catch(error => console.error('Error loading sub-species:', error));
  } -->


  <!-- // Fungsi untuk mengubah string menjadi title case
  function toTitleCase(str) {
      return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
  }


</script> -->
<script>
    $(document).ready(function () {

    // AUTO CLEAR VALUE
    function clearInputOnRadioChange(confirmRadioName, inputId) {
      document.querySelectorAll(`input[name="${confirmRadioName}"]`).forEach(function (radio) {
        radio.addEventListener('change', function () {
          // Jika memilih "Tidak", maka clear nilai input yang bersangkutan
          if (document.getElementById(`${confirmRadioName}_tidak`).checked) {
            document.getElementById(inputId).value = '';
          }
          
          // Menyembunyikan atau menampilkan form input berdasarkan pilihan
          if (document.getElementById(`${confirmRadioName}_ya`).checked) {
            document.getElementById(`form-${inputId}`).style.display = 'block';
          } else {
            document.getElementById(`form-${inputId}`).style.display = 'none';
          }
        });
      });
    }
    // Ketika class dipilih
    $('#class').on('change', function () {
        let selectedClass = $(this).val();

        // Reset dan disable dropdown berikutnya
        $('#genus').prop('disabled', true).empty().append('<option value="" disabled selected>Loading...</option>');
        $('#species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih Spesies</option>');
        $('#sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih Sub Spesies</option>');

        // Fetch genus berdasarkan class
        if (selectedClass) {
            $.get('/pendataan-satwa', { class: selectedClass }, function (data) {
                $('#genus').empty().append('<option value="" disabled selected>Pilih Genus</option>');
                data.forEach(function (genus) {
                    $('#genus').append(`<option value="${genus}">${genus}</option>`);
                });
                $('#genus').prop('disabled', false);
            });
        }
    });

    // Ketika genus dipilih
    $('#genus').on('change', function () {
        let selectedGenus = $(this).val();

        $('#species').prop('disabled', true).empty().append('<option value="" disabled selected>Loading...</option>');
        $('#sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Pilih Sub Spesies</option>');

        if (selectedGenus) {
            $.get('/pendataan-satwa', { genus: selectedGenus }, function (data) {
                $('#species').empty().append('<option value="" disabled selected>Pilih Spesies</option>');
                data.forEach(function (species) {
                    $('#species').append(`<option value="${species}">${species}</option>`);
                });
                $('#species').prop('disabled', false);
            });
        }
    });

    // Ketika species dipilih
    $('#species').on('change', function () {
        let selectedSpecies = $(this).val();

        $('#sub_species').prop('disabled', true).empty().append('<option value="" disabled selected>Loading...</option>');

        if (selectedSpecies) {
            $.get('/pendataan-satwa', { species: selectedSpecies }, function (data) {
                $('#sub_species').empty().append('<option value="" disabled selected>Pilih Sub Spesies</option>');
                data.forEach(function (subSpecies) {
                    $('#sub_species').append(`<option value="${subSpecies}">${subSpecies}</option>`);
                });
                $('#sub_species').prop('disabled', false);
            });
        }
    });
});
</script>

@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
  
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard-2.js') }}"></script>  
@endpush