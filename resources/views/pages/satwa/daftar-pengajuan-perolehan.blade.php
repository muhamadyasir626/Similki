@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar @if(!$status) Pengajuan @endif  Satwa Perolehan </li>
  </ol>
</nav>
@include('components.notifikasi-action')

@php
$satwaTitipan = session('satwaPerolehan') ?? $satwaPerolehan;
$role = Auth::user()->role->tag;
@endphp

<div class="row">
  @include('components.notifikasi-action')
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body" id="form-card-body">
        <h6 class="card-title">Daftar @if(!$status) Pengajuan @endif  Satwa Perolehan</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <div class="searchbar">
              <form action="{{ route('search-satwa-perolehan') }}" method="GET" class="mb-4">
                <div class="input-group">
                  <input type="text" name="query" class="form-control"  placeholder="{{ $query?? 'Cari satwa...' }}"  onfocus="showHint(this)" onblur="hideHint()">
                  {{-- <div id="hint" style="display: none; position: absolute; background-color: #f0f0f0; padding: 5px; border: 1px solid #ccc;">
                    Pencarian untuk Nama panggilan, kode tagging, SK dirjen dan SK kepala Balai.
                  </div> --}}
                  {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
                </div>
              </form>
            </div>
            <thead>
                <tr>
                    <th style="text-align: center;">Nama LK</th>
                    <th style="text-align: center;">Cara Perolehan</th>
                    <th style="text-align: center;">Asal Satwa</th>
                    <th style="text-align: center;">Status Pelindungan</th>
                    <th style="text-align: center;">Nama Ilmiah</th>
                    <th style="text-align: center;">Nama Lokal</th>
                    <th style="text-align: center;">Asal LK</th>
                    <th style="text-align: center;">Jumlah Jantan</th>
                    <th style="text-align: center;">Jumlah Betina</th>
                    <th style="text-align: center;">Jumlah Unknown</th>

                    <th style="text-align: center;">Surat permohonan</th>
                    <th style="text-align: center;">Salinan Keputusan Pengadilan Terhadap Spesimen hasil sitaan/BA hasil rampasan/BA acara secara sukarela dari Masyarakat</th>
                    <th style="text-align: center;">Berita Acara Pemeriksaan Sarana & Prasarana</th>
                    <th style="text-align: center;">Berita ACARA pemeriksaan SATWA</th>
                    <th style="text-align: center;">Surat Keterangan Kesehatan Satwa</th>
                    <th style="text-align: center;">Keterangan Asal - Usul / Silsilah Satwa (BA Penitipan)</th>
                    <th style="text-align: center;">Surat keterangan Menerima Hibah</th>
                    <th style="text-align: center;">Surat Keterangan Memberi Hibah</th>
                    <th style="text-align: center;">Dokumen kerja sama</th>
                    <th style="text-align: center;">PNBP</th>
                    <th style="text-align: center;">Rekomendasi Kepala BBKSDA/BKSDA asal satwa</th>
                    <th style="text-align: center;">Rekomendasi Kepala BBKSDA/BKSDA domisili LK Pemohon/Penerima satwa</th>
                    <th style="text-align: center;">Rekomendasi Scientific Authority untuk Appendix I CITES (Proses oleh KSG ke SKIKH BRIN)</th>
                    <th style="text-align: center;">Rekomendasi Kepala BBKSDA/BKSDA domisili LK asal satwa</th>
                    <th style="text-align: center;">Dokumen Lainnya</th>

                    
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach($satwaPerolehan as $satwa)
                    <tr>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->lk->nama ? $satwa->lk->nama : '')) }}</td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->caraperolehan->nama))}}</td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->asal_satwa))}}</td>
                        <td style="text-align: center;">
                          @if ($satwa->status_pelindungan == 1)
                            Dilindungi
                            @else
                            Tidak Dilindungi
                          @endif
                          </td>
                        <td style="text-align: center;"><i>{{ Str::ucfirst(trans($satwa->spesies->nama_ilmiah))}}</i></td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->spesies->nama_lokal))}}</td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->asallk->nama ?? '-'))}}</td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->jumlah_jantan))}}</td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->jumlah_betina))}}</td>
                        <td style="text-align: center;">{{ Str::ucfirst(trans($satwa->jumlah_unknown))}}</td> 
                        <td>
                          {{ $satwa->doc_surat_permohonan ?? '-' }} 
                          @if ($satwa->doc_surat_permohonan)
                              - <a href="{{  Storage::url($satwa->path_surat_permohonan) }}" target="_blank">Lihat Dokumen</a>
                          @endif
                      </td>
                      <td>
                          {{ $satwa->doc_salinan_keputusan_pengadilan ?? '-' }} 
                          @if ($satwa->doc_salinan_keputusan_pengadilan)
                              - <a href="{{ Storage::url($satwa->path_salinan_keputusan_pengadilan) }}" target="_blank">Lihat Dokumen</a>
                          @endif
                      </td>
                      <td>
                        {{ $satwa->doc_berita_acara_pemeriksaan_sarana ?? '-' }} 
                        @if ($satwa->doc_berita_acara_pemeriksaan_sarana)
                            - <a href="{{ Storage::url($satwa->path_berita_acara_pemeriksaan_sarana) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_berita_acara_pemeriksaan_satwa ?? '-' }} 
                        @if ($satwa->doc_berita_acara_pemeriksaan_satwa)
                            - <a href="{{ Storage::url($satwa->path_berita_acara_pemeriksaan_satwa) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_surat_keterangan_kesehatan_satwa ?? '-' }} 
                        @if ($satwa->doc_surat_keterangan_kesehatan_satwa)
                            - <a href="{{ Storage::url($satwa->path_surat_keterangan_kesehatan_satwa) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_keterangan_asal_usul_silsilah_satwa ?? '-' }} 
                        @if ($satwa->doc_keterangan_asal_usul_silsilah_satwa)
                            - <a href="{{ Storage::url($satwa->path_keterangan_asal_usul_silsilah_satwa) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_surat_keterangan_menerima_hibah ?? '-' }} 
                        @if ($satwa->doc_surat_keterangan_menerima_hibah)
                            - <a href="{{ Storage::url($satwa->path_surat_keterangan_menerima_hibah) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_surat_keterangan_memberi_hibah ?? '-' }} 
                        @if ($satwa->doc_surat_keterangan_memberi_hibah)
                            - <a href="{{ Storage::url($satwa->path_surat_keterangan_memberi_hibah) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_dokumen_kerja_sama ?? '-' }} 
                        @if ($satwa->doc_dokumen_kerja_sama)
                            - <a href="{{ Storage::url($satwa->path_dokumen_kerja_sama) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_pnbp ?? '-' }} 
                        @if ($satwa->doc_pnbp)
                            - <a href="{{ Storage::url($satwa->path_pnbp) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_rekomendasi_kepala_b_bksda_asal_satwa ?? '-' }} 
                        @if ($satwa->doc_rekomendasi_kepala_b_bksda_asal_satwa)
                            - <a href="{{ Storage::url($satwa->path_rekomendasi_kepala_b_bksda_asal_satwa) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima ?? '-' }} 
                        @if ($satwa->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima)
                            - <a href="{{ Storage::url($satwa->path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_rekomendasi_scientific_authority_appendix_i_cites ?? '-' }} 
                        @if ($satwa->doc_rekomendasi_scientific_authority_appendix_i_cites)
                            - <a href="{{ Storage::url($satwa->path_rekomendasi_scientific_authority_appendix_i_cites) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td>
                        {{ $satwa->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa ?? '-' }} 
                        @if ($satwa->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa)
                            - <a href="{{ Storage::url($satwa->path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa) }}" target="_blank">Lihat Dokumen</a>
                        @endif
                    </td>
                    
                    <td  style="text-align: center;">
                      @if($satwa->dokumen_lainnya)
                          @php
                              $dokumen = json_decode($satwa->dokumen_lainnya);
                          @endphp
                          <ul>
                              @foreach ($dokumen as $doc) 
                                  <li>
                                      <a href="{{ Storage::url($doc->path) }}" target="_blank">{{ $doc->nama }}</a>
                                  </li>
                              @endforeach
                          </ul>
                      @else
                      <span style="text-align: center;">-</span>
                      @endif
                  </td>
                  
                    
                        <td style="text-align: center; display:flex; gap:10px;">
                          <button class="btn btn-primary" onclick="window.location.href='{{ route('detail-pengajuan-satwa-perolehan', $satwa->id) }}'">
                            Detail
                          </button>
                        </td>
                    </tr>
                @endforeach                
              </tbody>
            </table>
            {{ $satwaPerolehan->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    th {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
    }
</style>
  
  @if (session('refresh'))
  <script>
  window.addEventListener("pageshow", function(event) {
  var historyTraversal = event.persisted || 
                         (typeof window.performance != "undefined" && 
                          window.performance.navigation.type === 2);
  if (historyTraversal) {
    // Handle page restore.
    window.location.reload();
  }
});
  </script>
    
  @endif


@endsection



@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script>
      function showHint(input) {
        const hint = document.getElementById('hint');
        hint.style.display = 'block';
        hint.style.left = input.offsetLeft + 'px'; // Menyelaraskan hint dengan input
        hint.style.top = input.offsetTop + input.offsetHeight + 'px'; // Menampilkan hint tepat di bawah input
      }

      function hideHint() {
        const hint = document.getElementById('hint');
        hint.style.display = 'none';
      }

    function confirmDelete(button) {
      const nama_panggilan = button.name

      if (confirm("Apakah kamu yakin ingin menghapus data satwa koleksi ini ("+ nama_panggilan +")?")) {
          const id = button.id;
          fetch(`/satwa-titipan/${id}`, {
              method: 'DELETE',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  showNotification(data.message, data.success); 
                  button.closest('tr').remove();
              } else {
                  alert('Error deleting item');
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('Failed to delete item');
          });
      } else {
          return false;
      }
  }

</script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush