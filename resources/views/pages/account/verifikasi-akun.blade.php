@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Pengguna</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Daftar Pengguna</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Permission</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $user)
                    <tr>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->role->name }} ({{ $user->role->tag}})</td> <!-- Nama UPT melalui relasi, gunakan null check -->
                        <td>            
                          <input type="checkbox" data-id="{{ $user->id }}" {{ $user->status_permission ? 'checked' : '' }} class="toggle-class" data-toggle="toggle" data-style="ios">
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
<script>
$(document).ready(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var userId = $(this).data('id');
        console.log(userId+"->"+ status);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: `/updated-permission/id=${userId}`,
            data: {'status': status, '_token': '{{ csrf_token() }}'},
            success: function(data){
              // console.log(data.message);
            }
        });
    });
});
</script>

@endpush