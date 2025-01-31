<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('/assets/images/klhk.png') }}" type="image/png">
  <!-- <link href="{{ asset('css/permission.css') }}" rel="stylesheet"> -->
  
  <title>Wait Permission</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <img src="{{ asset('assets/images/verifikasi.png') }}" alt="waiting for permission" style="width: 50%;">
  
  {{-- <script>
    window.onload = function() {
<<<<<<< Updated upstream
      const token = localStorage.getItem('access_token'); // Pastikan kunci ini sesuai dengan yang Anda gunakan saat menyimpan

      fetch(`/check-permission`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}` // Sesuaikan format Bearer jika backend Anda memerlukannya
=======
      // const token = localStorage.getItem('access_token'); 
      const token = localStorage.getItem('auth_token'); 
      
      $.ajax({
        url: '/api/check-permission',
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        success: function(data) {
            if (data.status_permission == '1') {
                // history.pushState(null, null, '/dashboard'); 
                window.location.href = '/dashboard';
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
>>>>>>> Stashed changes
        }
    });

    //   fetch(`/api/check-permission`, {
    //     method: 'GET',
    //     headers: {
    //       'Content-Type': 'application/json',
    //       'Authorization': `Bearer ${token}` 
    //     }
    //   })
    //   .then(response => response.json())
    //   .then(data => {
    //     // console.log(data.status_permission);
    //     if (data.status_permission == '1') {
    //       window.location.href = '/dashboard';
    //     }
    //   })
    //   .catch(error => console.error('Error:', error));
    };
  </script> --}}
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
const token = localStorage.getItem('auth_token'); 

function checkPermission() {
    $.ajax({
        url: '/api/check-permission',
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        success: function(data) {
            if (data.status_permission == '1') {
                window.location.href = '/dashboard';
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
        }
    });
}

const interval = setInterval(checkPermission, 5000);

</script>

</body>
</html>
