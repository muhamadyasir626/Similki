@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Monitoring Satwa Titipan</li>
  </ol>
</nav>
@include('components.notifikasi-action')

@php
$satwaTitipan = session('satwaTitipan') ?? $satwaTitipan;
$role = Auth::user()->role->tag;
@endphp

<div class="row">
  @include('components.notifikasi-action')
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body" id="form-card-body">
        <h6 class="card-title">Daftar Tabel Satwa Titipan</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <div class="searchbar">
              <form action="{{ route('search-satwa-titipan') }}" method="GET" class="mb-4">
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
                    <th style="text-align: center;>">No BAP Titipan</th>
                    <th style="text-align: center;>">Nama Ilmiah</th>
                    <th style="text-align: center;>">Nama Lokal</th>
                    <th style="text-align: center;>">Asal Satwa Titipan</th>
                    <th style="text-align: center;>">LK</th>
                    <th style="text-align: center;>">Dokumen BAP</th>
                    <th style="text-align: center;>">Jumlah Jantan</th>
                    <th style="text-align: center;>">Jumlah Betina</th>
                    <th style="text-align: center;>">Jumlah Unknown</th>
                    @if ($role == 'lk')
                      
                    <th style="text-align: center;>">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach($satwaTitipan as $satwa)
                    <tr>
                        <td>{{ Str::ucfirst(trans($satwa->no_bap_titipan))}}</td>
                        <td><i>{{ Str::ucfirst(trans($satwa->spesies->nama_ilmiah))}}</i></td>
                        <td>{{ Str::ucfirst(trans($satwa->spesies->nama_lokal))}}</td>
                        <td style="text-align: center;>" >{{ Str::ucfirst(trans($satwa->asal_satwa->nama))}}</td>
                        <td style="text-align: center;>" >{{ Str::ucfirst(trans($satwa->lk->nama ?? '-'))}}</td>
                        <td>{{ $satwa->doc_bap_titipan }} - <a href="{{ Storage::url( $satwa->path_bap_titipan) }}" target="_blank"  rel="noopener noreferrer">Lihat Dokumen</a></td>
                        <td style="text-align: center;>" >{{ Str::ucfirst(trans($satwa->jumlah_jantan))}}</td>
                        <td style="text-align: center;>" >{{ Str::ucfirst(trans($satwa->jumlah_betina))}}</td>
                        <td style="text-align: center;>" >{{ Str::ucfirst(trans($satwa->jumlah_unknown))}}</td>              
                        @if ($role == 'lk')
                          
                        <td style="text-align: center; display:flex; gap:10px;">
                              <button 
                              class="btn btn-primary"
                              id="{{ $satwa->id }}"
                              onclick="update(this)"
                              >
                              <a href="{{ route('satwa-titipan.edit',$satwa->id) }}">Update</a>
                            </button>
                          <button 
                            class="btn btn-danger delete-button" 
                            id="{{ $satwa->id }}"
                            name="{{ $satwa->spesies->nama_lokal }}"
                            onclick="confirmDelete(this)"
                            >Delete
                        </button>
                        @endif

                        </td>
                    </tr>
                @endforeach                
              </tbody>
            </table>
            {{ $satwaTitipan->links('pagination::bootstrap-5') }}
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