@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Monitoring Investasi</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Monitoring Investasi</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
                <tr>
                    <th>Nama Lembaga Konservasi</th>
                    <th>UPT</th>
                    <th>Jumlah Karyawan Laki-Laki</th>
                    <th>Jumlah Karyawan Wanita</th>
                    <th>Jumlah Dokter Hewan</th>
                    <th>Luas Tanah Konservasi</th>
                    <th>Jumlah Investasi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($investasi as $inv)
                    <tr>
                        <td>{{ $inv->lk->nama }}</td>
                        <td>{{ $inv->lk->ListUpt->wilayah}}</td> <!-- Nama UPT melalui relasi, gunakan null check -->
                        <td>{{ $inv->jumlah_karyawan_laki }}</td>
                        <td>{{ $inv->jumlah_karyawan_perempuan}}</td>
                        <td>{{ $inv->jumlah_dokter_hewan}}</td>
                        <td>{{ $inv->jumlah_lahan_konservasi}}</td>
                        <td>{{ $inv->jumlah_investasi}}</td>
                        <td><button>Detail</button></td>
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