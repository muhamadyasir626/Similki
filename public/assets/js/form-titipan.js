const lk = document.getElementById('input_lk');
const listlk = document.getElementById('nama_lk_display');

document.getElementById('asal_satwa_titipan').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption && selectedOption.id === "lk") {
        lk.style.display = "block";
        lk.setAttribute("required", "required");
    } else {
        lk.style.display = "none";
        document.getElementById('id_lk').value = "";
        lk.removeAttribute("required");
        console.log(lk);
        
        listlk.value = "";
    }
});

listlk.addEventListener('blur', function () {
    const inputValue = listlk.value;
    const options = document.querySelectorAll('#lk_options option');
    let isValid = false;
    let selectedId = "";

    options.forEach(option => {
        if (option.value === inputValue) {
            isValid = true;
            selectedId = option.id;
        }
    });

    if (isValid) {
        document.getElementById('id_lk').value = selectedId;
    } else {
        console.log("Invalid input.");
    }
});

listlk.addEventListener('input', function () {
    const selectedOption = Array.from(document.getElementById('lk_options').options)
        .find(option => option.value === this.value);
        
    if (selectedOption) {
        document.getElementById('id_lk').value = selectedOption.getAttribute('id');
    } else {
        document.getElementById('id_lk').value = "";
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const namaIlmiahInput = document.querySelector('[name="nama_ilmiah"]');
    const idSpesiesInput = document.querySelector('[name="id_spesies"]');
    const namaIlmiahDatalist = document.getElementById('list_namaIlmiah');

    const asalSatwaSelect = document.getElementById('asal_satwa_titipan');
    const namaAsalSatwaInput = document.querySelector('[name="nama_asal_titipan"]');

    if (asalSatwaSelect && namaAsalSatwaInput) {
        asalSatwaSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption) {
                namaAsalSatwaInput.value = selectedOption.id;
            } else {
                namaAsalSatwaInput.value = '';
            }
        });
    }

    if (namaIlmiahInput && idSpesiesInput && namaIlmiahDatalist) {
        namaIlmiahInput.addEventListener('input', function () {
            const selectedOption = Array.from(namaIlmiahDatalist.options)
                .find(option => option.value === this.value);

            if (selectedOption) {
                idSpesiesInput.value = selectedOption.getAttribute('id');
            } else {
                idSpesiesInput.value = '';
            }
        });

        namaIlmiahInput.addEventListener('blur', function () {
            const selectedOption = Array.from(namaIlmiahDatalist.options)
                .find(option => option.value === this.value);

            if (!selectedOption) {
                namaIlmiahInput.value = '';
                idSpesiesInput.value = '';
            }
        });
    }
});


document.getElementsByName('nama_ilmiah')[0].addEventListener("input", debounce(searchListSpecies, 2000));

function searchListSpecies() {
  let nama_ilmiah = document.getElementsByName('nama_ilmiah')[0].value;
  const token = localStorage.getItem('auth_token');

  fetch(`/api/search-ListSpecies/?nama_ilmiah=${nama_ilmiah}`, {
      method: "GET",
      headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
      }
  })
  .then(response => {
      if (!response.ok) {
          throw new Error('Failed to fetch data');
      }
      return response.json();
  })
  .then(response => {
      if (response.data) {
          document.getElementById('english_name').value = response.data.nama_internasional || '';
          document.getElementById('nama_lokal').value = response.data.nama_lokal || '';
      }
  })
  .catch(error => {
      console.error('Error:', error);
    //   alert('Terjadi kesalahan saat mengambil data.');
  });
}

    
    function debounce(func, wait) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
}



