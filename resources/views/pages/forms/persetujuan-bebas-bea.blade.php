@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Persetujuan Pembebasan BEA</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Persetujuan Pembebasan BEA untuk Barang Konservasi</h4>
        <form>
          <!-- NAMA LK & Wilayah UPT -->
          <div class="form-group row mb-3">
            <div class="col-md-6">
              <label for="nama_lk">Nama Lembaga Konservasi</label>
              <input type="text" class="form-control" id="nama_lk" name="nama_lk" placeholder="Masukkan nama lembaga konservasi" required>
            </div>
            <div class="col-md-6">
              <label for="wilayah_upt">Wilayah UPT</label>
              <select id="wilayah_upt" name="wilayah_upt" class="form-control" required>
                <option value="" hidden>Pilih Wilayah</option>
                @foreach($upt_wilayah as $upt)
                  <option value="{{ $upt->wilayah }}">{{ $upt->wilayah }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Nama Direktur -->
          <div class="form-group mb-3">
            <label for="nama_direktur">Nama Direktur</label>
            <input type="text" class="form-control" id="nama_direktur" name="nama_direktur" placeholder="Masukkan nama direktur" required>
          </div>

          <!-- NIB & NPWP -->
          <div class="form-group row mb-3">
            <div class="col-md-6">
              <label for="nib">Nomor Induk Berusaha (NIB)</label>
              <input type="text" class="form-control" id="nib" name="nib" placeholder="Isi dengan angka" pattern="^[0-9]{15}$" maxlength="15" required>
            </div>
            <div class="col-md-6">
              <label for="npwp">Nomor Pokok Wajib Pajak (NPWP)</label>
              <input type="text" class="form-control" id="npwp" name="npwp" placeholder="Isi dengan angka" pattern="^[0-9]{18}$" maxlength="18" required>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="abcd@gmail.com" required>
          </div>

          <!-- Jenis Barang -->
          <div class="form-group mb-3">
            <label>Pilih Jenis Barang</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_barang" id="satwa" value="satwa" required>
              <label class="form-check-label" for="satwa">Satwa</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_barang" id="tumbuhan" value="tumbuhan" required>
              <label class="form-check-label" for="tumbuhan">Tumbuhan</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_barang" id="pakan" value="pakan" required>
              <label class="form-check-label" for="pakan">Pakan</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_barang" id="peralatan_lk" value="peralatan_lk" required>
              <label class="form-check-label" for="peralatan_lk">Peralatan LK</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_barang" id="obat" value="obat" required>
              <label class="form-check-label" for="obat">Obat-obatan</label>
            </div>
          </div>

          <!-- Nama Barang & Jumlah Barang -->
          <div class="form-group row mb-3">
            <div class="col-md-6">
              <label for="nama_barang">Nama Barang</label>
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
            </div>
            <div class="col-md-6">
              <label for="jumlah_barang">Jumlah Barang</label>
              <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" placeholder="Masukkan jumlah barang" min="1" required>
            </div>
          </div>

          <!-- Negara Asal -->
          <div class="form-group mb-3">
            <label for="negara">Negara Asal</label>
            <select id="negara" name="negara" class="form-control" required>
              <option value="" hidden>Pilih Negara</option>
            </select>
          </div>

          <!-- Perkiraan Nilai Pabean -->
          <div class="form-group mb-3">
            <label for="nilaiPabean">Perkiraan Nilai Pabean</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
              </div>
              <input type="number" class="form-control" id="nilaiPabean" name="nilaiPabean" placeholder="Masukkan Nilai Pabean" min="0" required>
            </div>
          </div>

          <!-- Pelabuhan Masuk -->
          <div class="form-group mb-3">
            <label for="namaPelabuhan">Pelabuhan Masuk</label>
            <select id="namaPelabuhan" name="namaPelabuhan" class="form-control" required>
              <option value="" hidden>Pilih Nama Pelabuhan</option>
              <option value="pelabuhanA">Pelabuhan A</option>
              <option value="pelabuhanB">Pelabuhan B</option>
            </select>
          </div>

          <!-- Upload Surat -->
          <div class="form-group row mb-3">
            <div class="col-md-6">
              <label for="surat_permohonan">Upload Surat Permohonan</label>
              <input type="file" class="form-control" id="surat_permohonan" name="surat_permohonan" accept=".pdf,.docx,.jpg,.png,.jpeg" required>
            </div>
            <div class="col-md-6">
              <label for="surat_pernyataan">Upload Surat Pernyataan untuk Konservasi</label>
              <input type="file" class="form-control" id="surat_pernyataan" name="surat_pernyataan" accept=".pdf,.docx,.jpg,.png,.jpeg" required>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Ajukan Permohonan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
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

// Fungsi untuk mengambil dan mengurutkan data negara dari API
async function loadCountries() {
    try {
      // Memanggil API untuk daftar negara
      const response = await fetch('https://restcountries.com/v3.1/all');
      const countries = await response.json();
      
      // Mengurutkan negara berdasarkan nama secara alfabet
      const sortedCountries = countries.sort((a, b) => {
        const nameA = a.name.common.toUpperCase(); // Menggunakan nama negara untuk urutan
        const nameB = b.name.common.toUpperCase();
        if (nameA < nameB) {
          return -1;
        }
        if (nameA > nameB) {
          return 1;
        }
        return 0;
      });

      // Menambahkan opsi negara ke dalam elemen select
      const negaraSelect = document.getElementById('negara');
      sortedCountries.forEach(country => {
        const option = document.createElement('option');
        option.value = country.cca2;  // Kode negara 2 karakter
        option.textContent = country.name.common; // Nama negara
        negaraSelect.appendChild(option);
      });
    } catch (error) {
      console.error("Error fetching countries:", error);
    }
  }

  // Memuat negara ketika halaman dimuat
  loadCountries();
</script>

@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
  
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard-4.js') }}"></script>    
@endpush