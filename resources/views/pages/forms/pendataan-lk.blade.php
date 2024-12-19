@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan Lembaga Konservasi</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pendataan Lembaga Konservasi</h4>
        <div id="wizard">
          <h2>Informasi Lembaga Konservasi</h2>
          <section>
            {{-- NAMA LK --}}
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Nama Lembaga Konservasi</h5>
              <input type="text" name="nama_lk" id="nama_lk" placeholder="Masukkan nama lembaga konservasi" style="width: 400px; padding:10px;" required>
            </div>

            {{-- UPT --}}
            <div class="text-fields wilayah_upt" style="margin: 10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Pilih Wilayah UPT</h5>
              <select id="wilayah_upt" class="option-input upt-wilayah" name="wilayah_upt" required>
                <option value="" hidden>Pilih Wilayah</option>
                @foreach($upt_wilayah as $upt)
                  <option id="{{ $upt->wilayah }}" value="{{ $upt->wilayah }}">{{ $upt->wilayah }}</option>
                @endforeach
              </select>
            </div>

            {{-- FORM KODE POS DAN ALAMAT --}}
            <form id="stage2" action="{{ route('pendataan-lk2') }}" method="POST">
              @csrf
              <div class="stage2-content">

                {{-- KODE POS --}}
                <div class="text-fields kodepos" style="margin:10px 0px;">
                  <h5 style="margin-bottom:7px;">Kode Pos</h5>
                  <input type="text" name="kodepos" id="kodepos" placeholder="Isi Kode Pos Anda (5 digit)" required pattern="^[0-9]{5}$" title="Hanya boleh angka dan berjumlah 5 digit" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '');" style="width: 400px; padding:10px;" />
                </div>

                {{-- PROVINSI --}}
                <div class="text-fields provinsi" style="margin:10px 0px;">
                  <h5 style="margin-bottom:7px;">Provinsi</h5>
                  <input type="text" name="provinsi" id="provinsi" placeholder="Isi Provinsi" readonly style="width: 400px; padding:10px;" />
                </div>

                {{-- KOTA/KABUPATEN --}}
                <div class="text-fields kota_kab" style="margin:10px 0px;">
                  <h5 style="margin-bottom:7px;">Kota/Kabupaten</h5>
                  <input type="text" name="kota_kab" id="kota_kab" placeholder="Isi Kota/Kabupaten" readonly style="width: 400px; padding:10px;" />
                </div>

                {{-- KECAMATAN --}}
                <div class="text-fields kecamatan" style="margin:10px 0px;">
                  <h5 style="margin-bottom:7px;">Kecamatan</h5>
                  <input type="text" name="kecamatan" id="kecamatan" placeholder="Isi Kecamatan" readonly style="width: 400px; padding:10px;" />
                </div>

                {{-- KELURAHAN/ DESA --}}
                <div class="text-fields kelurahan" style="margin:10px 0px;">
                  <h5 style="margin-bottom:7px;">Kelurahan/Desa</h5>
                  <select id="kelurahan" class="option-input-kelurahan" name="kelurahan" required style="width: 400px; padding:10px;">
                    <option value="" hidden>Pilih Kelurahan/Desa</option>
                  </select>
                </div>

                {{-- ALAMAT LENGKAP --}}
                <div class="text-fields alamat_lengkap" style="margin:10px 0px;">
                  <h5 style="margin-bottom:7px;">Alamat Lengkap</h5>
                  <input type="text" name="alamat_lengkap" id="alamat_lengkap" placeholder="Alamat Lengkap" required style="width: 400px; padding:10px;" />
                </div>

              </div>
            </form>

            {{-- STATUS LK --}}
            <div id="form-status_lk" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Status Lembaga Konservasi</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_lk" id="status_lk_umum" value="umum" required>
                <label class="form-check-label" for="status_lk_umum">
                  Umum
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status_lk" id="status_lk_khusus" value="khusus" required>
                <label class="form-check-label" for="status_lk_khusus">
                  Khusus
                </label>
              </div>
            </div>

            {{-- BENTUK LK --}}
            <div id="form-bentuk_lk">
              <h5 style="margin-bottom:10px;">Bentuk Lembaga Konservasi</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bentuk_lk" id="kebun_binatang" value="kebun binatang" required>
                <label class="form-check-label" for="kebun_binatang">
                  Kebun Binatang
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bentuk_lk" id="taman_satwa" value="taman satwa" required>
                <label class="form-check-label" for="taman_satwa">
                  Taman Satwa
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bentuk_lk" id="taman_satwa_khusus" value="taman satwa khusus" required>
                <label class="form-check-label" for="taman_satwa_khusus">
                  Taman Satwa Khusus
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bentuk_lk" id="museum_zoologi" value="museum zoologi" required>
                <label class="form-check-label" for="museum_zoologi">
                  Museum Zoologi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bentuk_lk" id="taman_safari" value="taman safari" required>
                <label class="form-check-label" for="taman_safari">
                  Taman Safari
                </label>
              </div>
            </div>

            {{-- Pengelola --}}
            <div id="form-pengelola" style="margin-bottom: 10px">
              <h5 style="margin-bottom:10px;">Pengelola Lembaga Konservasi</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengelola" id="pengelola_pemda" value="pemda" required>
                <label class="form-check-label" for="status_lk_umum">
                  Pemda
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pengelola" id="pengelola_swasta" value="swasta" required>
                <label class="form-check-label" for="pengelola_swasta">
                  Swasta
                </label>
              </div>
            </div>

            {{-- Nama Pimpinan --}}
            <div id="form-nama_pimpinan" style="margin-bottom:10px;">
              <h5 style="margin-bottom:8px;">Nama Pimpinan</h5>
              <input type="text" name="nama_pimpinan" id="nama_pimpinan" placeholder="Masukkan nama pimpinan" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Legalitas Perizinan --}}
            <div id="form-legalitas" class="form-legalitas">
              <label for="additional_notes"><h5 style="margin: 10px;">Legalitas Perizinan LK</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="legalitas" name="legalitas" rows="4" placeholder="Masukkan legalitas perizinan LK" required></textarea>
            </div>

            {{-- Tahun Izin --}}
            <div id="form-tahun_izin" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Tahun Izin</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input type="text" name="tahun_izin" id="tahun_izin" placeholder="Masukkan tahun izin" pattern="^[0-9]{4}$" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Link SK --}}
            <div id="form-link_sk" style="margin-bottom:10px;">
              <h5 style="margin-bottom:8px;">Link SK</h5>
              <input type="url" name="link_sk" id="link_sk" placeholder="Masukkan link SK" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Apakah ada akreditasi? --}}
            <div id="form-akred" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah ada akreditasi?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="akreditasi" id="akreditasi_ya" value="ya" required>
                    <label class="form-check-label" for="akreditasi_ya">
                    Ya
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="akreditasi" id="akreditasi_tidak" value="tidak" required>
                    <label class="form-check-label" for="akreditasi)tidak">
                    Tidak
                    </label>
                </div>
            </div>           
            
            {{-- Tahun Akreditasi --}}
            <div id="form-tahun_akre" style="margin-bottom:10px;">
              <h5 style="margin-bottom:8px;">Tahun Akreditasi</h5>
              <input type="text" name="tahun_akre" id="tahun_akre" placeholder="Masukkan tahun akreditasi" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Nilai Akreditasi --}}
            <div id="form-nilai_akre" style="margin-bottom:10px;">
              <h5 style="margin-bottom:8px;">Nilai Akreditasi</h5>
              <input type="text" name="nilai_akre" id="nilai_akre" placeholder="Masukkan nilai akreditasi" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Apakah ada nomor tanggal surat? --}}
            <div id="form-no_surat" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah ada nomor tanggal surat?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_surat" id="no_surat_ya" value="ya" required>
                    <label class="form-check-label" for="no_surat_ya">
                    Ya
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_surat" id="no_surat_tidak" value="tidak" required>
                    <label class="form-check-label" for="no_surat_tidak">
                    Tidak
                    </label>
                </div>
            </div>

            {{-- No Tanggal Surat --}}
            <div id="form-no_tgl_surat" style="margin-bottom:10px;">
              <h5 style="margin-bottom:8px;">Nomor & Tanggal Surat</h5>
              <input type="text" name="no_tgl_surat" id="no_tgl_surat" placeholder="Masukkan nomor & tanggal surat" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Apakah ada nomor izin peroleh? --}}
            <div id="form-izin_peroleh" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah ada nomor izin peroleh?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="izin_peroleh" id="izin_peroleh_ya" value="ya" required>
                    <label class="form-check-label" for="izin_peroleh_ya">
                    Ya
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="izin_peroleh" id="izin_peroleh_tidak" value="tidak" required>
                    <label class="form-check-label" for="izin_peroleh_tidak">
                    Tidak
                    </label>
                </div>
            </div>

            {{-- No Izin Peroleh --}}
            <div id="form-no_izin" style="margin-bottom:10px;">
              <h5 style="margin-bottom:8px;">Nomor Izin Peroleh</h5>
              <input type="textarea" name="no_izin" id="no_izin" placeholder="Masukkan nomor izin peroleh" style="width: 400px; padding:10px;" required>
            </div>

            {{-- Apakah ada nomor izin peroleh TSL? --}}
            <div id="form-tsl" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah ada nomor izin perolehan TSL?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tsl" id="tsl_ya" value="ya" required>
                    <label class="form-check-label" for="tsl_ya">
                    Ya
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tsl" id="tsl_tidak" value="tidak" required>
                    <label class="form-check-label" for="tsl_tidak">
                    Tidak
                    </label>
                </div>
            </div>

            {{-- Izin Perolehan TSL --}}
            <div id="form-izin_tsl" class="form-izin-tsl">
              <label for="additional_notes"><h5 style="margin: 10px;">Izin Perolehan TSL</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="izin_tsl" name="izin_tsl" rows="4" placeholder="Isi disini..." required></textarea>
            </div>

            {{--Apakah ada perjanjian kerja sama? --}}
            <div id="form-pks" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah ada perjanjian kerja sama dengan LK lain?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pks_lk" id="pks_lk_ya" value="ya" required>
                    <label class="form-check-label" for="pks_lk_ya">
                    Ya
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pks_lk" id="pks_lk_tidak" value="tidak" required>
                    <label class="form-check-label" for="pks_lk_tidak">
                    Tidak
                    </label>
                </div>
            </div>

            {{-- PKS dengan LK Lain --}}
            <div id="form-pks_lk_lain" class="form-pks-lk-lain">
              <label for="additional_notes"><h5 style="margin: 10px;">Perjanjian Kerja Sama dengan LK Lain</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="pks" name="pks" rows="4" placeholder="Isi disini..." required></textarea>
            </div>
          </section>

          <h2>Data Investasi Lembaga Konservasi</h2>
          <section>  
            {{-- JUMLAH KARYAWAN LAKI2 --}}
            <div id="form-jmlh_karyawan_laki" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Karyawan Laki-laki</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="jmlh_laki" id="jmlh_laki" placeholder="Jumlah Karyawan Laki-laki" style="width: 400px; padding:10px;" min="0" required>
            </div>

            {{-- JUMLAH KARYAWAN PEREMPUAN --}}
            <div id="form-jmlh_karyawan_perempuan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Karyawan Perempuan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="jmlh_perempuan" id="jmlh_perempuan" placeholder="Jumlah Karyawan Perempuan" style="width: 400px; padding:10px;" min="0" required>
            </div>

            {{-- JUMLAH DOKTER HEWAN --}}
            <div id="form-jmlh_dh" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Dokter Hewan</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="jmlh_dh" id="jmlh_dh" placeholder="Jumlah Dokter Hewan" style="width: 400px; padding:10px;" min="0" required>
            </div>

            {{-- LUAS LAHAN KONSERVASI --}}
            <div id="form-luas_lahan" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Luas Lahan Konservasi</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="luas_lahan" id="luas_lahan" placeholder="Luas Lahan Konservasi" style="width: 400px; padding:10px;" min="0" required>
            </div>

            {{-- JUMLAH INVESTASI --}}
            <div id="form-jmlh_invest" style="margin-bottom:10px; padding-bottom:10px;">
              <h5 style="margin-bottom: 8px">Jumlah Investasi</h5>
              <span class="error-message" style="color: red; display: none;"></span>
              <input class="" type="number" name="jmlh_invest" id="jmlh_invest" placeholder="Jumlah Investasi" style="width: 400px; padding:10px;" min="0" required>
            </div>
            
          </section>          
        </div>

<!-- Menyertakan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
});
</script>

@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
  
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard-4.js') }}"></script>  
  <script src="{{ asset('assets/js/wizard-5.js') }}"></script>  
@endpush