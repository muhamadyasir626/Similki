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
<<<<<<< Updated upstream
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
=======
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Nomor Telepon</th>
                    <th style="text-align: center;">Role</th>
                    <th style="text-align: center;" >Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $account)
                    <tr>
                        <td>{{ $account->nama_lengkap }}</td>
                        <td style="text-align: center;">{{ $account->email }}</td>
                        <td style="text-align: center;"><a href="https://wa.me/{{ preg_replace('/\D/', '', $account->nomor_telepon) }}" target="_blank">{{ $account->nomor_telepon }}</a></td>
                        <td style="text-align: center;">{{ $account->role->name }} ({{ $account->role->tag}})</td>
                        <td style="text-align: center;">            
                          <input type="checkbox" data-id="{{ $account->id }}" {{ $account->status_permission ? 'checked' : '' }} 
                          class="toggle-class" data-toggle="toggle" data-on="Diizinkan" data-off="Tidak Diizinkan" 
                          data-onstyle="success" data-offstyle="danger">
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
$(document).ready(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var userId = $(this).data('id');
        console.log(userId+"->"+ status);
=======
  $(document).ready(function() {
      let isAjaxRunning = false; // Flag untuk mencegah AJAX berulang

      $(document).on('change', '.toggle-class', function(event) {
          event.preventDefault();
          event.stopImmediatePropagation();

          if (isAjaxRunning) {
              console.warn("AJAX sedang berjalan, permintaan diabaikan.");
              return;
          }

          const $toggle = $(this); // Ambil elemen toggle
          const status = $toggle.prop('checked') ? 1 : 0;
          const userId = $toggle.data('id');
          const token = localStorage.getItem('auth_token');

          console.log(`User ID: ${userId}, Status: ${status}`);

          isAjaxRunning = true; // Set flag sebelum memulai AJAX
          $toggle.bootstrapToggle('disable'); // Disable tombol sementara

          $.ajax({
              type: "POST",
              dataType: "json",
              url: `/api/updated-permission/${userId}`,
              headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                  'Authorization': `Bearer ${token}`,
              },
              data: {
                  'status': status
              },
              success: function(data) {
                  console.log('Permission updated successfully:', data);
                  if (data.success) {
                      if (status === 1) {
                          $toggle.bootstrapToggle('on');
                      } else {
                          $toggle.bootstrapToggle('off');
                      }
                  }
              },
              error: function(xhr, status, error) {
                  console.error('AJAX Error:', xhr.responseText || error);
                  $toggle.bootstrapToggle(status ? 'off' : 'on');
              },
              complete: function() {
                  isAjaxRunning = false;
                  $toggle.bootstrapToggle('enable'); 
              }
          });
      });
  });





>>>>>>> Stashed changes

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