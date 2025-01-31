document.addEventListener('DOMContentLoaded', () => {
  const pelabuhanInput = document.getElementById('namaPelabuhanInput');
  const pelabuhanDatalist = document.getElementById('namaPelabuhanList');
  const pelabuhanError = document.getElementById('pelabuhanError');

  let timeout = null;

  pelabuhanInput.addEventListener('input', () => {
    const query = pelabuhanInput.value;

    // Reset datalist jika query kurang dari 3 karakter
    if (query.length < 3) {
      pelabuhanDatalist.innerHTML = '';
      pelabuhanError.style.display = 'none';
      return;
    }

    if (timeout) {
      clearTimeout(timeout);
    }

    timeout = setTimeout(() => {
      fetch(`/api/get-pelabuhan-indonesia?query=${encodeURIComponent(query)}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Gagal mengambil data pelabuhan.');
          }
          return response.json();
        })
        .then(data => {
          if (data.status === 'success') {
            pelabuhanDatalist.innerHTML = '';

            if (data.data.length === 0) {
              pelabuhanError.style.display = 'block';
              return;
            }

            pelabuhanError.style.display = 'none';
            
            data.data.forEach(item => {
              const option = document.createElement('option');
              option.value = item.nama;  
              pelabuhanDatalist.appendChild(option);              
            });
          } else {
            console.error('Tidak ada hasil ditemukan:', data.message);
          }
        })
        .catch(error => {
          console.error('Terjadi kesalahan:', error);
        });
    }, 900);
  });

  pelabuhanInput.addEventListener('change', () => {
    const inputValue = pelabuhanInput.value;
    const options = Array.from(pelabuhanDatalist.options);
    const isValid = options.some(option => option.value === inputValue);

    // Validasi input, pastikan input sesuai dengan salah satu pelabuhan yang valid
    if (!isValid) {
      pelabuhanError.style.display = 'block';
      pelabuhanInput.value = '';
    } else {
      pelabuhanError.style.display = 'none';
    }
  });
});
