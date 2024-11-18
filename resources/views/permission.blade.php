<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS dibatalkan sementara untuk demonstrasi -->
  <!-- <link href="{{ asset('css/permission.css') }}" rel="stylesheet"> -->

  <title>Wait Permission</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <img src="{{ asset('assets/images/verifikasi.png') }}" alt="waiting for permission" style="width: 50%;">
  <script>
    window.onload = function() {
      const token = localStorage.getItem('access_token'); // Pastikan kunci ini sesuai dengan yang Anda gunakan saat menyimpan

      fetch(`/check-permission`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}` // Sesuaikan format Bearer jika backend Anda memerlukannya
        }
      })
      .then(response => response.json())
      .then(data => {
        // console.log(data.status_permission);
        if (data.status_permission == '1') {
          window.location.href = '/dashboard';
        }
      })
      .catch(error => console.error('Error:', error));
    };
  </script>
</body>
</html>
