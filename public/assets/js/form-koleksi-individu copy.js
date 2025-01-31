// show n hide sk

  const asalSatwaRadios = document.getElementsByName("asal_satwa");
  const statusSatwaRadios = document.getElementsByName("status_satwa");
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
        skKepalaBalaiInput.value = ""

        // skDirjenInput.setAttribute("title", "Tolong diisi nomor SK!"); // Menambahkan title
      } else {
        skKepalaBalaiDiv.style.display = "block";
        skKepalaBalaiInput.setAttribute("required", "required");
        skKepalaBalaiInput.setAttribute("title", "Tolong diisi nomor SK!"); // Menambahkan title
        skDirjenInput.removeAttribute("required", "required");
        skDirjenInput.value = "";

      }
    }
  }

  // Menambahkan event listener untuk memperbarui visibilitas saat ada perubahan pada radio button
  [...asalSatwaRadios, ...statusSatwaRadios].forEach(radio => {
    radio.addEventListener('change', handleVisibility);
  });

  // Pengecekan awal saat halaman dimuat
  handleVisibility();



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
    dateFormat: "Y/M/D",
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


// fetch 

  const form = document.getElementById('form-satwa');
  const token = localStorage.getItem('auth_token');

  // form.addEventListener('submit', function (event) {
  //     event.preventDefault();

  //   const formData = new FormData(form);
  
  //     let data = {};

  //     const keyMap = {
  //       'nama_lk_display': 'id_lk',
  //       'nama_ilmiah': 'id_spesies',
  //       'asal_usul': 'asal_usul',
  //       'jenis-kelamin': 'jenis_kelamin',
  //       'jenis_tagging': 'bentuk_tagging',
  //       'kode-tagging': 'kode_tagging',
  //       'nama_panggilan': 'nama_panggilan',
  //       'umur': 'umur',
  //       'asal-usul-satwa-silsilah' : 'asal_usul',
  //       'cara-perolehan-koleksi': 'cara_perolehan_koleksi',
  //       'doc_asal_usul': 'doc_asal_usul',
  //       'doc_bap_kelahiran' : 'doc_bap_kelahiran',
  //       'tanggal-lahir': 'tanggal_lahir',
  //       'asal-satwa': 'asal_satwa', // asal-usul satwa silsilah
  //       'status-satwa': 'status_perlindungan_satwa',
  //       'sk-kepala-balai': 'sk_kepala_balai',
  //       'sk-dirjen': 'sk_dirjen',
  //     };
  //     for (let key in keyMap) {
  //       const element = form.elements[key];
  
  //       if (element) {
  //           if (keyMap[key] === 'id_lk') {
  //               if (element && element.list) {
  //                   const selectedOption = element.list.querySelector(`option[value="${element.value}"]`);
  //                   if (selectedOption) {
  //                     let idLk = selectedOption.id || selectedOption.value || "";
  //                     data[keyMap[key]] = idLk;
                    
  //                   }
  //               }
  //           }
  //           else if (keyMap[key] === 'id_spesies') {
  //               if (element && element.list) {
  //                   const selectedOption = element.list.querySelector(`option[value="${element.value}"]`);
  //                   if (selectedOption) {
  //                     data['nama_ilmiah'] = selectedOption.value
  //                     data[keyMap[key]] = selectedOption.id
                    
  //                   }
  //               }
  //           }
  //           else {
  //               data[keyMap[key]] = element.value;
  //           }
  //       }
  //   }


  //     console.log("Data yang akan dikirim:", data);

  //     fetch('/form-koleksi-individu', {
  //         method: 'POST',
  //         headers: {
  //             'Accept': 'application/json',
  //             'Content-Type': 'application/json',
  //             'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
  //             'Authorization': `Bearer ${token}`,
  //         },
  //         body: JSON.stringify(data)
  //     })
  //     .then(response => response.json())
  //     .then(data => {
  //         console.table("Response Data:", data);
  //         if (data.success) {
  //             // alert('Data berhasil disimpan!');
  //             // window.location.href = '/halaman-berikutnya';
  //         } else {
  //             alert('Terjadi kesalahan!');
  //         }
  //     })
  //     .catch(error => {
  //         console.error('Error:', error);
  //         alert('Ada masalah dengan pengiriman data.');
  //     });
// });



  // form.addEventListener('submit', function (event) {
  //   event.preventDefault();
  
  //   const data = {
  //     id_lk: document.querySelector('[name="nama_lk_display"]').id ,
  //     id_spesies: document.querySelector('[name="nama_ilmiah"]').id ,
  //     nama_ilmiah: document.querySelector('[name="nama_ilmiah"]').value ,
  //     cara_perolehan_koleksi: document.querySelector('[name="perolehan_satwa_koleksi"]').value ,
  //     asal_usul: document.querySelector('[name="asal-usul-satwa-silsilah"]').value ,
  //     nama_panggilan: document.querySelector('[name="nama_panggilan"]').value ,
  //     jenis_kelamin: document.querySelector('[name="jenis-kelamin"]').value ,
  //     bentuk_tagging: document.querySelector('[name="jenis_tagging"]').value ,
  //     kode_tagging: document.querySelector('[name="kode-tagging"]').value ,
  //     umur: document.querySelector('[name="umur"]').value,
  //     tanggal_lahir: document.querySelector('[name="tanggal-lahir"]').value ||"" ,
  //     doc_asal_usul: document.querySelector('[name="doc_asal_usul"]').value ,
  //     doc_bap_kelahiran: document.querySelector('[name="doc_bap_kelahiran"]').value ,
  //     asal_satwa: document.querySelector('[name="asal-satwa"]').value ,
  //     status_perlindungan_satwa: document.querySelector('[name="status-satwa"]').value ,
  //     sk_koleksi_dirjen: document.querySelector('[name="sk-dirjen"]').value || "" ,
  //     sk_koleksi_kepala_balai: document.querySelector('[name="sk-kepala-balai"]').value || "",
  //   };

  
  //   console.log("Data yang akan dikirim:", data);
  
  //   fetch('/form-koleksi-individu', {
  //     method: 'POST',
  //     headers: {
  //       'Accept': 'application/json',
  //       'Content-Type': 'application/json',
  //       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
  //       'Authorization': `Bearer ${token}`
  //     },
  //     body: JSON.stringify(data)
  //   })
  //     .then(response => {
  //       if (!response.ok) {
  //         throw new Error(`HTTP error! Status: ${response.status}`);
  //       }
  //       return response.json();
  //     })
  //     .then(data => {
  //       console.log("Response Data:", data);
  //       if (data.success) {
  //         alert('Data berhasil disimpan!');
  //         // Uncomment baris berikut untuk redirect
  //         // window.location.href = '/halaman-berikutnya';
  //       } else {
  //         alert(data.message || 'Terjadi kesalahan!');
  //       }
  //     })
  //     .catch(error => {
  //       console.error('Error:', error);
  //       alert('Ada masalah dengan pengiriman data. Silakan coba lagi.');
  //     });
  // });
  


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
          document.getElementById('id_lk').value = id_lk;
        }
      
    })

    document.querySelector('[name="nama_ilmiah"]').addEventListener('input', function() {
      var selectedOption = Array.from(document.getElementById('list_namaIlmiah').options)
          .find(option => option.value === this.value);
      if (selectedOption) {
          document.querySelector('[name="id_spesies"]').value = selectedOption.getAttribute('id');
      }
  });
  

  
function upload(button) {
  window.location.href = "/form-koleksi-individu"
}

