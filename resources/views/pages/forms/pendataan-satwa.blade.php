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
              <input class="" type="text" name="{{ $user->lk->slug ?? '-' }}" id="{{ $user->lk->id ?? '-' }}" placeholder="Lembaga Konservasi" style="width: 400px; padding:10px;" value="{{ $user->lk->name ?? '-' }}" required>
               </div>
            @endif 

            {{-- JENIS KOLEKSI SATWA --}}
              <div id="form-satwa_koleksi" style="margin-bottom: 10px">
                <h5 style="margin:10px;">Jenis satwa yang akan dikoleksi?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi_hidup" value="Hidup" required>
                  <label class="form-check-label">
                    Satwa Hidup
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="satwa_koleksi" id="satwa_koleksi_awetan" value="Awetan" required>
                  <label class="form-check-label">
                    Satwa Awetan
                  </label>
                </div>
              </div>
            {{-- JENIS SATWA YANG AKAN DI DATA --}}
            <div id="form-jenis_koleksi">
              <h5 style="margin-bottom:10px;">Jenis satwa hidup yang akan di data :</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi" value="Satwa Koleksi" required>
                <label class="form-check-label">
                  Satwa Koleksi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi" value="Satwa Titipan" required>
                <label class="form-check-label">
                  Satwa Titipan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi" value="Breeding Loan" required>
                <label class="form-check-label">
                  Breeding Loan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi" value="Rehabilitasi" required>
                <label class="form-check-label">
                  Rehabilitasi
                </label>
              </div>
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
                <input class="form-check-input" type="radio" name="asal_satwa" id="asal_satwa" value="Endemik" required>
                <label class="form-check-label">
                  Endemik (Asli Indonesia)
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="asal_satwa" id="asal_satwa" value="Eksotik" required>
                <label class="form-check-label">
                  Eksotik (Bukan asli Indonesia)
                </label>
              </div>
            </div>
            {{-- STATUS PERLINDUNGAN --}}
            <div id="form-status_perlindungan" style="display: none">
              <h5 style="margin:10px 0px;">Apakah satwa statusnya dilindungi?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_perlindungan" id="status_perlindungan" value="1" required>
                <label class="form-check-label">
                  Ya, statusnya dilindungi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_perlindungan" id="status_perlindungan" value="0" required>
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>
            {{-- CONFIRM NO SATS LN --}}
            <div id="form-confirm_no_sats-ln" style="display: none">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki No. SATS-LN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln" value="Ya" required>
                <label class="form-check-label">
                  Ya, sudah ada
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln" value="Tidak" required>
                <label class="form-check-label">
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
                <input class="form-check-input" type="radio" name="pengambilan_satwa" id="pengambilan_satwa" value="1" required>
                <label class="form-check-label">
                  Ya, satwa diambil dari alam
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengambilan_satwa" id="pengambilan_satwa" value="0" required>
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>
            {{-- CONFIRM SK MENTERI --}}
            <div id="form-confirm_sk_menteri">
              <h5 style="margin:10px 0px;">Apakah Satwa Memiliki SK Menteri LHK?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_menteri" id="confirm_sk_menteri" value="Ya" required>
                <label class="form-check-label">
                  Ya, Sudah Memiliki SK Menteri
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_menteri" id="confirm_sk_menteri" value="Tidak" required>
                <label class="form-check-label">
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
                <input class="form-check-input" type="radio" name="confirm_sk_kepala" id="confirm_sk_kepala" value="Ya" required>
                <label class="form-check-label">
                  Ya, Sudah memiliki SK Kepala Balai
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_kepala" id="confirm_sk_kepala" value="Tidak" required>
                <label class="form-check-label">
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
                <input class="form-check-input" type="radio" name="confirm_sk_ksdae" id="confirm_sk_ksdae" value="Ya" required>
                <label class="form-check-label">
                  Ya, Sudah Memiliki SK Dirjen KSDAE
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_sk_ksdae" id="confirm_sk_ksdae" value="Tidak" required>
                <label class="form-check-label">
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
                <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa" value="1" required>
                <label class="form-check-label">
                  Ya
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa" value="0" required>
                <label class="form-check-label">
                  Tidak
                </label>
              </div>
            </div>
          
            {{-- JUMLAH SATWA --}}
            <div id="form-jumlah" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Hewan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px;">
                <input type="number" name="jumlah_male" id="jumlah_male" placeholder="Jumlah Jantan" style="width: 180px; padding:10px;" min="0" step="0.01" value="0.00" required>
                <input type="number" name="jumlah_female" id="jumlah_female" placeholder="Jumlah Betina" style="width: 180px; padding:10px;" min="0" step="0.01" value="0.00" required>
                <input type="number" name="jumlah_unsex" id="jumlah_unsex" placeholder="Jumlah Unisex" style="width: 180px; padding:10px;" min="0" step="0.01" value="0.00" required>
              </div>
            </div>
          
            {{-- JENIS KELAMIN SATWA --}}
            <div id="form-jenis_kelamin" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Jenis kelamin satwa?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="1" required>
                <label class="form-check-label">
                  Jantan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="0" required>
                <label class="form-check-label">
                  Betina
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="" required>
                <label class="form-check-label">
                  Belum diketahui
                </label>
              </div>
            </div>

            {{-- JUMLAH KESELURUHAN HEWAN --}}
            <div id="form-jumlah_keseluruhan_gender" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Keseluruhan Gender</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px;">
                <input type="number" name="jumlah_keseluruhan_gender" id="jumlah_keseluruhan_gender" placeholder="Jumlah seluruh hewan" style="width: 180px; padding:10px;" min="0" step="0.01" required>
              </div>
            </div>
          
            {{-- SATWA DI TAGGING --}}
            <div id="form-confirm_tagging" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Apakah Satwa Telah Ditagging?</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_tagging" id="confirm_tagging" value="Ya" required>
                <label class="form-check-label">
                  Sudah
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_tagging" id="confirm_tagging" value="Tidak" required>
                <label class="form-check-label">
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
            <div id="form-jenis_tagging" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jenis Tagging dan Jumlah</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px;">
                <!-- Dropdown for selecting tagging type -->
                <select name="jenis_tagging" id="jenis_tagging" style="width: 180px; padding:10px;" required>
                  <option value="" disabled selected>Pilih Jenis Tagging</option>
                  <option value="ring">Ring</option>
                  <option value="chip">Chip</option>
                  <option value="eartag">Eartag</option>
                  <option value="label">Label</option>
                  <option value="tattoo">Tattoo</option>
                </select>                
                <!-- Number input for quantity -->
                <input type="number" name="kode_tagging" id="kode_tagging" placeholder="Kode Tagging" style="width: 180px; padding:10px;" min="0" required>
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
              <input class="" type="date" name="tanggal_tagging" id="tanggal_tagging" placeholder="Masukkan nomor keputusan" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- NO BA TITIPAN --}}
            <div id="form-no_ba_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NO BA TITIPAN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_titipan" id="no_ba_titipan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- NO BA KELAHIRAN --}}
            <div id="form-no_ba_kelahiran" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NO BA KELAHIRAN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_kelahiran" id="no_ba_kelahiran" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- NO BA KEMATIAN --}}
            <div id="form-no_ba_kematian" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NO BA KEMATIAN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="no_ba_kematian" id="no_ba_kematian" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
                   
            {{-- VALIDASI TANGGAL --}}
            <div id="form-validasi_tanggal" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Validasi Tanggal</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="date" name="validasi_tanggal" id="validasi_tanggal" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- Tahun Titipan --}}
            <div id="form-tahun_titipan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tahun Titipan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="date" name="tahun_titipan" id="tahun_titipan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- Keterangan --}}
            <div id="form-keterangan" class="form-keterangan" style="margin-bottom: 10px">
              <label for="additional_notes"><h5>Keterangan</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan..." required></textarea>
            </div>
          
            {{-- SATWA INDIVIDU --}}
            {{-- NAMA SATWA DALAM INDONESIA --}}
            <div id="form-nama_satwa_ina" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA SATWA DALAM INDONESIA</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="nama_satwa_ina" id="nama_satwa_ina" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- NAMA PANGGILAN SATWA --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA PANGGILAN SATWA</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
            </div>
          
            {{-- TAKSON SATWA --}}
            <div id="takson_hewan" class="takson-hewan" style="padding-bottom: 20px;">
              <h5 style="margin-bottom: 8px;">TAKSON HEWAN</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div style="display: flex; gap: 10px;">
                
                <select name="class" id="class" style="width: 180px; padding:10px;" required>
                  <option value="" disabled selected>Pilih Kelas</option>
                  <option value="mammalia">Mammalia</option>
                  <option value="aves">Aves</option>
                  <option value="reptilia">Reptilia</option>
                  <option value="amphibia">Amphibia</option>
                  <option value="pisces">Pisces</option>
                </select>

                <select name="genus" id="genus" style="width: 180px; padding:10px;" required>
                  <option value="" disabled selected>Pilih Genus</option>
                  <option value="genus1">Genus 1</option>
                  <option value="genus2">Genus 2</option>
                </select>

                <select name="species" id="species" style="width: 180px; padding:10px;" required>
                  <option value="" disabled selected>Pilih Spesies</option>
                  <option value="species1">Spesies 1</option>
                  <option value="species2">Spesies 2</option>
                </select>

                <select name="sub_species" id="sub_species" style="width: 180px; padding:10px;" required>
                  <option value="" disabled selected>Pilih Sub Spesies</option>
                  <option value="subspecies1">Sub Spesies 1</option>
                  <option value="subspecies2">Sub Spesies 2</option>
                </select>
              </div>
            </div>
          
            {{-- SATWA BERKELOMPOK --}}
            {{-- TOTAL SATWA KELOMPOK --}}
            <div id="form-total_satwa" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Total Satwa</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="total_satwa" id="total_satwa" placeholder="Total Satwa" style="width: 400px; padding:10px;" min="0" required>
            </div>
          </section>          
@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard-2.js') }}"></script>  
@endpush