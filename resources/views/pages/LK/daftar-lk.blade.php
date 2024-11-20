@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Lembaga Konservasi</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Daftar Nama Lembaga Konservasi</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>UPT</th>
                    <th>Bentuk Lembaga Konservasi</th>
                    <th style="text-align: center;>">Akreditasi</th>
                    <th style="text-align: center;>">Tahun izin</th>
                    <th style="text-align: center;>">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ListLK as $lk)
                    <tr>
                        <td>{{ Str::limit($lk->nama, 30, '...') }}</td>
                        <td>{{ $lk->upt->wilayah}}</td> <!-- Nama UPT melalui relasi, gunakan null check -->
                        <td>{{ $lk->bentuk_lk }}</td>
                        <td style="text-align: center;>">{{ $lk->nilai_akred ?? '-' }}</td>
                        <td style="text-align: center;>">{{ $lk->tahun_izin }}</td>
                        <td style="text-align: center;>"><button>Detail</button></td>
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