<!-- Kontainer Notifikasi Global -->
<div id="globalNotificationContainer" style="display: none; position: fixed; top: 20px; right: 20px; padding: 10px; z-index: 10000; border-radius: 5px; box-shadow: 0 0 10px;  color:white; font-weight:bold;">
    <p id="globalNotificationMessage">test</p>
</div>

<script>
  // Fungsi untuk menampilkan notifikasi
  function showNotification(message, type, duration = 5000) {
      const notificationContainer = document.getElementById('globalNotificationContainer');
      const messageP = document.getElementById('globalNotificationMessage');

      // Set pesan notifikasi
      messageP.textContent = message;
      notificationContainer.style.display = 'block';

      // Warna notifikasi berdasarkan tipe
      switch (type) {
          case 'success':
              notificationContainer.style.backgroundColor = '#4CAF50'; // Hijau
              break;
          case 'error':
              notificationContainer.style.backgroundColor = '#f44336'; // Merah
              break;
          default:
              notificationContainer.style.backgroundColor = '#2196F3'; // Biru
      }

      // Sembunyikan notifikasi setelah durasi
      setTimeout(() => {
          notificationContainer.style.display = 'none';
      }, duration);
  }

  // Saat DOM selesai dimuat
  document.addEventListener('DOMContentLoaded', function () {
      // Periksa notifikasi dari session Laravel
      const notification = @json(session('notification'));
      if (notification) {
          showNotification(notification.message, notification.type, 5000);
      }

      // Ambil notifikasi dari localStorage
      const storedNotification = JSON.parse(localStorage.getItem('notification'));
      if (storedNotification) {
          showNotification(storedNotification.message, storedNotification.type, 5000);
          // Hapus notifikasi dari localStorage setelah ditampilkan
          localStorage.removeItem('notification');
      }
  });
</script>
