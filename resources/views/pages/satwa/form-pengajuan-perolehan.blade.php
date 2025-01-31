@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/form-perolehan.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush

@section('content')
@php
$update = session('update',false);
@endphp

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pengajuan Satwa Perolehan {{ $update ?' - Update' : '' }}</li>
  </ol>
</nav>

@if ($update)
 <input type="text" id="update" value="{{ $update }}" hidden>
  
@endif

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    @include('components.notifikasi-action')
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h2>Pengajuan Satwa Perolehan{{ $update ?' - Update' : '' }}</h2>
          <div>
           @if (!$update)
           <button class="btn btn-warning" onclick="upload(this)">Upload</button>
           <button class="btn btn-info">Template Upload</button>
           @endif
          </div>
        </div>
       
        
        <form id="form-satwa" enctype="multipart/form-data" method="POST" action="{{ $update ? 
        route('satwa-perolehan.update',$data->id) : 
        route('satwa-perolehan.store', Auth::user()->id_lk) }}">
        {{-- route('satwa-perolehan.update',['id' => Crypt::encryptString($data->id)]) : 
        route('satwa-perolehan.store', ['id' => Crypt::encryptString(Auth::user()->id_lk)]) }}"> --}}
          @csrf
          @if ($update)
            @method('PUT')
          @endif
          
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <section>
            <div class="divide"></div>
          </section>
          
          <section>
            <div class="question" id="radio">
              <h4 class="label">Asal Satwa</h4>
              <div class="radio">
                <input type="radio" name="asal_satwa" id="indonesia" value="indonesia" 
                {{ ($update && $data->asal_satwa == 'indonesia') || old('asal_satwa') == 'indonesia' ? 'checked' : '' }} required>
                <label for="indonesia">Indonesia</label>
              </div>
              <div class="radio">
                <input type="radio" name="asal_satwa" id="asing" value="asing" 
                {{ ($update && $data->asal_satwa == 'asing') || old('asal_satwa') == 'asing' ? 'checked' : '' }} required>
                <label for="asing">Asing</label>
              </div>
            </div>
            <div class="question" id="radio">
              <h4 class="label">Status Perlindungan Satwa</h4>
              <div class="radio">
                <input type="radio" name="status_perlindungan" id="dilindungi" value="1"
                {{ ($update && $data->status_perlindungan == "1") || old('status_perlindungan') == "1" ? 'checked' : '' }} required>
                <label for="dilindungi">Dilindungi</label>
              </div>
              <div class="radio">
                <input type="radio" name="status_perlindungan" id="tidak_dilindngi" value="0" 
                {{ ($update && $data->status_perlindungan == "0") || old('status_perlindungan') == "0" ? 'checked' : '' }} required>
                <label for="tidak_dilindngi">Tidak Dilindungi</label>
              </div>
            </div>
          </section>

          <section>
            <input type="hidden" name="id_spesies" value ="{{ $update ? $data->id_spesies : old('id_spesies') }}">
              
            <div class="question" id="kolom4">
              <label class="label" for="taksa">Taksa</label>
              <input type="text" name="class" id="taksa" required
              placeholder ="Isi Nama Ilmiah"
              value="{{ $update ? $data->spesies->class : old('class') }}" readonly>
            </div>

            <div class="question" id="kolom4">
              <label class="label" for="scientific-name">Scientific Name</label>
              <input 
                type="text" 
                list="list_namaIlmiah" 
                name="nama_ilmiah" 
                id="input_ListSpecies" 
                placeholder="Cari Nama ilmiah Satwa" 
                required
                {{-- onblur="validateSelection(this)" --}}
                value="{{ $update ? $data->spesies->nama_ilmiah : old('nama_ilmiah') }}">
              <datalist id="list_namaIlmiah">
                @foreach($namaIlmiah as $ni)
                  <option value="{{ $ni->nama_ilmiah }}" id="{{ $ni->id }}" title="Tolong dipilih scientific name satwa!"></option>
                @endforeach
              </datalist>
            </div>
            <div class="question" id="kolom4">
              <label class="label" for="namaLokal">Nama Lokal</label>
              <input type="text" name="nama_lokal" id="namaLokal" required
              placeholder ="Isi Nama Ilmiah"
              value="{{ $update ? $data->spesies->nama_lokal : old('nama_lokal') }}" readonly>
            </div>
            <div class="question" id="kolom4">
              <label class="label" for="englishName">English Name</label>
              <input type="text" name="nama_internasional" id="englishName" required
              placeholder ="Isi Nama Ilmiah"
              value="{{ $update ? $data->spesies->nama_internasional : old('nama_internasional') }}" readonly>
            </div>
          </section>

          <section>
            <div class="question" id="kolom4">
              <label class="label" for="jumlahJantan">Jumlah Jantan</label>
              <input type="number" name="jumlah_jantan" id="jumlahJantan" required
              placeholder ="isi jumlah satwa jantan"
              value="{{ $update ? $data->jumlah_jantan : old('jumlah_jantan') }}">
            </div>
            <div class="question" id="kolom4">
              <label class="label" for="jumlahBetina">Jumlah Betina</label>
              <input type="number" name="jumlah_betina" id="jumlahBetina" required
              placeholder ="isi jumlah satwa betina"
              value="{{ $update ? $data->jumlah_betina : old('jumlah_betina') }}">
            </div>
            <div class="question" id="kolom4">
              <label class="label" for="jumlahUnknown">Jumlah Unknown</label>
              <input type="number" name="jumlah_unknown" id="jumlahUnknown" required
              placeholder ="isi jumlah satwa unknown"
              value="{{ $update ? $data->jumlah_unknown : old('jumlah_unknown') }}">
            </div>
            <div class="question" id="kolom4">
              <input type="hidden" name="nama_cara_perolehan" id="namaCaraPerolehan" value="{{ $update ? $data->id_cara_perolehan : old('cara_perolehan') }}">
              
              <label for="caraPerolehan" class="label"> Cara Perolehan</label>
              <select name="id_cara_perolehan" id="caraPerolehan">
                <option value="" hidden selected>Pilih Cara Perolehan</option>
                @foreach ($caraPerolehan as $cara )
                  <option value="{{ $cara->id }}"
                    @if ($update && $data->id_cara_perolehan == $cara->id)
                      selected
                      @elseif (old('id_cara_perolehan') == $cara->id) 
                          selected
                    @endif
                    >{{ $cara->nama }}</option>
                  
                @endforeach
              </select>
            </div>
           
          </section>

          <section>
            
            <div class="question file1" id="input_asal_satwa" style="display: none;">
              <input type="hidden" name="asal_lk" id="id_lk" >  
              <label for="asal_lk" class="label">Asal LK</label>
              <span id="error-message" style="color: red; display: none;">Tolong pilih salah satu lembaga konservasi</span>
              <input list="listlk" name="nama_asal_lk" id="asal_lk" placeholder="Pilih Asal LK" onblur="validateInput()" />
              <datalist id="listlk">
                @foreach ($listlk as $lk)
                  <option value="{{ $lk->nama }}" id="{{ $lk->id }}">
                @endforeach
              </datalist>
            </div>
          </section>

          <section>
            <div class="question file1" id="input_surat_permohonan" style="display: none;">  
              <label for="surat_permohonan" class="label">Surat permohonan</label> 
              @if($update && $data->doc_surat_permohonan)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_surat_permohonan) }}" target="_blank">{{ $data->doc_surat_permohonan }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_surat_permohonan" id="surat_permohonan" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_salinan_keputusan_pengadilan" style="display: none;">  
              <label for="salinan_keputusan_pengadilan" class="label">Salinan Keputusan Pengadilan Terhadap Spesimen hasil sitaan/BA hasil rampasan/BA acara secara sukarela dari Masyarakat</label> 
              @if($update && $data->doc_salinan_keputusan_pengadilan)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_salinan_keputusan_pengadilan) }}" target="_blank">{{ $data->doc_salinan_keputusan_pengadilan }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_salinan_keputusan_pengadilan" id="salinan_keputusan_pengadilan" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_berita_acara_pemeriksaan_sarana" style="display: none;">  
              <label for="berita_acara_pemeriksaan_sarana" class="label">Berita Acara Pemeriksaan Sarana & Prasarana</label> 
              @if($update && $data->doc_berita_acara_pemeriksaan_sarana)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_berita_acara_pemeriksaan_sarana) }}" target="_blank">{{ $data->doc_berita_acara_pemeriksaan_sarana }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_berita_acara_pemeriksaan_sarana" id="berita_acara_pemeriksaan_sarana" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_berita_acara_pemeriksaan_satwa" style="display: none;">  
              <label for="berita_acara_pemeriksaan_satwa" class="label">Berita ACARA pemeriksaan SATWA</label> 
              @if($update && $data->doc_berita_acara_pemeriksaan_satwa)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_berita_acara_pemeriksaan_satwa) }}" target="_blank">{{ $data->doc_berita_acara_pemeriksaan_satwa }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_berita_acara_pemeriksaan_satwa" id="berita_acara_pemeriksaan_satwa" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_surat_keterangan_kesehatan_satwa" style="display: none;">  
              <label for="surat_keterangan_kesehatan_satwa" class="label">Surat Keterangan Kesehatan Satwa</label> 
              @if($update && $data->doc_surat_keterangan_kesehatan_satwa)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_surat_keterangan_kesehatan_satwa) }}" target="_blank">{{ $data->doc_surat_keterangan_kesehatan_satwa }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_surat_keterangan_kesehatan_satwa" id="surat_keterangan_kesehatan_satwa" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_keterangan_asal_usul_silsilah_satwa" style="display: none;">  
              <label for="keterangan_asal_usul_silsilah_satwa" class="label">Keterangan Asal - Usul / Silsilah Satwa (BA Penitipan)</label> 
              @if($update && $data->doc_keterangan_asal_usul_silsilah_satwa)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_keterangan_asal_usul_silsilah_satwa) }}" target="_blank">{{ $data->doc_keterangan_asal_usul_silsilah_satwa }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_keterangan_asal_usul_silsilah_satwa" id="keterangan_asal_usul_silsilah_satwa" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_surat_keterangan_menerima_hibah" style="display: none;">  
              <label for="surat_keterangan_menerima_hibah" class="label">Surat keterangan Menerima Hibah</label> 
              @if($update && $data->doc_surat_keterangan_menerima_hibah)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_surat_keterangan_menerima_hibah) }}" target="_blank">{{ $data->doc_surat_keterangan_menerima_hibah }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_surat_keterangan_menerima_hibah" id="surat_keterangan_menerima_hibah" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_surat_keterangan_memberi_hibah" style="display: none;">  
              <label for="surat_keterangan_memberi_hibah" class="label">Surat Keterangan Memberi Hibah</label> 
              @if($update && $data->doc_surat_keterangan_memberi_hibah)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_surat_keterangan_memberi_hibah) }}" target="_blank">{{ $data->doc_surat_keterangan_memberi_hibah }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_surat_keterangan_memberi_hibah" id="surat_keterangan_memberi_hibah" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_dokumen_kerja_sama" style="display: none;">  
              <label for="dokumen_kerja_sama" class="label">Dokumen kerja sama</label> 
              @if($update && $data->doc_dokumen_kerja_sama)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_dokumen_kerja_sama) }}" target="_blank">{{ $data->doc_dokumen_kerja_sama }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_dokumen_kerja_sama" id="dokumen_kerja_sama" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_pnbp" style="display: none;">  
              <label for="pnbp" class="label">PNBP</label> 
              @if($update && $data->doc_pnbp)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_pnbp) }}" target="_blank">{{ $data->doc_pnbp }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_pnbp" id="pnbp" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_rekomendasi_kepala_b_bksda_asal_satwa" style="display: none;">  
              <label for="rekomendasi_kepala_b_bksda_asal_satwa" class="label">Rekomendasi Kepala BBKSDA/BKSDA asal satwa</label> 
              @if($update && $data->doc_rekomendasi_kepala_b_bksda_asal_satwa)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_rekomendasi_kepala_b_bksda_asal_satwa) }}" target="_blank">{{ $data->doc_rekomendasi_kepala_b_bksda_asal_satwa }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_rekomendasi_kepala_b_bksda_asal_satwa" id="rekomendasi_kepala_b_bksda_asal_satwa" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima" style="display: none;">  
              <label for="rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima" class="label">Rekomendasi Kepala BBKSDA/BKSDA domisili LK Pemohon/Penerima satwa</label> 
              @if($update && $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima) }}" target="_blank">{{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima" id="rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_rekomendasi_scientific_authority_appendix_i_cites" style="display: none;">  
              <label for="rekomendasi_scientific_authority_appendix_i_cites" class="label">Rekomendasi Scientific Authority untuk Appendix I CITES (Proses oleh KSG ke SKIKH BRIN)</label> 
              @if($update && $data->doc_rekomendasi_scientific_authority_appendix_i_cites)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_rekomendasi_scientific_authority_appendix_i_cites) }}" target="_blank">{{ $data->doc_rekomendasi_scientific_authority_appendix_i_cites }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_rekomendasi_scientific_authority_appendix_i_cites" id="rekomendasi_scientific_authority_appendix_i_cites" @if(!$update) required @endif>
          </div>
          
          <div class="question file1" id="input_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa" style="display: none;">  
              <label for="rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa" class="label">Rekomendasi Kepala BBKSDA/BKSDA domisili LK asal satwa</label> 
              @if($update && $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa)
                  <p>File yang sudah diunggah: 
                      <a href="{{ Storage::url($data->path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa) }}" target="_blank">{{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa }}</a>
                  </p>
              @endif
              <input type="file" accept="application/pdf" class="file" name="doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa" id="rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa" @if(!$update) required @endif>
          </div>
          
          </section>

          <section>
            <div class="question file1" id="dokumenlainnya" style="display: none">
              <label for="dokumen_lainnya" class="label">Dokumen Lainnya</label>
              @if($update && $data->dokumen_lainnya)
              @php
                  $dokumen = json_decode($data->dokumen_lainnya);
              @endphp
              <p class="mt-2"><strong>File yang sudah diunggah:</strong></p>
              <ul id="uploadedDocuments" class="list-group mt-2">
                  @foreach ($dokumen as $index => $doc)
                      <li class="list-group-item d-flex justify-content-between align-items-center" style="width:50% !important;" id="doc-{{ $index }}">
                          <a href="{{ Storage::url($doc->path) }}" target="_blank" class="text-primary">
                               {{ $doc->nama }}
                          </a>
                          <button type="button" class="btn btn-danger btn-sm deleteDocBtn" style="padding: 5px" data-id="{{ $data->id }}" data-path="{{ $doc->path }}">
                              <i data-feather="trash-2"></i> 
                          </button>
                      </li>
                  @endforeach
              </ul>
          @endif
          
                    
                <div id="dokumenContainer">
                  <div class="inputContainer">
                    <input type="file" name="dokumen_lainnya[]" id="doc_lainnya" class="file" accept="application/pdf">
                    <button type="button" class="btn btn-warning clearDokumenBtn" id="clearDokumenBtn">Clear</button>
                    <button type="button" class="btn btn-info" id="addDokumenBtn">Add Dokumen</button>
                    {{-- <button type="button" class="btn btn-primary" id="addDokumenBtn">Add Dokumen</button> --}}
                    <button type="button" class="btn btn-danger deleteDokumenBtn" style="display:none;">Delete</button>
                  </div>
                </div>
              </div>
          </section>

          <section>
            <div class="form-group text-right" style="width:fit-content; display:flex; flex-direction:row; gap:10px;">
              <button type="submit" class="btn btn-primary">{{$update ? 'Simpan Perubahan' : 'Ajukan Permohonan' }}</button>
              @if ($update)
              <button type="button" id="submit-btn"  class="btn btn-danger" onclick="cancel()">Cancel</button>
            @endif
            </div>
          </section>
            
          
          

          
        </form>

      </div>
      </div>
  </div>
</div>

@endsection

@push('plugin-scripts') 
<script src="{{ asset('assets/js/form-pengajuan-perolehan.js') }}"></script>

@endpush

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- <script>
 document.addEventListener("DOMContentLoaded", function () {
    feather.replace();

    const documentList = document.getElementById("uploadedDocuments");

    documentList.addEventListener("click", function (event) {
        if (event.target.closest(".deleteDocBtn")) {
            const button = event.target.closest(".deleteDocBtn");
            const docId = button.getAttribute("data-id");
            const docPath = button.getAttribute("data-path");
            const listItem = document.getElementById(`doc-${docId}`);

            if (confirm("Apakah Anda yakin ingin menghapus dokumen ini?")) {
                fetch(`/delete-document`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ path: docPath, data_id: docId }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            if (listItem) {
                                listItem.remove();
                            }
                            alert(`Dokumen "${data.deleted_doc.nama}" berhasil dihapus.`);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan saat menghapus dokumen.");
                    });
            }
        }
    });
});

</script> --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    feather.replace();

    const documentList = document.getElementById("uploadedDocuments");

    if (documentList) {
        documentList.addEventListener("click", function (event) {
            if (event.target.closest(".deleteDocBtn")) {
                const button = event.target.closest(".deleteDocBtn");
                const docId = button.getAttribute("data-id");
                const docPath = button.getAttribute("data-path");
                const listItem = button.closest("li");

                if (confirm("Apakah Anda yakin ingin menghapus dokumen ini?")) {
                    fetch(`/delete-document`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ path: docPath, data_id: docId }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                if (listItem) {
                                    listItem.remove();
                                }
                                // alert(`Dokumen "${data.deleted_doc.nama}" berhasil dihapus.`);
                            } else {
                                alert("Gagal menghapus dokumen: " + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan saat menghapus dokumen.");
                        });
                }
            }
        });
    }
});

</script>
@endpush