function togglePasswordVisibility(fieldId, imgElement) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute("type") === "password" ? "text" : "password";
    field.setAttribute("type", type);
  
    const img = imgElement.querySelector('img');
    if (type === "text") {
        img.src = imgElement.getAttribute('data-show'); 
        img.alt = "show password";
    } else {
        img.src = imgElement.getAttribute('data-hide');
        img.alt = "hide password";
    }
  }
  
  
  function validateInput() {
    const input = document.getElementById('login').value;
    const errorMessage = document.getElementById('error-message');
  
    // Pola untuk username
    const usernamePattern = /^[a-zA-Z0-9._-]+$/;
  
    // Pola untuk email
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  
    // Validasi input
    if (usernamePattern.test(input) || emailPattern.test(input)) {
        errorMessage.style.display = 'none'; // Valid: sembunyikan pesan error
    } else {
        errorMessage.style.display = 'block'; // Tidak valid: tampilkan pesan error
    }
  }
  
  function validateInput() {
    const input = document.getElementById('login').value;
    const errorMessage = document.getElementById('input-invalid');
    const submitBtn = document.getElementById('submitBtn');
  
    // Pola untuk username
    const usernamePattern = /^[a-zA-Z0-9._-]+$/;
  
    // Pola untuk email
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  
    // Validasi input
    if (usernamePattern.test(input) || emailPattern.test(input)) {
        errorMessage.style.display = 'none'; // Valid: sembunyikan pesan error
        submitBtn.disabled = false; // Aktifkan tombol
        submitBtn.classList.add('enabled'); // Tambahkan class enabled
        submitBtn.classList.remove('disabled'); // Hapus class disabled
    } else {
        errorMessage.style.display = 'block'; // Tidak valid: tampilkan pesan error
        submitBtn.disabled = true; // Nonaktifkan tombol
        submitBtn.classList.add('disabled'); // Tambahkan class disabled
        submitBtn.classList.remove('enabled'); // Hapus class enabled
    }
  }
  
  
  
  document.getElementById('submitBtn').addEventListener('click', function (event) {
      event.preventDefault();
      const login = document.getElementById('login').value;
      const password = document.getElementById('password').value;
      const remember = document.getElementById('remember_me').checked;
      const csrfToken = document.querySelector('input[name="_token"]').value;
      const errorDiv = document.getElementById('error-message');
  
      if (!password || !login) {
          errorDiv.textContent = 'Tolong isi username/email dan password';
          errorDiv.style.display = 'block';
      }
      
      fetch(`/login`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({
              login: login,
              password: password,
              remember: remember,
              _token: csrfToken
          })
      })
      .then(response => response.json())
          .then(response => {
          localStorage.setItem('auth_token', response.data.token);
          console.log(response.data.status);
      
          if (response.data.status == 1) {
              window.location.href = '/dashboard';
          } else {
              window.location.href = '/permission';
          }
      
      })
      .catch(error => {
          console.error('Error:', error);
          errorDiv.textContent = 'Email/Username atau password salah, silakan coba lagi'
          errorDiv.style.display = 'block';
      });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
      loadNotification();
    });