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
        {{-- <p class="text-muted mb-3">Read the <a href="http://www.jquery-steps.com/GettingStarted" target="_blank"> Official jQuery Steps Documentation </a>for a full list of instructions and other options.</p> --}}
        <div id="wizard">
          <h2>Informasi Status Satwa</h2>
          <section>
            {{-- NAMA LK --}}
           @if ($user->role && $user->role->tag == 'LK')           
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
              <input class="" type="text" name="nama_lk" id="nama_lk" placeholder="Lembaga Konservasi" style="width: 400px; padding:10px;" value="{{ $user->lk->id }}" >
              {{-- <div id="nama_lk" style="width: 400px; padding:10px; outline:1px solid rgb(120, 119, 119); color:rgb(120, 119, 119);">
                Lembaga Konservasi
              </div> --}}
            </div>
            @else
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
              <input class="" type="text" name="{{ $user->lk->slug ?? '-' }}" id="{{ $user->lk->id ?? '-' }}" placeholder="Lembaga Konservasi" style="width: 400px; padding:10px;" value="{{ $user->lk->name ?? '-' }}">
              {{-- <div id="nama_lk" style="width: 400px; padding:10px; outline:1px solid rgb(120, 119, 119); color:rgb(120, 119, 119);">
                Lembaga Konservasi
              </div> --}}
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
              {{-- <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_koleksi" id="jenis_koleksi">
                <label class="form-check-label">
                  Koleksi TWSL
                </label>
              </div> --}}
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
              <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm_no_sats-ln" id="confirm_no_sats-ln" value="Tidak">
                <label class="form-check-label">
                  Tidak ada
                </label>
              </div>
            </div>

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
          <section>
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
          
            {{-- JENIS KELAMIN SATWA --}}
            <div id="form-jenis_kelamin" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Jenis kelamin satwa?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="Ya">
                <label class="form-check-label">
                  Jantan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="Ya">
                <label class="form-check-label">
                  Betina
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="Tidak">
                <label class="form-check-label">
                  Belum diketahui
                </label>
              </div>
            </div>

            {{-- JUMLAH KESELURUHAN HEWAN --}}
            <div id="form-jumlah_keseluruhan_gender" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Keseluruhan Gender</h5>
              <div style="display: flex; gap: 10px;">
                <input type="number" name="jumlah_keseluruhan_gender" id="jumlah_keseluruhan_gender" placeholder="Jumlah seluruh hewan" style="width: 180px; padding:10px;" min="0">
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
            <div id="form-alasan_belum_tagging" class="form-alasan_belum_tagging" style="margin-bottom: 10px">
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
            <div id="form-keterangan" class="form-keterangan" style="margin-bottom: 10px">
              <label for="additional_notes"><h5>Keterangan</h5></label>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan..."></textarea>
            </div>
          
            {{-- SATWA INDIVIDU --}}
            {{-- NAMA SATWA DALAM INDONESIA --}}
            <div id="form-nama_satwa_ina" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA SATWA DALAM INDONESIA</h5>
              <input class="" type="text" name="nama_satwa_ina" id="nama_satwa_ina" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div>
          
            {{-- NAMA PANGGILAN SATWA --}}
            <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">NAMA PANGGILAN SATWA</h5>
              <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;">
            </div>
          
            {{-- TAKSON SATWA --}}
            <div id="takson_hewan" class="takson-hewan" style="padding-bottom: 20px;">
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
                    <select name="jenis_tagging" id="jenis_tagging" style="width: 180px; padding:10px;">
                      <option value="" disabled selected>Pilih Jenis Tagging</option>
                      <option value="ring">Ring</option>
                      <option value="chip">Chip</option>
                      <option value="eartag">Eartag</option>
                      <option value="label">Label</option>
                      <option value="tattoo">Tattoo</option>
                    </select>
                    {{-- <a class="dropdown-item" href="#">Action 3</a>
                    <a class="dropdown-item" href="#">Another action 3</a>
                    <a class="dropdown-item" href="#">Something else here 3</a> --}}
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
          
            {{-- SATWA BERKELOMPOK --}}
            {{-- TOTAL SATWA KELOMPOK --}}
            <div id="form-total_satwa" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Total Satwa</h5>
              <input class="" type="number" name="total_satwa" id="total_satwa" placeholder="Total Satwa" style="width: 400px; padding:10px;" min="0">
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