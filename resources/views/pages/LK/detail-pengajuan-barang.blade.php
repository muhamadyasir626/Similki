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
    <li class="breadcrumb-item"><a href="{{ route('daftar-pengajuan-barang') }}">Daftar Pengajuan Barang Konservasi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail @if(!$statusForm) Pengajuan @endif  Barang Konservasi</li>
  </ol>
</nav>

<div class="container ">
  <div class="row">
    <section>
      <sub-section class="table">
        <div class="header">
          <div>
            <h4>Detail @if(!$statusForm) Pengajuan @endif  Barang Konservasi</h4>

          </div>
          <div class="btn-header d-flex flex-wrap gap-2">
            @if (Auth::user()->role->tag == 'KKHSG')
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal">Verifikasi</button>
            @elseif(Auth::user()->role->tag == 'UPT' && $status->status == 'rejected')
                <button class="btn btn-primary" id="{{ $data->id }}" name="{{ $status->nama }}" onclick="confirmEdit(this)">Edit</button>
            @endif
            
            @if (Auth::user()->role->tag == 'UPT')
                <button class="btn btn-danger" id="{{ $data->id }}" onclick="confirmDelete(this)" name="{{ $data->nama }}">Delete</button>
            @endif
        </div>
          
        </div>
        <!-- Sisi Kiri: Tabel Informasi -->
        <div class="table">
          {{-- <h4>Informasi Verifikasi</h4> --}}
          <table class="table table-bordered">
              <thead>
              <tr>
                  <td>Nama Baran</td>
                  <td>{{ $data->nama }}</td>
              </tr>
              </thead>
              <tbody>
              <tr>
                  <td style="width: 10%">Jenis Barang</td>
                  <td>{{ $data->jenisBarang->nama }}</td>
              </tr>
              <tr>
                  <td>Negara Asal</td>
                  <td>{{ $data->negara_asal }}</td>
              </tr>
              <tr>
                  <td>Pelabuhan Masuk</td>
                  <td>{{ $data->pelabuhan_masuk }}</td>
              </tr>
              <tr>
                  <td>Jumlah</td>
                  <td>{{ $data->jumlah }}</td>
              </tr>
              <tr>
                <td>Perkiraan Nilai</td>
                <td>Rp{{ number_format($data->perkiraan_nilai, 0, ',', '.') }}</td>
              </tr>
              <tr>
                <td>Surat Permohonan</td>
                <td>{{$data->doc_surat_permohonan }} - <a href="{{ $data->path_surat_permohonan }}">Lihat Dokumen</a></td>
              </tr>
              <tr>
                <td>Surat Pernyataan</td>
                <td>{{$data->doc_surat_pernyataan }} - <a href="{{ $data->path_surat_pernyataan }}">Lihat Dokumen</a></td>
              </tr>
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
        <form id="verifikasiForm" action="{{ route('verifikasi.store'{{--,$data->id--}}) }}" method="POST">
          @csrf

          {{-- Id LK  --}}

          <input type="hidden" name="id_barang_konservasi" value="{{ $data->id }}">
          
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

    if(confirm("Apakah kamu yakin ingin menghapus data barang konservasi ini")){
      const id = button.id;
      fetch(`/barang-konservasi/${id}`,{
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
        window.location.href ='/daftar-pengajuan-barang-konservasi'
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
    const url = "{{ route('barang-konservasi.edit', ':id') }}".replace(':id', id);
    // console.log(url);
    
    window.location.href = url;
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