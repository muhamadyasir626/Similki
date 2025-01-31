@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('/css/popup.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('components.notifikasi-action')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar @if(!$status) Pengajuan @endif  Barang Konservasi</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Daftar @if(!$status) Pengajuan @endif  Barang Konservasi</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <div class="searchbar">
              <form action="{{ route('lk-search') }}" method="GET" class="mb-4">
                <div class="input-group">
                  <input type="text" name="query" class="form-control" placeholder="Cari Lembaga Konservasi..." value="{{ old('query') }}">
                  {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
                </div>
              </form>
            </div>
            <thead>
                <tr>
                    <th style="text-align: center;>">Nama Barang</th>
                    <th style="text-align: center;>">Jenis Barang</th>
                    <th style="text-align: center;>">Pelabuhan Masuk</th>
                    <th style="text-align: center;>">Negara Asal</th>
                    <th style="text-align: center;>">Jumlah</th>
                    <th style="text-align: center;>">Perkiraan Nilai</th>
                    <th style="text-align: center;>">Surat Permohonan</th>
                    <th style="text-align: center;>">Surat Pernyataan</th>
                    <th style="text-align: center;>">Status</th>
                    <th style="text-align: center;>">Action</th>
                </tr>
            </thead>
            {{-- {{-- <tbody> --}}
              @foreach($data as $bk)
              <tr>
                  <td>{{ Str::ucfirst(trans($bk->nama))}}</td>
                  <td><i>{{ Str::ucfirst(trans($bk->jenisBarang->nama??'-'))}}</i></td>
                  <td>{{ Str::ucfirst(trans($bk->pelabuhan_masuk??'-'))}}</td>
                  <td >{{ Str::ucfirst(trans($bk->negara_asal??'-'))}}</td>
                  <td>{{ $bk->jumlah ?? '-' }}</td>
                  <td>Rp{{ number_format($bk->perkiraan_nilai, 0, ',', '.') }}</td>
                  <td>{{ $bk->doc_surat_permohonan ?? '-' }} - <a href="{{ Storage::url($bk->path_surat_permohonan) }}" target="_blank">Lihat Dokumen</a></td>
                  <td>{{ $bk->doc_surat_pernyataan ?? '-' }} - <a href="{{  Storage::url($bk->path_surat_pernyataan) }}" target="_blank">Lihat Dokumen</a></td>
                  <td>
                    @if ($bk->status == 1)
                      <button class="btn btn-success">Verified</button>
                      @else
                      <button class="btn btn-danger">Not Verified</button>

                    @endif
                  </td>
                  <td>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('detail-pengajuan-barang',  ['id' => $bk->id, 'status' => $status]) }}'">
                      Detail
                    </button>
                  </td>
              </tr>
          @endforeach   
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush