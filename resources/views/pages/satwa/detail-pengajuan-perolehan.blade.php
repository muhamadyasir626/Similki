@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('/css/detail-pengajuan-lk.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('components.notifikasi-action')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('daftar-pengajuan-satwa-perolehan') }}">Daftar Pengajuan Satwa Perolehan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Satwa Perolehan</li>
  </ol>
</nav>

<div class="container ">
  <div class="row">
    <section>
      <sub-section class="table">
        <div class="header">
          <h4>Detail Pengajuan Satwa Perolehan</h4>
          <div class="btn-header">

            @if (Auth::user()->role->tag == 'KKHSG')
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal">Verifikasi</button>
            
            @elseif(Auth::user()->role->tag == 'LK' && $status->status == 'rejected')
            
            {{-- <button class="btn btn-primary" id="{{ Crypt::encryptString($data->id )}}" name="{{ $status->nama }}" onclick="confirmEdit(this)">Edit</button> --}}
            <button class="btn btn-primary" id="{{ $data->id }}" name="{{ $status->nama }}" onclick="confirmEdit(this)">Edit</button>
            @endif

            @if (Auth::user()->role->tag == 'LK')
            <button class="btn btn-danger" id="{{ $data->id }}" 
              onclick="confirmDelete(this)"
              name="{{ $data->nama }}"
              >Delete</button>             
            @endif
            </div>              
        </div>
        <!-- Sisi Kiri: Tabel Informasi -->
        <div class="table">
          {{-- <h4>Informasi Verifikasi</h4> --}}
          <table class="table table-bordered">
              <thead>
              </thead>
              <tbody>
                <tr>
                    <td>Nama LK</td>
                    <td>{{ $data->lk->nama }}</td>
                </tr>
              <tr>
                  <td style="width: 10%">Cara Perolehan</td>
                  <td>{{ $data->caraperolehan->nama }}</td>
              </tr>
              <tr>
                  <td>Status Perlindungan</td>
                  <td>
                    @if ($data->status_perlindungan == '1')
                            Dilindungi
                          @else
                          Tidak Dilindungi                            
                          @endif
                  </td>
              </tr>
              <tr>
                  <td>Nama Ilmiah</td>
                  <td><i>{{ $data->spesies->nama_ilmiah }}</i></td>
              </tr>
              <tr>
                <td>Nama Lokal</td>
                <td>{{ $data->spesies->nama_lokal }}</td>
            </tr>
              <tr>
                <td>Nama Internasional (english name)</td>
                <td>{{ $data->spesies->nama_lokal }}</td>
            </tr>
              <tr>
                <td>Taksa</td>
                <td>{{ $data->spesies->class }}</td>
            </tr>
            <tr>
              <td>Asal Satwa</td>
              <td>{{Str::ucfirst(trans($data->asal_satwa ))}}</td>
            </tr>
            
            @if ($data->caraperolehan->nama =='penyerahan' && $data->status_perlindungan == '1')
              <tr>
                <td>Surat Permohonan</td>
                <td><a href="{{ $data->path_surat_permohonan }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_surat_permohonan }}</a></td>
              </tr>
              <tr>
                <td style="white-space: pre-line;">Salinan Keputusan Pengadilan Terhadap Spesimen hasil sitaan/BA  hasil rampasan/BA acara secara sukarela dari Masyarakat</td>
                <td><a href="{{ $data->path_salinan_keputusan_pengadilan }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_salinan_keputusan_pengadilan }}</a></td>
              </tr>
              <tr>
                <td>Berita Acara Pemeriksaan Sarana & Prasarana</td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_sarana }}" style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_berita_acara_pemeriksaan_sarana }}
                </a>
              </td>
              </tr>
              <tr>
                <td>Rekomendasi Kepala BBKSDA/BKSDA domisili LK Pemohon/Penerima satwa</td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}" style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}</a>
                </td>
              </tr>
              <tr>
                <td>Berita ACARA pemeriksaan SATWA</td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_satwa }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_berita_acara_pemeriksaan_satwa }} </a></td>
              </tr>
              <tr>
                <td>Rekomendasi Kepala BBKSDA/BKSDA asal satwa</td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_asal_satwa }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_rekomendasi_kepala_b_bksda_asal_satwa }}</a></td>
              </tr>
              <tr>
                <td>Surat Keterangan Kesehatan Satwa</td>
                <td><a href="{{ $data->path_surat_keterangan_kesehatan_satwa }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_surat_keterangan_kesehatan_satwa }}</a></td>
              </tr>
              <tr>
                <td>Keterangan Asal - Usul / Silsilah Satwa (BA Penitipan)</td>
                <td><a href="{{ $data->path_keterangan_asal_usul_silsilah_satwa }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_keterangan_asal_usul_silsilah_satwa }}</a></td>
              </tr>
              <tr>
                <td>Dokumen Lainnya</td>
                <td >
                  @if($data->dokumen_lainnya)
                  @php
                      $dokumen = json_decode($data->dokumen_lainnya);
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
              </tr>

              @elseif ($data->caraperolehan->nama =='hibah pemberian/sumbangan' && $data->status_perlindungan == '1')
              <tr>
                <td>Surat Permohonan</td>
                <td><a href="{{ $data->path_surat_permohonan }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_surat_permohonan }}</a></td>
              </tr>
              <tr>
                <td>Surat Keterangan Menerima Hibah</td>
                <td><a href="{{ $data->path_surat_keterangan_menerima_hibah }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_surat_keterangan_menerima_hibah }}</a></td>
              </tr>
              <tr>
                <td>Surat Keterangan Memberi Hibah</td>
                <td><a href="{{ $data->path_surat_keterangan_memberi_hibah }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_surat_keterangan_memberi_hibah }}</a></td>
              </tr>
              <tr>
                <td>Berita Acara Pemeriksaan Sarana & Prasarana </td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_sarana }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_berita_acara_pemeriksaan_sarana }}</a></td>
              </tr>
              <tr>
                <td>
                  Rekomendasi Kepala BBKSDA/BKSDA domisili LK Pemohon/Penerima satwa
                </td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}</a></td>
              </tr>
              <tr>
                <td>
                  Berita ACARA pemeriksaan SATWA
                </td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_berita_acara_pemeriksaan_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  Rekomendasi Kepala BBKSDA/BKSDA domisili LK asal satwa
                </td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  Surat Keterangan Kesehatan Satwa
                </td>
                <td><a href="{{ $data->path_surat_keterangan_kesehatan_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_surat_keterangan_kesehatan_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  Keterangan Asal - Usul / Silsilah Satwa
                </td>
                <td><a href="{{ $data->path_keterangan_asal_usul_silsilah_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_keterangan_asal_usul_silsilah_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  Rekomendasi Scientific Authority untuk Appendix I cites (Proses oleh KSG ke SKIKH BRIN)
                </td>
                <td><a href="{{ $data->path_rekomendasi_scientific_authority_appendix_i_cites }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_scientific_authority_appendix_i_cites }}</a></td>
              </tr>
              <tr>
                <td>Dokumen Lainnya</td>
                <td>
                  @php
                      $dokumen = json_decode($data->dokumen_lainnya);
                  @endphp
                  <ul>
                      @foreach ($dokumen as $doc) 
                          <li>
                              <a href="{{ Storage::url($doc->path) }}" style="white-space: pre-line;" target="_blank">{{ $doc->nama }}</a>
                          </li>
                      @endforeach
                  </ul>
              </td>
              </tr>

              @elseif (($data->caraperolehan->nama =='peminjaman' || $data->caraperolehan->nama == 'tukar menukar') && $data->status_perlindungan == '1')
              <tr>
                <td>Surat Permohonan</td>
                <td><a href="{{ $data->path_surat_permohonan }}" style="white-space: pre-line;" target="_blank">{{ $data->doc_surat_permohonan }}</a></td>
              </tr>
              <tr>
                <td> 
                  Dokumen kerja sama
                </td>
                <td><a href="{{ $data->path_dokumen_kerja_sama }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_dokumen_kerja_sama }}</a></td>
              </tr>
              <tr>
                <td> 
                  Berita Acara Pemeriksaan Sarana & Prasarana
                </td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_sarana }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_berita_acara_pemeriksaan_sarana }}</a></td>
              </tr>
              <tr>
                <td> 
                  Rekomendasi Kepala BBKSDA/BKSDA domisili LK Pemohon/Penerima satwa
                </td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}</a></td>
              </tr>
              <tr>
                <td> 
                  Berita ACARA pemeriksaan SATWA
                </td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_berita_acara_pemeriksaan_satwa }}</a></td>
              </tr>
              <tr>
                <td> 
                  Rekomendasi Kepala BBKSDA/BKSDA domisili LK asal satwa
                </td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_asal_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_asal_satwa }}</a></td>
              </tr>
              <tr>
                <td> 
                  Surat Keterangan Kesehatan Satwa
                </td>
                <td><a href="{{ $data->path_surat_keterangan_kesehatan_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_surat_keterangan_kesehatan_satwa }}</a></td>
              </tr>
              <tr>
                <td> 
                  Keterangan Asal - Usul / Silsilah Satwa
                </td>
                <td><a href="{{ $data->path_keterangan_asal_usul_silsilah_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_keterangan_asal_usul_silsilah_satwa }}</a></td>
              </tr>
              <tr>
                <td>Dokumen Lainnya</td>
                <td>
                  @if($data->dokumen_lainnya)
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
              </tr>

              @elseif ($data->caraperolehan->nama == 'pengambilan dari instalasi pemerintah' && $data->status_perlindungan == '1' && $data->asal_satwa == 'indonesia')
              <tr>
                <td>Surat Permohonan</td>
                <td><a href="{{ $data->path_surat_permohonan }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_surat_permohonan }}</a></td>
              </tr>
              <tr>
                <td>
                  Berita Acara Pemeriksaan Sarana & Prasarana
                </td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_sarana }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_berita_acara_pemeriksaan_sarana }}</a></td>
              </tr>
              <tr>
                <td>
                  Rekomendasi Kepala BBKSDA/BKSDA domisili LK Pemohon/Penerima satwa
                </td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima }}</a></td>
              </tr>
              <tr>
                <td>Berita Acara Pemeriksaan Sarana & Prasarana</td>
                <td><a href="{{ $data->path_berita_acara_pemeriksaan_sarana }}" style="white-space: pre-line;" target="_blank">
                    {{ $data->doc_berita_acara_pemeriksaan_sarana }}
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  Rekomendasi Kepala BBKSDA/BKSDA domisili LK asal satwa
                </td>
                <td><a href="{{ $data->path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  Surat Keterangan Kesehatan Satwa
                </td>
                <td><a href="{{ $data->path_surat_keterangan_kesehatan_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_surat_keterangan_kesehatan_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  Keterangan Asal - Usul / Silsilah Satwa
                </td>
                <td><a href="{{ $data->path_keterangan_asal_usul_silsilah_satwa }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_keterangan_asal_usul_silsilah_satwa }}</a></td>
              </tr>
              <tr>
                <td>
                  PNBP
                </td>
                <td><a href="{{ $data->path_pnbp }}" 
                  style="white-space: pre-line;" target="_blank">
                  {{ $data->doc_pnbp }}</a></td>
              </tr>
              <tr>
                <td>Dokumen Lainnya</td>
                <td>
                  @if($data->dokumen_lainnya)
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
              </tr>
            @endif
            
              </tbody>
          </table>
        </div>
      </sub-section>
    
      <sub-section>
        <!-- Sisi Kanan: Timeline -->
          <div class="timeline-detail">
            <div class="header" style="width: 100%">
              {{-- <h4>Progres Milestone</h4> --}}
            </div>
            @foreach ($timeline as $item)
                
            <ul class="timeline-list list-unstyled">
              <li class="timeline-item ">
                <div class="keterangan">
                    @if ($item->status == 'rejected')
                      <button class="btn btn-danger custom-timeline">DITOLAK</button> <br>
                      @elseif ($item->status == 'in progress')
                      <button class="btn btn-warning custom-timeline">PROSES</button> <br>
                      @elseif ($item->status == 'update')
                      <button class="btn btn-primary custom-timeline">PERUBAHAN</button> <br>
                      @elseif ($item->status == 'Approved')
                      <button class="btn btn-success custom-timeline">DISETUJUI</button> <br>
                    @endif
                  <strong> {{ $item->keterangan }}</strong> <br>
                  @if ($item->status == 'update')
                  <small style="color: red">{{ $item->perbaikan }}</small><br>
                  @endif
                  <small>{{ $item->created_at }}</small>
                </div>
                
              </li>
              
            </ul>
            @endforeach
          </div>
      </sub-section>
    </section>
  </div>
</div>
  



<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Pengajuan</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <form id="verifikasiForm" action="{{ route('verifikasi.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id_satwa_perolehan" value="{{ $data->id }}">
    
    <div class="mb-3">
      <label for="statusVerifikasi" class="form-label">Status Verifikasi</label>
      <select class="form-select" id="statusVerifikasi" name="status" required>
        <option value="" hidden selected>Pilih Verifikasi</option>
        <option value="Approved">Disetujui</option>
        <option value="rejected">Ditolak</option>
        <option value="in progress">Sedang Proses</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" required rows="3" placeholder="Tambahkan catatan atau alasan..."></textarea>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
  <button type="submit" class="btn btn-success" form="verifikasiForm">Simpan Verifikasi</button>
</div>
</div>
</div>
</div>

<script>
  function confirmDelete(button){
    const nama_barang = button.name;

    if(confirm("Apakah kamu yakin ingin menghapus data lembaga konservasi ini")){
      const id = button.id;
      fetch(`/satwa-perolehan/${id}`,{
        method: 'DELETE',
        headers: {
          'Content-Type' : 'application/type',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      })
      .then(response => response.json())
      .then(data=>{
        if(data.success){
          showNotification(data.message, data.type);
        }else{
          alert('error deleting item');
        }
        window.location.href ='/daftar-pengajuan-satwa-perolehan'
      })
      .catch(error => {
              console.error('Error:', error);
              alert('Failed to delete item');
          });
    }else{
      return false;
    }
  }

  function confirmEdit(button){
    const id = button.id;
    
    const url = `{{ route('satwa-perolehan.edit', ['id' => 'key']) }}`.replace('key', id);
    console.log(url);
    
    // window.location.href = url;
  }

  document.addEventListener("DOMContentLoaded", function () {
    const statusVerifikasi = document.getElementById('statusVerifikasi');
    const keteranganField = document.getElementById('keterangan');

    function checkKeteranganRequired() {
      if (statusVerifikasi.value === 'Approved') {
        keteranganField.removeAttribute('required');
      } else {
        keteranganField.setAttribute('required', 'required');
      }
    }

    statusVerifikasi.addEventListener('change', checkKeteranganRequired);

    checkKeteranganRequired();
  });

</script>






@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush