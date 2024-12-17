@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
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
        <div id="wizard">
          <!-- Wizard Form -->
          <h2>Informasi Silsilah Satwa</h2>
          <section>

            {{-- Nama Satwa --}}
            <div class="form-group">
            <h5 style="margin:10px;">Nama Satwa?</h5>
              <select class="form-control" id="namaSatwa" name="namaSatwa" required>
                <option value="" disabled selected>Pilih Nama Satwa</option>
                <option value="1">Jaka - Harimau Sumatera</option>
                <option value="2">Rudi - Beruang</option>
                <option value="3">Bimo - Orang Utan</option>
              </select>
            </div>

            {{-- Nama Ayah --}}
            <div class="form-group">
            <h5 style="margin:10px;">Nama Ayah?</h5>
              <select class="form-control" id="namaAyah" name="namaAyah" required>
                <option value="" disabled selected>Pilih Nama Ayah</option>
                <option value="1">Kiko</option>
                <option value="2">Petruk</option>
                <option value="3">Bima</option>
              </select>
            </div>

            {{-- Nama Ibu --}}
            <div class="form-group">
            <h5 style="margin:10px;">Nama Ibu?</h5>
              <select class="form-control" id="namaIbu" name="namaIbu" required>
                <option value="" disabled selected>Pilih Nama Ibu</option>
                <option value="1">Sinta</option>
                <option value="2">Sari</option>
                <option value="3">Maya</option>
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
                <option value="" disabled selected>Pilih Pasangan</option>
                <option value="1">Aya - Harimau Sumatera</option>
                <option value="2">Ira - Beruang</option>
                <option value="3">Miya - Orang Utan</option>
              </select>
            </div>

            {{-- Tanggal Dipasangkan --}}
            <div class="form-group" id="form-tanggal-dipasangkan" style="display: none;">
            <h5 style="margin:10px;">Tanggal Dipasangkan</h5>
              <input type="date" class="form-control" id="tanggalDipasangkan" name="tanggalDipasangkan" required>
            </div>

            {{-- Punya anak --}}
            <div id="form-punya-anak" style="margin-bottom: 10px;">
                <h5 style="margin:10px;">Apakah satwa memiliki anak?</h5>
                <span class="error-message" style="color: red; display: none;"></span> 
                
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
                <option value="" disabled selected>Pilih Anak</option>
                <option value="1">Aya - Harimau Sumatera</option>
                <option value="2">Sari - Beruang</option>
                <option value="3">Maya - Orang Utan</option>
              </select>
            </div>

            {{--Apakah pasangan sudah dipisahkan? --}}
            <div id="form-dipisahkan" style="margin-bottom: 10px;">
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
            </div>

            {{-- Tanggal Dipisahkan --}}
            <div class="form-group" id="form-tanggal-dipisahkan" style="display: none;">
            <h5 style="margin:10px;">Tanggal Dipisahkan</h5>
              <input type="date" class="form-control" id="tanggalDipisahkan" name="tanggalDipisahkan" required>
            </div>

            {{-- Alasan Dipisahkan --}}
            <div id="form-alasan-pisah" class="form-alasan-pisah" style="display: none;">
              <label for="additional_notes"><h5 style="margin: 10px;">Alasan Dipisahkan</h5></label>
              <span class="error-message" style="color: red; display: none;"></span>
              <textarea class="form-control" id="alasan" name="alasan" rows="4" placeholder="Alasan..." required></textarea>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>

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

    $(document).ready(function () {

    // Fungsi untuk mengambil data dan mengisi dropdown
    function fetchDataAndPopulateSelect(endpoint, selectId) {
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="" disabled selected>Pilih Data</option>';
                data.forEach(item => {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
                $(selectId).html(options);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Ambil data Nama Satwa
    fetchDataAndPopulateSelect('/api/nama-satwa', '#namaSatwa');

    // Ambil data Nama Ayah
    fetchDataAndPopulateSelect('/api/nama-ayah', '#namaAyah');

    // Ambil data Nama Ibu
    fetchDataAndPopulateSelect('/api/nama-ibu', '#namaIbu');

    // Ambil data Pasangan (Jika sudah punya pasangan)
    $('#status_sudah').on('change', function () {
        fetchDataAndPopulateSelect('/api/pasangan', '#pasangan');
    });

    // Ambil data Anak (Jika sudah punya anak)
    $('#punya_anak_ya').on('change', function () {
        fetchDataAndPopulateSelect('/api/anak', '#anak');
    });

    // Tampilkan form tanggal dipasangkan jika ada pasangan
    $('#form-pasangan').on('change', function () {
        if ($('#pasangan').val()) {
            $('#form-tanggal-dipasangkan').show();
        }
    });

    // Tampilkan form tanggal dipisahkan jika dipisahkan
    $('#dipisahkan_sudah').on('change', function () {
        if ($('#dipisahkan_sudah').prop('checked')) {
            $('#form-tanggal-dipisahkan').show();
        }
    });
    });

</script>

<script>
  document.getElementById('namaSatwa').addEventListener("input", debounce(getSilsilah,1000));

  function getSilsilah(){
    let namaSatwa = document.getElementById('namaSatwa').value;

    if(namaSatwa.length === 3){
      
    }
  }
</script>
@endsection

@push('plugin-scripts') 
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard-3.js') }}"></script>
@endpush
