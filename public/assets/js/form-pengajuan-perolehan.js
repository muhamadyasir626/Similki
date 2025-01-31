
  // validate input asal lk
  function validateInput() {
    var input = document.getElementById('asal_lk');
    var datalist = document.getElementById('listlk');
    var options = datalist.getElementsByTagName('option');
    var errorMessage = document.getElementById('error-message');
    var inputIdAsalLk = document.getElementById('id_lk');
    var valid = false;

    for (var i = 0; i < options.length; i++) {
      if (input.value === options[i].value) {
        inputIdAsalLk.value = options[i].id;
        errorMessage.style.display = 'none';
        valid = true;
        break;
      }
    }

    if (!valid) {
      errorMessage.style.display = 'inline'
      input.value = '';  
      inputIdAsalLk.value = '';
    }
}
  
let valueCaraPerolehan;
let valueAsalSatwa;
let valueStatusPerlindungan;
let show = [];

const caraPerolehanSelect = document.getElementById('caraPerolehan');
const asalSatwa = document.getElementsByName('asal_satwa');
const statusPerlindungan = document.getElementsByName('status_perlindungan');
const asalLkDiv = document.getElementById('input_asal_satwa');
let namaCaraPerolehan = document.getElementById('namaCaraPerolehan');
const inputAsalLk = document.getElementById('asal_lk');
const inputIdAsalLk = document.getElementById('id_lk');
const update = document.getElementById('update');


function showHide() {
    valueCaraPerolehan = [...caraPerolehanSelect.options].find(option => option.selected)?.textContent;
    valueAsalSatwa = [...asalSatwa].find(radio => radio.checked)?.value;
    valueStatusPerlindungan = [...statusPerlindungan].find(radio => radio.checked)?.nextElementSibling?.textContent;
    namaCaraPerolehan.value = valueCaraPerolehan;

    // if (valueCaraPerolehan === 'penyerahan' && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'indonesia') {
    if (valueCaraPerolehan === 'penyerahan' && valueStatusPerlindungan === 'Dilindungi' ) {
          show = [
            'input_surat_permohonan',
            'input_salinan_keputusan_pengadilan',
            'input_berita_acara_pemeriksaan_sarana',
            'input_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima',
            'input_berita_acara_pemeriksaan_satwa',
            'input_rekomendasi_kepala_b_bksda_asal_satwa',
            'input_surat_keterangan_kesehatan_satwa',
            'dokumenlainnya',
            'input_keterangan_asal_usul_silsilah_satwa',
          ]
          showRequiredFields(show);
        hideExceptFields(show);

          
    } else if (valueCaraPerolehan === 'hibah pemberian/sumbangan' && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'asing') {
      
        show = [
          'input_surat_permohonan',
          'input_surat_keterangan_menerima_hibah',
          'input_surat_keterangan_memberi_hibah',
          'input_berita_acara_pemeriksaan_sarana',
          'input_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima',
          'input_berita_acara_pemeriksaan_satwa',
          'input_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa',
          'input_surat_keterangan_kesehatan_satwa',
          'input_keterangan_asal_usul_silsilah_satwa',
          'input_rekomendasi_scientific_authority_appendix_i_cites',
          'input_asal_satwa',
          'dokumenlainnya'
        ];
          showRequiredFields(show);
        hideExceptFields(show);

      
    }
    // else if ((valueCaraPerolehan === 'tukar menukar' || valueCaraPerolehan === 'peminjaman') && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'indonesia') {
    else if ((valueCaraPerolehan === 'tukar menukar' || valueCaraPerolehan === 'peminjaman') && valueStatusPerlindungan === 'Dilindungi') {
          show = [
            'input_surat_permohonan',
            'input_dokumen_kerja_sama',
            'input_berita_acara_pemeriksaan_sarana',
            'input_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima',
            'input_berita_acara_pemeriksaan_satwa',
            'input_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa',
            'input_surat_keterangan_kesehatan_satwa',
            'input_keterangan_asal_usul_silsilah_satwa',
            'input_asal_satwa',
            'dokumenlainnya'
          ]
          showRequiredFields(show);
        hideExceptFields(show);

    }
    else if (valueCaraPerolehan === 'pengambilan dari instalasi pemerintah' && valueStatusPerlindungan === 'Dilindungi' && valueAsalSatwa === 'indonesia') {
    // else if (valueCaraPerolehan === 'pengambilan dari instalasi pemerintah' && valueStatusPerlindungan === 'Dilindungi') {
      show = [
        'input_surat_permohonan',
        'input_berita_acara_pemeriksaan_sarana',
        'input_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima',
        'input_berita_acara_pemeriksaan_satwa',
        'input_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa',
        'input_surat_keterangan_kesehatan_satwa',
        'input_keterangan_asal_usul_silsilah_satwa',
        'input_pnbp',
        'dokumenlainnya'
      ];
        showRequiredFields(show);
        hideExceptFields(show);
      
    }
    else {
      show = [
        'input_asal_satwa',
      ];
      hideExceptFields(show);

      // hideAllFields();
  }
  
  if (valueCaraPerolehan === 'hibah pemberian/sumbangan' || valueCaraPerolehan === 'tukar menukar' || valueCaraPerolehan === 'peminjaman') {
      asalLkDiv.style.display = "flex";
      inputAsalLk.setAttribute('required', true);
  } else {
    inputAsalLk.removeAttribute('required');
    inputAsalLk.value = "";
    inputIdAsalLk.value = "";
    asalLkDiv.style.display = "none";
  }
}

function showRequiredFields(fields) {
    fields.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.style.display = 'flex';
          const input = field.querySelector('input');
          console.log(input.name);
            if (input.name !== 'dokumen_lainnya[]' && update === 0) input.setAttribute('required', true);
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
            input.value = "";
        }
    });
}

function hideExceptFields(excludeIds = []) {
  const allFields = document.querySelectorAll('.file1');
  allFields.forEach(field => {
      const fieldId = field.id;

      if (!excludeIds.includes(fieldId)) {
          field.style.display = 'none';
          const input = field.querySelector('input');
          if (input) {
              input.removeAttribute('required');
              input.value = "";
          }
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
     
        document.getElementsByName('nama_internasional')[0].value = response.data.nama_internasional ? response.data.nama_internasional : '-';
        document.getElementsByName('nama_lokal')[0].value = response.data.nama_lokal ? response.data.nama_lokal : '-';
        document.getElementsByName('class')[0].value = response.data.class? response.data.class : '-';
        document.getElementsByName('id_spesies')[0].value = response.data.id ? response.data.id : '-';
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

document.querySelectorAll('.clearDokumenBtn').forEach(function(clearBtn) {
  clearBtn.addEventListener('click', function() {
    const inputFile = clearBtn.parentElement.querySelector('input[type="file"]');
    inputFile.value = '';
  });
});

document.getElementById('addDokumenBtn').addEventListener('click', function() {
  const dokumenContainer = document.getElementById('dokumenContainer');

  const newInputContainer = document.createElement('div');
  newInputContainer.classList.add('inputContainer');

  const newInput = document.createElement('input');
  newInput.type = 'file';
  newInput.name = 'dokumen_lainnya[]';
  newInput.classList.add('file');
  newInput.id = 'doc_lainnya';
  newInput.accept = 'application/pdf';

  const deleteBtn = document.createElement('button');
  deleteBtn.type = 'button';
  deleteBtn.classList.add('btn', 'btn-danger', 'deleteDokumenBtn');
  deleteBtn.textContent = 'Delete';
  
  deleteBtn.addEventListener('click', function() {
      dokumenContainer.removeChild(newInputContainer);
  });

  const clearBtn = document.createElement('button');
  clearBtn.type = 'button';
  clearBtn.classList.add('btn', 'btn-warning', 'clearDokumenBtn');
  clearBtn.textContent = 'Clear';

  clearBtn.addEventListener('click', function() {
    newInput.value = '';
  });

  newInputContainer.appendChild(newInput);
  newInputContainer.appendChild(clearBtn);
  newInputContainer.appendChild(deleteBtn);
  dokumenContainer.appendChild(newInputContainer);
});


document.addEventListener('DOMContentLoaded', function () {
  const namaIlmiahInput = document.querySelector('[name="nama_ilmiah"]');
  const idSpesiesInput = document.querySelector('[name="id_spesies"]');
  const namaIlmiahDatalist = document.getElementById('list_namaIlmiah');

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
