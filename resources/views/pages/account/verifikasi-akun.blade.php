@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
                @foreach($users as $user)
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
  <script src="{{ asset('assets/js/verifikasi.js') }}"></script>

@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
<script>
// $(document).ready(function() {
//     $('.toggle-class').change(function(event) {
//         var status = $(this).prop('checked') ? 1 : 0;
//         var userId = $(this).data('id');

//         console.log(userId + " -> " + status);

//         $.ajax({
//             type: "POST",
//             dataType: "json",
//             url: `/updated-permission/${userId}`,
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
//             },
//             data: {
//                 'status': status
//             },
//             success: function(data) {
//                 console.log('Permission updated successfully');
//                 // Jika server mengembalikan sukses, perbarui tombol toggle dan keluar
//                 if (data.success) {
//                     if (status === 1) {
//                         $(`.toggle-class[data-id=${userId}]`).bootstrapToggle('on');
//                     } else {
//                         $(`.toggle-class[data-id=${userId}]`).bootstrapToggle('off');
//                     }
//                     return; // Stop eksekusi lebih lanjut
//                 }

//                 // Jika server tidak mengembalikan sukses, kembalikan toggle ke status sebelumnya
//                 console.error('Failed to update permission on server.');
//                 $(`.toggle-class[data-id=${userId}]`).bootstrapToggle(status ? 'off' : 'on');
//             },
//             error: function(xhr, status, error) {
//                 console.error('An error occurred:', xhr.responseText || error);
//                 // Kembalikan toggle ke status sebelumnya jika ada error
//                 $(`.toggle-class[data-id=${userId}]`).bootstrapToggle(status ? 'off' : 'on');
//             }
//         });
//         event.stopPropagation();
//         event.preventDefault();
//     });
// });
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

          console.log(`User ID: ${userId}, Status: ${status}`);

          isAjaxRunning = true; // Set flag sebelum memulai AJAX
          $toggle.bootstrapToggle('disable'); // Disable tombol sementara

          $.ajax({
              type: "POST",
              dataType: "json",
              url: `/updated-permission/${userId}`,
              headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
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
                  isAjaxRunning = false; // Reset flag setelah AJAX selesai
                  $toggle.bootstrapToggle('enable'); // Enable tombol kembali
              }
          });
      });
  });






</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

@endpush