@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Monitoring Satwa Koleksi Individu</li>
  </ol>
</nav>

@php
$satwaKoleksi = session('satwaKoleksi') ?? $satwaKoleksi;
$role = Auth::user()->role->tag;
@endphp

<div class="row">
  {{-- @include('components.notifikasi-action') --}}
  <div class="col-md-12 grid-margin stretch-card">
    @include('components.notifikasi-action')
    <div class="card">
      <div class="card-body" id="form-card-body">
        <h6 class="card-title">Daftar Satwa Koleksi Individu</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <div class="searchbar">
              <form action="{{ route('search-koleksi-individu') }}" method="GET" class="mb-4">
                <div class="input-group">
                  <input type="text" name="query" class="form-control" placeholder="{{ $query?? 'Cari satwa...' }}" onfocus="showHint(this)" onblur="hideHint()" >
                  <div id="hint" style="display: none; position: absolute; background-color: #f0f0f0; padding: 5px; border: 1px solid #ccc;">
                    Pencarian untuk Nama panggilan, kode tagging, SK dirjen dan SK kepala Balai.
                  </div>
                  {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
                </div>
              </form>
            </div>
            <thead>
                <tr>
                    <th style="text-align: center;>">Nama Panggilan</th>
                    <th style="text-align: center;>">Kondisi Satwa</th>
                    <th style="text-align: center;>">Jenis Kelamin</th>
                    <th style="text-align: center;>">Asal Satwa</th>
                    @if ($role != 'LK')
                    <th style="text-align: center;>">Lembaga Konservasi</th>
                    @endif
                    <th style="text-align: center;>">Spesies</th>
                    <th style="text-align: center;>">Status Perlidungan</th>
                    <th style="text-align: center;>">Cara Perolehan</th>
                    <th style="text-align: center;>">Umur</th>
                    <th style="text-align: center;>">Tanggal Lahir</th>
                    <th style="text-align: center;>">Asal-Usul (Silsilah)</th>
                    <th style="text-align: center;>">BAP Kelahiran</th>
                    <th style="text-align: center;>">Bentuk/Kode Tagging</th>
                    <th style="text-align: center;>">SK Dirjen</th>
                    <th style="text-align: center;>">SK Kepala Balai</th>
                    @if ($role == 'LK')
                    <th style="text-align: center;>">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach($satwaKoleksi as $satwa)
                    <tr>
                        <td>{{ Str::ucfirst(trans($satwa->nama_panggilan))}}</td>
                        <td>{{ Str::ucfirst(trans($satwa->kondisi_satwa))}}</td>
                        <td style="text-align: center;>">
                          @if ($satwa->jenis_kelamin == 1)
                            Jantan
                            @else
                            Betina
                          @endif
                        </td> 
                        <td style="text-align: center;>">
                          @if ($satwa->asal_satwa == 1)
                            Indonesia
                            @else
                            Asing
                          @endif
                        </td> 
                        @if ($role != 'LK')
                          <td style="text-align: center;>">{{ $satwa->lk->nama }}</td>
                        @endif
                        <td style="text-align: center;>">
                          <i>{{  Str::ucfirst($satwa->spesies->nama_ilmiah ) }}</i>
                        </td>
                        <td style="text-align: center;>">
                          @if ($satwa->status_perlindungan == '1')
                            Dilindungi
                          @else
                          Tidak Dilindungi                            
                          @endif
                        </td>
                        <td style="text-align: center;>">
                          {{ empty($satwa->list_cara_perolehan_koleksi->nama) ? '-' : $satwa->list_cara_perolehan_koleksi->nama }}
                        </td>
                        <td style="text-align: center;>">
                          @php
                          if ($satwa->tanggal_lahir) {
                              $tanggal_lahir = new DateTime($satwa->tanggal_lahir);
                              $sekarang = new DateTime();
                              $umur = $sekarang->diff($tanggal_lahir)->y; // Umur dalam tahun
                              $umur += $satwa->umur;
                          } else {
                              $umur = '-';
                          }
                      @endphp
                      {{ $umur }}
                      
                        </td>
                        <td style="text-align: center;>">
                          {{ date('d/m/Y', strtotime($satwa->tanggal_lahir)) }}
                        </td>
                        <td style="text-align: center;>">
                          {{ $satwa->asal_usul }} - <a href="{{ Storage::url( $satwa->path_asal_usul) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a>
                        </td>
                        <td style="text-align: center;>">
                          {{ $satwa->doc_bap_kelahiran }} - <a href="{{ Storage::url( $satwa->path_bap_kelahiran) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a>
                        </td>
                        <td style="text-align: center;>">
                          {{ $satwa->tagging->jenis_tagging }}/{{ $satwa->kode_tagging }}
                        </td>
                        <td style="text-align: center;>">
                          {{ empty($satwa->sk_perolehan_koleksi_dirjen) ? '-' : $satwa->sk_perolehan_koleksi_dirjen}}
                        </td>
                        <td style="text-align: center;>">
                          {{ empty($satwa->sk_perolehan_koleksi_kepala_balai) ? '-' : $satwa->sk_perolehan_koleksi_kepala_balai}}
                        </td>
                        @if ($role == 'LK')
                        <td style="text-align: center; display:flex; gap:10px;">
                          
                          <form  action="{{ route('satwa-koleksi.edit', $satwa->id)}}" method="GET" onsubmit="return update(this)">
                              <button 
                              class="btn btn-primary"
                              {{-- id="{{ $satwa->id }}" --}}
                              onclick="update(this)">
                              Update
                            </button>
                          </form>
                          <button 
                          class="btn btn-danger delete-button" 
                          id="{{ $satwa->id }}"
                          name="{{ $satwa->nama_panggilan }}"
                          onclick="confirmDelete(this)"
                          >Delete</button>
                        </td>
                        @endif
                    </tr>
                @endforeach                
              </tbody>
            </table>
            {{ $satwaKoleksi->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>
 
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
          fetch(`/satwa-koleksi/${id}`, {
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