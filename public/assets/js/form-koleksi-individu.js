
// show n hide sk

const asalSatwaRadios = document.getElementsByName("asal_satwa");
const statusSatwaRadios = document.getElementsByName("status_perlindungan_satwa");
const skDirjenDiv = document.getElementById("sk-dirjen");
const skKepalaBalaiDiv = document.getElementById("sk-kepala-balai");
const skDirjenInput = document.getElementById("sk-dirjen-input");
const skKepalaBalaiInput = document.getElementById("sk-kepala-balai-input");

function handleVisibility() {
  const asalSatwaValue = [...asalSatwaRadios].find(radio => radio.checked)?.value;
  const statusSatwaValue = [...statusSatwaRadios].find(radio => radio.checked)?.value;

  skDirjenDiv.style.display = "none";
  skKepalaBalaiDiv.style.display = "none";


  if (asalSatwaValue && statusSatwaValue) {
    const isSatwaDirjen = asalSatwaValue === "1" || asalSatwaValue === "0";
    const isStatusDilindungi = statusSatwaValue === "1";

  
    if (isSatwaDirjen && isStatusDilindungi) {
      skDirjenDiv.style.display = "block";
      skDirjenInput.setAttribute("required", "required");
      skKepalaBalaiInput.removeAttribute("required", "required");
      skDirjenInput.setAttribute("title", "Tolong diisi nomor SK!");
      skKepalaBalaiInput.value = ""

    } else {
      skKepalaBalaiDiv.style.display = "block";
      skKepalaBalaiInput.setAttribute("required", "required");
      skKepalaBalaiInput.setAttribute("title", "Tolong diisi nomor SK!");
      skDirjenInput.removeAttribute("required", "required");
      skDirjenInput.value = "";

    }
  }
}


[...asalSatwaRadios, ...statusSatwaRadios].forEach(radio => {
  radio.addEventListener('change', handleVisibility);
});
  handleVisibility();





const tanggalLahirInput = document.getElementById('tanggal-lahir');
const umurInput = document.getElementById('umur');
const errorMessage = document.getElementById('error-message');

umurInput.addEventListener("input", function () {
  if (this.value) {
    tanggalLahirInput.value = "";
  }
});

function destroyFlatpickrInstance() {
  if (tanggalLahirInput._flatpickr) {
    tanggalLahirInput._flatpickr.destroy();
  }
}

destroyFlatpickrInstance();
flatpickr("#tanggal-lahir", {
  dateFormat: "Y/m/d",
  onChange: function (selectedDates, dateStr) {
    calculateAge(dateStr);
  }
});

function calculateAge(birthDateValue) {
  if (!birthDateValue) {
    errorMessage.style.display = 'inline';
    umurInput.value = '';
    return;
  }


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

document.getElementsByName('nama_ilmiah')[0].addEventListener("input", debounce(searchListSpecies, 100));

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
      .then((response) => response.json())
      .then(response => {
        //  console.table(response.data.nama_lokal);
     
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
    const datalistId = inputElement.getAttribute('list');
    const datalistElement = document.getElementById(datalistId);
    const validOption = Array.from(datalistElement.options).some(option => option.value === inputElement.value);

    if (!validOption) {
      inputElement.value = '';
    }
  }

  document.getElementById('nama_lk_display').addEventListener('input', function(){
    var selectedOption = Array.from(document.getElementById('lk_options').options)
          .find(option => option.value === this.value);
      if (selectedOption) {
          document.getElementById('id_lk').value = selectedOption.getAttribute('id');
      } else {
        const input_lk = document.querySelector('input[name="nama_lk_display"]');
        const id_lk = input_lk.id;
        if (id_lk === "nama_lk_display") {
          document.getElementById('id_lk').value ="";
        } else {
          document.getElementById('id_lk').value =id_lk;
        }
      }
    
  })

  document.querySelector('[name="nama_ilmiah"]').addEventListener('input', function() {
    var selectedOption = Array.from(document.getElementById('list_namaIlmiah').options)
        .find(option => option.value === this.value);
    if (selectedOption) {
        document.querySelector('[name="id_spesies"]').value = selectedOption.getAttribute('id');
    }
});




