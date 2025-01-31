@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Satwa</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Data Tabel Satwa</h6>
        
        @php
          $satwa = session('satwa') ?? $satwa;
        @endphp

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <div class="searchbar" style="
              display: flex;
              gap: 10px;
              margin-left: 50%;
              flex-direction: row-reverse;
              ">
              <form action="{{ route('satwa-search') }}" method="GET" class="mb-4">
                <div class="input-group">
                  <input type="text" name="query" class="form-control" placeholder="Cari satwa..." value="{{ old('query') }}">
                  {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
                </div>
              </form>
            </div>
            <thead>
                <tr>
                    <th style="text-align: center;>">Nama Panggilan</th>
                    <th style="text-align: center;>">Asal Satwa</th>
                    <th style="text-align: center;>">Jenis Koleksi</th>
                    <th style="text-align: center;>">Spesies</th>
                    <th style="text-align: center;>">Status Perlidungan</th>
                    <th style="text-align: center;>">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach($satwa as $satwaa)
                    <tr>
                        <td>{{ Str::ucfirst(trans($satwaa->nama_panggilan))}}</td>
                        <td style="text-align: center;>">{{  Str::ucfirst($satwaa->asal_satwa)}}</td> 
                        <td style="text-align: center;>">{{  Str::ucfirst($satwaa->jenis_koleksi ) }}</td>
                        <td style="text-align: center;>"><i>{{  Str::ucfirst($satwaa->spesies ) }}</i></td>
                        <td style="text-align: center;>">
                          @if ($satwaa->status_perlindungan == '1')
                            Dilindungi
                          @else
                          Tidak Dilindungi                            
                          @endif
                        </td>
                        <td style="text-align: center;>">
                          <button 
                            class="btn btn-success detail-button" 
                            
                          >Detail</button>
            
                        <button 
                            class="btn btn-danger delete-button" 
                           
                            onclick="confirmDelete(this)">Delete</button>
                        </td>
                    </tr>
                @endforeach                
              </tbody>
            </table>
            {{ $satwa->links('pagination::bootstrap-5') }}
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