// show n hide sk
const asalSatwaRadios = document.getElementsByName("asal-satwa");
const statusSatwaRadios = document.getElementsByName("status-satwa");
const skDirjenDiv = document.getElementById("sk-dirjen");
const skKepalaBalaiDiv = document.getElementById("sk-kepala-balai");
const skDirjenInput = document.getElementById("sk-dirjen-input");
const skKepalaBalaiInput = document.getElementById("sk-kepala-balai-input");

function handleVisibility() {
  const asalSatwaValue = [...asalSatwaRadios].find(radio => radio.checked)?.value;
  const statusSatwaValue = [...statusSatwaRadios].find(radio => radio.checked)?.value;

  skDirjenDiv.style.display = "none";
  skKepalaBalaiDiv.style.display = "none";

  // Menghapus atribut 'required' dan 'title' dari kedua input SK

  if (asalSatwaValue && statusSatwaValue) {
    const isSatwaDirjen = asalSatwaValue === "1" || asalSatwaValue === "0";
    const isStatusDilindungi = statusSatwaValue === "1";

    
    if (isSatwaDirjen && isStatusDilindungi) {
      skDirjenDiv.style.display = "block";
      skDirjenInput.setAttribute("required", "required");
      skKepalaBalaiInput.removeAttribute("required", "required");
      // skDirjenInput.setAttribute("title", "Tolong diisi nomor SK!"); // Menambahkan title
      
    } else {
      skKepalaBalaiDiv.style.display = "block";
      skKepalaBalaiInput.setAttribute("required", "required");
      skKepalaBalaiInput.setAttribute("title", "Tolong diisi nomor SK!"); // Menambahkan title
      skDirjenInput.removeAttribute("required", "required");
    }
  }
}

// Menambahkan event listener untuk memperbarui visibilitas saat ada perubahan pada radio button
[...asalSatwaRadios, ...statusSatwaRadios].forEach(radio => {
  radio.addEventListener('change', handleVisibility);
});

// Pengecekan awal saat halaman dimuat
handleVisibility();


// Tanggal lahir

const tanggalLahirInput = document.getElementById('tanggal-lahir');
const umurInput = document.getElementById('umur');
const errorMessage = document.getElementById('error-message');

function destroyFlatpickrInstance() {
  if (tanggalLahirInput._flatpickr) {
    tanggalLahirInput._flatpickr.destroy();
  }
}

destroyFlatpickrInstance();
flatpickr("#tanggal-lahir", {
  dateFormat: "m/d/Y",
  onChange: function(selectedDates, dateStr) {
    calculateAge(dateStr);
  }
});

function calculateAge(birthDateValue) {
  if (!birthDateValue) {
    errorMessage.style.display = 'inline';
    umurInput.value = '';
    return;
  }

  errorMessage.style.display = 'none';

  const birthDate = new Date(birthDateValue);
  const today = new Date();

  if (isNaN(birthDate.getTime())) {
    errorMessage.textContent = 'Tanggal lahir tidak valid!';
    errorMessage.style.display = 'inline';
    umurInput.value = '';
    return;
  }

  let age = today.getFullYear() - birthDate.getFullYear();
  const month = today.getMonth();
  const day = today.getDate();

  if (month < birthDate.getMonth() || (month === birthDate.getMonth() && day < birthDate.getDate())) {
    age--;
  }

  umurInput.value = age;
}


// fetch 
const form = document.getElementById('form-satwa');
const token = localStorage.getItem('auth_token');
// const csrfToken = document.querySelector('meta[name="_token"]').getAttribute('content');

form.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(form);
    let data = {};

    const keyMap = {
      'nama_lk_display': 'id_lk',
      'scientific-name': 'nama_ilmiah',
      'english-name': 'nama_internasional',
      'nama-lokal': 'nama_lokal',
      'asal_usul': 'asal_usul',
      'jenis-kelamin': 'jenis_kelamin',
      'jenis_tagging': 'jenis_tagging',
      'kode-tagging': 'kode_tagging',
      'umur': 'umur',
      'tanggal-lahir': 'tanggal_lahir',
      'asal-satwa': 'asal_satwa',
      'status-satwa': 'status',
      'sk-kepala-balai': 'sk_kepala_balai',
      'sk-dirjen': 'sk_dirjen',

      // Tambahkan pemetaan lainnya sesuai kebutuhan
  };

  formData.forEach((value, key) => {
      // Ganti key jika ada dalam pemetaan, jika tidak, gunakan key asli
      const newKey = keyMap[key] || key;
      data[newKey] = value;
  });
    console.log("Data yang akan dikirim:", data);

    fetch('/', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response Data:", data);
        if (data.success) {
            alert('Data berhasil disimpan!');
            window.location.href = '/halaman-berikutnya';
        } else {
            alert('Terjadi kesalahan!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ada masalah dengan pengiriman data.');
    });
});

 // Get the first select element by name
 document.getElementsByName('nama_ilmiah')[0].addEventListener("input", debounce(searchListSpecies, 100));

 function searchListSpecies() {
   // Get the value of the selected option
   let nama_ilmiah = document.getElementsByName('nama_ilmiah')[0].value;
    // console.log(nama_ilmiah);
   const token = localStorage.getItem('auth_token');
   
   fetch(`/api/search-ListSpecies/?nama_ilmiah=${nama_ilmiah}`, {
     method: "GET",
     headers: {
       "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
       
     }
   })
     .then((response) => response.json())
     .then(response => {
       console.table(response.data.nama_lokal);
       
       document.getElementsByName('english-name')[0].value = response.data.nama_internasional;
       document.getElementsByName('nama-lokal')[0].value = response.data.nama_lokal;
      })
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

function validateSelection(inputElement) {
  // Get the datalist associated with the input element
  const datalistId = inputElement.getAttribute('list');
  const datalistElement = document.getElementById(datalistId);
  
  // Check if the input value matches any option in the datalist
  const validOption = Array.from(datalistElement.options).some(option => option.value === inputElement.value);

  // If the input value doesn't match any datalist option, clear the input field
  if (!validOption) {
    inputElement.value = ''; // Clear the input field
  }
}


