@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/pendataan-popup.css') }}">
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
                {{-- Tanggal Titipan --}}
                <div id="form-tanggal_titipan" style="margin-bottom:10px; padding-bottom:10px;">
                  <h5 style="margin-bottom: 8px">Tanggal Titipan</h5>
                  <span class="error-message" style="color: red; display: none;"></span>
                  <input type="date" name="tanggal_titipan" id="tanggal_titipan" placeholder="Masukkan tanggal titipan" style="width: 400px; padding:10px;" required>
                </div>
  
                {{-- NO BA Titipan --}}
                <div id="form-no_ba_titipan" style="margin-bottom:10px; padding-bottom:10px;">
                  <h5 style="margin-bottom: 8px">No. BA Titipan</h5>
                  <span class="error-message" style="color: red; display: none;"></span>
                  <input class="" type="text" name="no_ba_titipan" id="no_ba_titipan" placeholder="Masukkan nomor berita acara titipan satwa" style="width: 400px; padding:10px;" required>
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

              {{-- JENIS TAGGING --}}
              <div id="form-jenis_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Jenis Tagging</h5>
                <div style="display: flex; gap: 10px;">
                  <select name="jenis_tagging" id="jenis_tagging" style="width: 180px; padding:10px;">
                    <option value="" disabled selected>Pilih Jenis Tagging</option>
                    <option value="ring">Ring</option>
                    <option value="chip">Chip</option>
                    <option value="eartag">Eartag</option>
                    <option value="label">Label</option>
                    <option value="tattoo">Tattoo</option>
                  </select>
                </div>
              </div>           
                        
              <div id="form-kode_tagging" style="margin-bottom:10px; padding-bottom:10px;">
                <h5 style="margin-bottom: 8px">Kode Tagging</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <input class="" type="text" name="kode_tagging" id="kode_tagging" placeholder="Masukkan kode " style="width: 400px; padding:10px;" required>
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

              <div id="form-status_satwa" style="margin-bottom: 10px">
                <h5 style="margin-bottom:10px;">Apakah Satwa Masihh Hidup?</h5>
                <span class="error-message" style="color: red; display: none;"></span>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status_satwa" id="status_satwa_ya" value="ya" required>
                  <label class="form-check-label" for="status_satwa_ya">
                    Hidup
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status_satwa" id="status_satwa_tidak" value="tidak" required>
                  <label class="form-check-label" for="status_satwa_tidak">
                    Mati
                  </label>
                </div>
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
                     
            </form>
          </section>    

        </div>

        <div id="popup-warning" class="popup">
          <div class="popup-content">
              <p>Isi semua kolom jika ingin melanjutkan pertanyaan.</p>
              <button id="close-popup">Tutup</button>
          </div>
        </div>
@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>  
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/pendataan-satwa.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard.js') }}"></script>  
@endpush