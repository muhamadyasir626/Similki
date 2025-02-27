<!-- Kontainer Notifikasi Global -->
<div id="globalNotificationContainer" style="display: none; position: fixed; top: 20px; right: 20px; padding: 10px; z-index: 10000; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.2);">
    <p id="globalNotificationMessage">test</p>
  </div>
  
  <script>
  // Menampilkan Notifikasi
  function showNotification(message, type, duration = 5000) {
      const notificationContainer = document.getElementById('globalNotificationContainer');
      const messageP = document.getElementById('globalNotificationMessage');
  
      messageP.textContent = message;
      notificationContainer.style.display = 'block';
  
      // Set background color based on the type of notification
      switch (type) {
          case 'success':
          case true:
              notificationContainer.style.backgroundColor = '#4CAF50'; // Green
              break;
          case 'error':
              notificationContainer.style.backgroundColor = '#f44336'; // Red
              break;
          default:
              notificationContainer.style.backgroundColor = '#2196F3'; // Default: Blue
      }
  
      // Save the notification to Local Storage
      localStorage.setItem('notification', JSON.stringify({ message, type }));
  
      // Auto hide the notification after 'duration' milliseconds
      setTimeout(() => {
          notificationContainer.style.display = 'none';
          localStorage.removeItem('notification'); // Remove from storage after hiding
      }, duration);
  }
  
  // Memuat Notifikasi dari LocalStorage
  function loadNotification() {
      const notification = localStorage.getItem('notification');
      if (notification) {
          const { message, type } = JSON.parse(notification);
          showNotification(message, type, 5000);
      }
  }
  
  // Panggil loadNotification() saat halaman dimuat
  window.onload = loadNotification;
  </script>
  