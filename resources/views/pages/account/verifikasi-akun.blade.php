@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">


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
                    <th style="text-align: center;">Role</th>
                    <th style="text-align: center;" >Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $user)
                    <tr>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td style="text-align: center;">{{ $user->role->name }} ({{ $user->role->tag}})</td> <!-- Nama UPT melalui relasi, gunakan null check -->
                        <td style="text-align: center;">            
                          <input type="checkbox" data-id="{{ $user->id }}" {{ $user->status_permission ? 'checked' : '' }} 
                          class="toggle-class" data-toggle="toggle" data-on="Diizinkan" data-off="Tidak Diizinkan" 
                          data-onstyle="success" data-offstyle="danger">
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
        var status = $(this).prop('checked') ? 1 : 0;
        var userId = $(this).data('id');
        console.log(userId + " -> " + status);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: `/updated-permission/id=${userId}`,
            data: {
                'status': status,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log('Permission updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('An error occurred:', error);
            }
        });
    });
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

@endpush