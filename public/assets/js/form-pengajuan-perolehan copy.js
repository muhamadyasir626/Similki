
  // validate input asal lk
  function validateInput() {
    var input = document.getElementById('asal_lk');
    var datalist = document.getElementById('listlk');
    var options = datalist.getElementsByTagName('option');
    var errorMessage = document.getElementById('error-message');
    var valid = false;

    for (var i = 0; i < options.length; i++) {
      if (input.value === options[i].value) {
        errorMessage.style.display = 'none';
        valid = true;
        break;
      }
    }

    if (!valid) {
      errorMessage.style.display = 'inline'
      input.value = '';  
    }
}
  
let valueCaraPerolehan;
let valueAsalSatwa;
let valueStatusPerlindungan;

const caraPerolehanSelect = document.getElementById('caraPerolehan');
const asalSatwa = document.getElementsByName('asal_satwa');
const statusPerlindungan = document.getElementsByName('status_perlindungan');
const asalLkDiv = document.getElementById('input_asal_satwa');
const inputAsalLk = document.getElementById('listlk');

function showHide() {
    valueCaraPerolehan = [...caraPerolehanSelect.options].find(option => option.selected)?.textContent;
    valueAsalSatwa = [...asalSatwa].find(radio => radio.checked)?.value;
    valueStatusPerlindungan = [...statusPerlindungan].find(radio => radio.checked)?.nextElementSibling?.textContent;
  
    if (valueCaraPerolehan === 'hibah pemberian/sumbangan' || valueCaraPerolehan === 'tukar menukar' || valueCaraPerolehan === 'peminjaman') {
        asalLkDiv.style.display = "flex";
        inputAsalLk.setAttribute('required', true);
    } else {
        asalLkDiv.style.display = "none";
        inputAsalLk.removeAttribute('required');
        inputAsalLk.value = '';
    }

    if (valueCaraPerolehan === 'penyerahan' && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'indonesia') {
        showRequiredFields([
            'input_surat_permohonan',
            'input_salinan_keputusan_pengadilan',
            'input_berita_acara_sarana',
            'input_rekomendasi_bbksda_pemohon',
            'input_berita_acara_satwa',
            'input_rekomendasi_bbksda_asal_satwa',
            'input_surat_kesehatan_satwa',
            'input_keterangan_asal_silsilah',
            'dokumenlainnya'
        ]);
    } else if (valueCaraPerolehan === 'hibah pemberian/sumbangan' && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'asing') {
        showRequiredFields([
            'input_surat_permohonan',
            'input_surat_menerima_hibah',
            'input_surat_memberi_hibah',
            'input_berita_acara_sarana',
            'input_surat_ba_pemeriksaan_satwa',
            'input_rekomendasi_bbksda_pemohon',
            'input_berita_acara_satwa',
            'input_rekomendasi_scientific_authority',
            'dokumenlainnya'
        ]);
    } else if ((valueCaraPerolehan === 'hibah pemberian/sumbangan' || valueCaraPerolehan === 'peminjaman') && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'indonesia') {
        showRequiredFields([
            'input_surat_permohonan',
            'input_dokumen_kerja_sama',
            'input_berita_acara_sarana',
            'input_rekomendasi_bbksda_pemohon',
            'input_berita_acara_satwa',
            'input_rekomendasi_bbksda_domisili_asal',
            'input_surat_kesehatan_satwa',
            'input_keterangan_asal_silsilah',
            'dokumenlainnya'
        ]);
    } else if (valueCaraPerolehan === 'Pengambilan dari instansi pemerintah' && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'indonesia') {
        showRequiredFields([
            'input_surat_permohonan',
            'input_berita_acara_sarana',
            'input_rekomendasi_bbksda_pemohon',
            'input_berita_acara_satwa',
            'input_rekomendasi_bbksda_domisili_asal',
            'input_surat_kesehatan_satwa',
            'input_keterangan_asal_silsilah',
            'input_pnbp',
            'dokumenlainnya'
        ]);
    } else {
        hideAllFields();
    }
}

function showRequiredFields(fields) {
    fields.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.style.display = 'flex';
            const input = field.querySelector('input');
            if (input) input.setAttribute('required', true);
        }
    });
}

function hideAllFields() {
    const allFields = document.querySelectorAll('.file1');
    allFields.forEach(field => {
        field.style.display = 'none';
        const input = field.querySelector('input');
        if (input) {
            input.removeAttribute('required');
            input.value = '';
        }
    });
}

caraPerolehanSelect.addEventListener('change', showHide);
[...asalSatwa, ...statusPerlindungan].forEach(radio => {
    radio.addEventListener('change', showHide);
});

showHide();



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
     
        document.getElementsByName('nama_internasional')[0].value = response.data.nama_internasional;
        document.getElementsByName('nama_lokal')[0].value = response.data.nama_lokal;
        document.getElementsByName('class')[0].value = response.data.class;
        document.getElementsByName('id_spesies')[0].value = response.data.id;
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