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
            <form id="pendataan1" method="POST" action="{{ route('satwa.store') }}">
              @csrf
              {{-- NAMA LK --}}
              @if ($user->role && $user->role->tag == 'LK')           
              <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
                  <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
                  <input type="text" name="nama_lk_display" id="nama_lk_display" placeholder="Lembaga Konservasi" 
                        style="width: 400px; padding:10px; background-color:white !important;" value="{{ $user->lk->nama }}" readonly required>
                  <input type="hidden" name="lk_id" id="lk_id" value="{{ $user->lk->id }}" required>
              </div>
              @else
              <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
                  <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
                  <input list="lk_options" name="nama_lk_display" id="nama_lk_display" placeholder="Cari Lembaga Konservasi" 
                        style="width: 400px; padding:10px; background-color:white;" required>
                  <datalist id="lk_options" style="background-color: white;">
                      @foreach($lks as $lk)
                      <option value="{{ $lk->nama }}"></option>
                      @endforeach
                  </datalist>
                  <input type="hidden" name="lk_id" id="lk_id">
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
                    <input class="form-check-input" type="radio" name="jenis_koleksi" id="satwa_koleksi" value="satwa koleksi" required>
                    <label class="form-check-label" for="satwa_koleksi">
                      Satwa Koleksi
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_koleksi" id="satwa_titipan" value="satwa titipan" required>
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
            </form>   
          </section>

          <h2>Data-data Satwa</h2>
          <section>  
            <form id="pendataan2" method="POST" action="{{ route('satwa.store') }}">
              @csrf       
              {{-- PERILAKU SATWA --}}
              <div id="form-perilaku_satwa" style="margin-bottom: 10px">
                <h5 style="margin-bottom:10px;">Apakah Satwa Memiliki Perilaku Berkelompok/Individu?</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa_ya" value="1" required>
                  <label class="form-check-label" for="perilaku_satwa_ya">
                    Berkelompok
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="perilaku_satwa" id="perilaku_satwa_tidak" value="0" required>
                  <label class="form-check-label" for="perilaku_satwa_tidak">
                    Individu
                  </label>
                </div>
              </div>
            
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
            
              <div id="form-alasan_belum_tagging" class="form-alasan_belum_tagging" style="margin-bottom: 10px">
                <label for="additional_notes"><h5>Alasan satwa belum dilakukan tagging</h5></label>
                <span class="error-message" style="color: red; display: none;"></span>
                <textarea class="form-control" id="alasan_belum_tagging" name="alasan_belum_tagging" rows="4" placeholder="Alasan..." required></textarea>
              </div>
            
          
                        
              <div id="form-ba_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Berita Acara Tagging</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="ba_tagging" id="ba_tagging" placeholder="Masukkan berita acara" style="width: 400px; padding:10px;" required>
              </div>
            
              <div id="form-tanggal_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Tanggal Tagging</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="date" name="tanggal_tagging" id="tanggal_tagging" style="width: 400px; padding:10px;" required>
              </div>
            
              <div id="form-no_ba_titipan" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">No. BA Titipan</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="no_ba_titipan" id="no_ba_titipan" placeholder="Masukkan nomor berita acara titipan satwa" style="width: 400px; padding:10px;" required>
              </div>
            
              <div id="form-no_ba_kelahiran" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">No. BA Kelahiran</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="no_ba_kelahiran" id="no_ba_kelahiran" placeholder="Masukkan nomor berita acara kelahiran satwa" style="width: 400px; padding:10px;" required>
              </div>
            
              <div id="form-no_ba_kematian" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">No. BA Kematian</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="no_ba_kematian" id="no_ba_kematian" placeholder="Masukkan nomor berita acara kematian satwa" style="width: 400px; padding:10px;" required>
              </div>
                    
              <div id="form-validasi_tanggal" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Validasi Tanggal</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="date" name="validasi_tanggal" id="validasi_tanggal" style="width: 400px; padding:10px;" required>
              </div>
            
              <div id="form-tahun_titipan" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Tahun Titipan</h5>
                <span class="error-message" style="color: red; display: none;">Masukkan tahun dalam format yang benar (4 digit)</span>
                <input type="text" name="tahun_titipan" id="tahun_titipan" pattern="^[0-9]{4}$" placeholder="Masukkan tahun" style="width: 400px; padding:10px;" required>
              </div>

              <div id="form-keterangan" class="form-keterangan" style="margin-bottom: 10px">
                <label for="additional_notes"><h5>Keterangan</h5></label>
                <span class="error-message" style="color: red; display: none;"></span>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan..." required></textarea>
              </div>
            
              <div id="form-nama_satwa_ina" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Nama Satwa dalam Bahasa Indonesia</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="nama_satwa_ina" id="nama_satwa_ina" placeholder="Masukkan nama satwa dalam bahasa Indonesia" style="width: 400px; padding:10px;" required>
              </div>
            
              <div id="form-nama_panggilan" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Nama Panggilan Satwa</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Masukkan nama panggilan satwa" style="width: 400px; padding:10px;" required>
              </div>
            
             
            </form>
          </section>    
          
          <h2>Genealogy</h2>
          <section>
            <form id="pendataan3" method="POST" action="{{ route('satwa.store') }}">
              @csrf
              <div>
                <h4 style="margin-bottom: 8px !important;">Anggota Keluarga Satwa</h4>
                <div class="grid grid-cols-12 gap-4 items-center mb-4" style="display: grid !important; grid-template-columns: repeat(12, 1fr) !important; gap: 1rem !important;">
                  <div class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="id_ayah" class="block text-sm font-extrabold text-black-700">Nama Ayah Satwa</label>
                    <input 
                      class="w-full border border-black-300 rounded-md p-2" 
                      type="text" 
                      name="id_ayah" 
                      id="id_ayah" 
                      placeholder="Masukkan nama ayah satwa" 
                      style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" 
                      required
                    >
                  </div>
                  <div class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="id_ibu" class="block text-sm font-extrabold text-black-700">Nama Ibu Satwa</label>
                    <input 
                      class="w-full border border-gray-300 rounded-md p-2" 
                      type="text" 
                      name="id_ibu" 
                      id="id_ibu" 
                      placeholder="Masukkan nama ibu satwa" 
                      style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" 
                      required
                    >
                  </div>
                </div>
                <div class="grid grid-cols-12 gap-4 items-center" style="display: grid !important; grid-template-columns: repeat(12, 1fr) !important; gap: 1rem !important;">
                  <div class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="id_anak" class="block text-sm font-extrabold text-black-700">Nama Anak Satwa</label>
                    <input 
                    class="w-full border border-black-300 rounded-md p-2" 
                    type="text" 
                      name="id_anak" 
                      id="id_anak" 
                      placeholder="Masukkan nama anak satwa" 
                      style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" 
                      required
                    >
                  </div>
                  <div class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="id_pasangan" class="block text-sm font-extrabold text-black-700">Nama Pasangan Satwa</label>
                    <input 
                      class="w-full border border-gray-300 rounded-md p-2" 
                      type="text" 
                      name="id_pasangan" 
                      id="id_pasangan" 
                      placeholder="Masukkan nama pasangan satwa" 
                      style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" 
                      required
                      >
                    </div>
                  </div>
                </div>
              <div>
                <h4 style="margin-bottom: 8px !important; margin-top:10px !important">Pasangan Satwa</h4>
                <div class="grid grid-cols-12 gap-4 items-center mb-4" style="display: grid !important; grid-template-columns: repeat(12, 1fr) !important; gap: 1rem !important;">
                  <div class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="id_jantan" class="block text-sm font-extrabold text-black-700">Nama Satwa Jantan</label>
                    <input class="w-full border border-black-300 rounded-md p-2" type="text" name="id_jantan" id="id_jantan" placeholder="Masukkan nama satwa jantan" style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" required
                    >
                  </div>
                  <div class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="id_betina" class="block text-sm font-extrabold text-black-700">Nama Satwa Betina</label>
                    <input class="w-full border border-gray-300 rounded-md p-2" type="text" name="id_betina" id="id_betina" placeholder="Masukkan nama satwa betina" style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" required
                    >
                  </div>
                </div>
                {{-- SATWA DIPISAHKAN/DIPASANGKAN --}}
                <div id="form-confirm_satwa" style="margin-bottom: 10px">
                  <h5 style="margin-bottom:10px;">Apakah Satwa Sudah Dipasangkan/Dipisahkan?</h5>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="satwa_status" id="satwa_dipasangkan" value="dipasangkan" required>
                      <label class="form-check-label" for="satwa_dipasangkan">
                          Dipasangkan
                      </label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="satwa_status" id="satwa_dipisahkan" value="dipisahkan" required>
                      <label class="form-check-label" for="satwa_dipisahkan">
                          Dipisahkan
                      </label>
                  </div>
              </div>
              
                <div class="grid grid-cols-12 gap-4 items-center" style="display: grid !important; grid-template-columns: repeat(12, 1fr) !important; gap: 1rem !important;">
                  <div id="form-tanggal-dipasangkan" class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="tanggal_dipasangankan" class="block text-sm font-extrabold text-black-700">Tanggal Dipasangkan</label>
                    <input class="w-full border border-black-300 rounded-md p-2" type="date" name="tanggal_dipasangankan" id="tanggal_dipasangankan" style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" required
                    >
                  </div>
                  <div id="form-tanggal-dipisahkan" class="col-span-6" style="grid-column: span 6 / span 6 !important;">
                    <label for="tanggal_dipisahkan" class="block text-sm font-extrabold text-black-700">Tanggal Dipisahkan</label>
                    <input class="w-full border border-gray-300 rounded-md p-2" type="date" name="tanggal_dipisahkan" id="tanggal_dipisahkan" style="width: 100% !important; padding: 10px !important; box-sizing: border-box !important;" required
                    >
                  </div>
                </div>
              </div>
              <div id="form-keterangan-couple" class="form-keterangan-couple" style="padding-bottom: 15px !important; margin-top:10px !important">
                <label for="additional_notes"><h4>Keterangan</h4></label>
                <textarea class="form-control" id="keterangan_couple" name="keterangan_couple" rows="4" placeholder="Keterangan..." required></textarea>
              </div>
            </form>
          </section>
        </div>
        <button type="button" onclick="h(this.form)">Submit All</button>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
              const form = document.getElementById('pendataan1');
          
              form.addEventListener('submit', function(event) {
                  event.preventDefault(); // Prevent the default form submission
          
                  const formData = new FormData(form); // Create a FormData object from the form
          
                  fetch('/satwas', {
                      method: 'POST',
                      body: formData,
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token
                      }
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          alert(data.message); // Display success message
                          form.reset(); // Reset the form
                      } else {
                          // Handle validation errors
                          const errorMessages = document.querySelectorAll('.error-message');
                          errorMessages.forEach(msg => msg.style.display = 'none'); // Hide previous error messages
                          
                          for (const [key, value] of Object.entries(data.errors)) {
                              const errorMessageElement = document.querySelector(`#${key}`).nextElementSibling;
                              errorMessageElement.textContent = value[0]; // Show error message next to the input field
                              errorMessageElement.style.display = 'block'; // Display the error message
                          }
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      alert('An error occurred while submitting the form.');
                  });
              });
          });
        </script>
@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">></script> --}}
  
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/pendataan-satwa.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard-2.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard-3.js') }}"></script>  
@endpush