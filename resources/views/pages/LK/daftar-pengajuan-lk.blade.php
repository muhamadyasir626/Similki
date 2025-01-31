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
    <li class="breadcrumb-item active" aria-current="page">Daftar Pengajuan Lembaga Konservasi</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Daftar Pengajuan Lembaga Konservasi</h6>
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
                    <th style="text-align: center;>">Nama Calon LK</th>
                    <th style="text-align: center;>">Nama Direktur</th>
                    <th style="text-align: center;>">NIB</th>
                    <th style="text-align: center;>">NPWP</th>
                    <th style="text-align: center;>">Email</th>
                    <th style="text-align: center;>">No. Telepon</th>
                    <th style="text-align: center;>">Bentuk LK</th>
                    <th style="text-align: center;>">Alamat LK</th>
                    <th style="text-align: center;>">Jumlah Investasi</th>
                    <th style="text-align: center;>">Jumlah Tenaga Kerja</th>
                    <th style="text-align: center;>">Jumlah Luas Wilayah</th>
                    <th style="text-align: center;>">action</th>
                </tr>
            </thead>
            {{-- {{-- <tbody> --}}
              @foreach($data as $lk)
              <tr>
                  <td>{{ Str::ucfirst(trans($lk->nama))}}</td>
                  <td><i>{{ Str::ucfirst(trans($lk->nama_direktur??'-'))}}</i></td>
                  <td>{{ Str::ucfirst(trans($lk->nib??'-'))}}</td>
                  <td >{{ Str::ucfirst(trans($lk->npwp??'-'))}}</td>
                  <td>{{ $lk->email ?? '-' }}</td>
                  <td>{{ $lk->no_telp ?? '-' }}</td>
                  <td >{{ Str::ucfirst(trans($lk->bentuk_lk??'-'))}}</td>
                  <td >{{ Str::ucfirst(trans($lk->alamat??'-'))}}</td>
                  <td style="text-align: center;>" >Rp{{ number_format($lk->jumlah_Investasi, 0, ',', '.') }}</td>
                  <td style="text-align: center;>" >{{$lk->jumlah_tenaga_kerja ?? 0}}</td>
                  <td style="text-align: center;>" >{{$lk->jumlah_wilayah ?? 0 }} Ha</td>
                  <td style="text-align: center; display:flex; gap:10px;">
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('detail-pengajuan-lk', ['id' => $lk->id , 'status' => $status]) }}'">
                      Detail
                    </button>
                    
                  </td>
              </tr>
          @endforeach   
            </tbody>
        </table>
        {{ $data->links('pagination::bootstrap-5') }}
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