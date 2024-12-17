// document.addEventListener('DOMContentLoaded', function () {
//     feather.replace();

//     // Ambil elemen count yang ada di halaman
//     const lk_count = document.getElementById('lk_count');
//     const species_count = document.getElementById('species_count');
//     const skoleksi_count = document.getElementById('skoleksi_count');
//     const stitipan_count = document.getElementById('stitipan_count');
//     const sbelumtag_count = document.getElementById('sbelumtag_count');
//     const shidup_count = document.getElementById('shidup_count');

//     // Ambil nilai awal dari elemen-elemen count
//     const initialData = {
//         Lk: parseInt(lk_count.innerText) || 0,
//         Spesies: parseInt(species_count.innerText) || 0,
//         Koleksi: parseInt(skoleksi_count.innerText) || 0,
//         Titipan: parseInt(stitipan_count.innerText) || 0,
//         BelumTag: parseInt(sbelumtag_count.innerText) || 0,
//         Hidup: parseInt(shidup_count.innerText) || 0
//     };

//     // Ambil nilai data-satwa
//     const satwaValue = document.getElementById("data-satwas").getAttribute("data-satwa");
//     const satwaObject = JSON.parse(satwaValue);
//     // let filterLk = satwaValue.filter(satwa=>satwa.id_lk === "1")
//     let object = satwaObject.filter(satwa=>satwa.id_lk === 71);

//     console.log(object);

//     // Inisialisasi array untuk menyimpan ID yang dipilih
//     let Lk = [];  // Lembaga Konservasi
//     let Upt = []; // UPT
//     let Satwa = []; // Satwa

//     // Fungsi untuk menyaring item berdasarkan pencarian
//     function filterItems(event, itemsContainerSelector) {
//         const filterText = event.target.value.toLowerCase();
//         const items = document.querySelectorAll(itemsContainerSelector);

//         items.forEach(item => {
//             const itemText = item.textContent.toLowerCase();
//             if (itemText.includes(filterText)) {
//                 item.style.display = '';
//                 item.classList.add('filter-matched'); // Tandai item yang sesuai
//             } else {
//                 item.style.display = 'none';
//                 item.classList.remove('filter-matched'); // Hapus penandaan jika tidak sesuai
//             }
//         });
//     }

//     // Fungsi untuk filter berdasarkan checkbox
//     function filterCheckbox() {
//         const allItems = document.querySelectorAll('.filter-item .filter-label');
//         allItems.forEach(item => {
//             const checkbox = item.querySelector('input[type="checkbox"]');
//             const category = checkbox.dataset.category;
//             const value = checkbox.value;

//             // Tentukan apakah item ini dicentang atau tidak
//             if (category === 'Satwa' && Satwa.includes(value)) {
//                 item.classList.add('filter-selected');
//             } else if (category === 'UPT' && Upt.includes(value)) {
//                 item.classList.add('filter-selected');
//             } else if (category === 'LK' && Lk.includes(value)) {
//                 item.classList.add('filter-selected');
//             } else {
//                 item.classList.remove('filter-selected');
//             }
//         });

//         // Update count setelah filter diterapkan
//         updateCounts();
//     }

//     // Fungsi untuk memperbarui nilai count pada elemen
//     function updateCounts() {
//         lk_count.innerText = Lk.length || initialData.Lk;
//         species_count.innerText = Satwa.length || initialData.Spesies;
//         skoleksi_count.innerText = Upt.length || initialData.Koleksi;
//         stitipan_count.innerText = Upt.length || initialData.Titipan; // Sesuaikan sesuai kategori
//         sbelumtag_count.innerText = Satwa.length || initialData.BelumTag;
//         shidup_count.innerText = Satwa.length || initialData.Hidup;
//     }

//     // Menyaring item berdasarkan checkbox
//     document.querySelectorAll('.filter-label input[type="checkbox"]').forEach(checkbox => {
//         checkbox.addEventListener('change', function() {
//             let category = this.dataset.category;
//             let value = this.value;

//             // Debugging: Log nilai checkbox
//             console.log(`Checkbox berubah! Kategori: ${category}, Nilai: ${value}, Dicentang: ${this.checked}`);

//             // Tambahkan logika untuk memfilter berdasarkan satwaValue
//             if (category === 'Satwa' && value === satwaValue) {
//                 if (this.checked) {
//                     Satwa.push(value); // Tambahkan ke Satwa jika dicentang
//                 } else {
//                     Satwa = Satwa.filter(id => id !== value); // Hapus dari Satwa jika tidak dicentang
//                 }
//             }

//             // Menambahkan atau menghapus nilai dari array sesuai dengan kategori
//             if (this.checked) {
//                 if (category === 'Satwa') {
//                     Satwa.push(value);
//                 } else if (category === 'UPT') {
//                     Upt.push(value);
//                 } else if (category === 'LK') {
//                     Lk.push(value);
//                 }
//             } else {
//                 if (category === 'Satwa') {
//                     Satwa = Satwa.filter(id => id !== value);
//                 } else if (category === 'UPT') {
//                     Upt = Upt.filter(id => id !== value);
//                 } else if (category === 'LK') {
//                     Lk = Lk.filter(id => id !== value);
//                 }
//             }

//             // Debugging: Log array setelah perubahan
//             console.log(`Array Lk: ${Lk}`);
//             console.log(`Array Upt: ${Upt}`);
//             console.log(`Array Satwa: ${Satwa}`);

//             // Menyaring item berdasarkan checkbox yang dipilih
//             filterCheckbox();
//         });
//     });

//     // Menambahkan event listener untuk input pencarian
//     const searchInputs = document.querySelectorAll('.conservation-search, .upt-search, .class-search');
//     searchInputs.forEach((input, index) => {
//         input.addEventListener('input', function(event) {
//             filterItems(event, `.nav-item:nth-child(${index + 1}) .filter-label`);
//         });
//     });

//     // Menambahkan event listener untuk tombol Clear
//     document.querySelectorAll('.clear-conservation, .clear-upt, .clear-class').forEach(button => {
//         button.addEventListener('click', function() {
//             // Reset semua checkbox (setel ke unchecked)
//             const container = this.closest('.details');
//             const checkboxes = container.querySelectorAll('input[type="checkbox"]');
//             checkboxes.forEach(checkbox => checkbox.checked = false);

//             // Reset semua filter arrays (Lk, Upt, Satwa)
//             Lk = [];
//             Upt = [];
//             Satwa = [];

//             // Hapus semua kelas filter yang diterapkan
//             document.querySelectorAll('.filter-label').forEach(item => {
//                 item.classList.remove('filter-selected');
//                 item.classList.remove('filter-matched');
//             });

//             // Reset pencarian, tampilkan semua item
//             searchInputs.forEach(input => input.value = '');

//             // Tampilkan semua item (reset display)
//             document.querySelectorAll('.filter-item .filter-label').forEach(item => {
//                 item.style.display = '';
//             });

//             // Update counts setelah reset
//             updateCounts();
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    feather.replace();

    // Ambil elemen count yang ada di halaman
    const lk_count = document.getElementById('lk_count');
    const species_count = document.getElementById('species_count');
    const skoleksi_count = document.getElementById('skoleksi_count');
    const stitipan_count = document.getElementById('stitipan_count');
    const sbelumtag_count = document.getElementById('sbelumtag_count');
    const shidup_count = document.getElementById('shidup_count');

    // Ambil nilai awal dari elemen-elemen count
    const initialData = {
        Lk: parseInt(lk_count.innerText) || 0,
        Spesies: parseInt(species_count.innerText) || 0,
        Koleksi: parseInt(skoleksi_count.innerText) || 0,
        Titipan: parseInt(stitipan_count.innerText) || 0,
        BelumTag: parseInt(sbelumtag_count.innerText) || 0,
        Hidup: parseInt(shidup_count.innerText) || 0
    };

    // Inisialisasi array untuk menyimpan ID yang dipilih
    let Lk = [];  // Lembaga Konservasi
    let Upt = []; // UPT
    let Satwa = []; // Satwa

    // Fungsi untuk melakukan AJAX request menggunakan jQuery
    function ajaxFilterClass(lk, callback) {
        $.ajax({
            url: '/filter-class', // URL endpoint untuk filter
            method: 'GET', // Menggunakan metode GET
            data: { id_lk: lk }, // Mengirimkan data melalui query string
            success: function(response) {
                // Panggil callback dengan data yang diterima dari server
                callback(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching filter class data:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText); 
            }
        });
    }

    // Fungsi untuk menyaring item berdasarkan checkbox
    function filterCheckbox() {
        const allItems = document.querySelectorAll('.filter-item .filter-label');
        allItems.forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            const category = checkbox.dataset.category;
            const value = checkbox.value;

            // Tentukan apakah item ini dicentang atau tidak
            if (category === 'Satwa' && Satwa.includes(value)) {
                item.classList.add('filter-selected');
            } else if (category === 'UPT' && Upt.includes(value)) {
                item.classList.add('filter-selected');
            } else if (category === 'LK' && Lk.includes(value)) {
                item.classList.add('filter-selected');
            } else {
                item.classList.remove('filter-selected');
            }
        });

        // Update count setelah filter diterapkan
        updateCounts();
    }

    // Fungsi untuk memperbarui nilai count pada elemen
    function updateCounts() {
        lk_count.innerText = Lk.length || initialData.Lk;
        species_count.innerText = Satwa.length || initialData.Spesies;
        skoleksi_count.innerText = Upt.length || initialData.Koleksi;
        stitipan_count.innerText = Upt.length || initialData.Titipan; // Sesuaikan sesuai kategori
        sbelumtag_count.innerText = Satwa.length || initialData.BelumTag;
        shidup_count.innerText = Satwa.length || initialData.Hidup;
    }

    // Fungsi untuk filter berdasarkan checkbox
    function filterCheckboxByLkId() {
        // Ambil checkbox untuk 'LK'
        const allItems = document.querySelectorAll('.filter-item .filter-label');
        allItems.forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            const category = checkbox.dataset.category;
            const value = checkbox.value;

            // Tentukan apakah item ini dicentang atau tidak
            if (category === 'LK' && Lk.includes(value)) {
                item.classList.add('filter-selected');
            } else {
                item.classList.remove('filter-selected');
            }
        });

        // Update count setelah filter diterapkan
        updateCounts();
    }

    // Menyaring item berdasarkan checkbox
    document.querySelectorAll('.filter-label input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let category = this.dataset.category;
            let value = this.value;

            if (category === 'LK' && this.checked) {
                // Jika checkbox Lk dicentang, lakukan filter menggunakan filter()
                const satwaValue = document.getElementById("data-satwas").getAttribute("data-satwa");
                const satwaObject = JSON.parse(satwaValue);
                let filteredSatwa = satwaObject.filter(satwa => satwa.id_lk === parseInt(value));

                // Simpan ID yang telah difilter
                Lk = filteredSatwa.map(satwa => satwa.id_lk);
                Satwa = filteredSatwa; // Menyimpan objek satwa yang difilter

                // Kirimkan ID yang telah difilter via AJAX
                ajaxFilterClass(value, function(data) {
                    console.log('Data dari server:', data);
                    // Proses data dan tampilkan sesuai filter yang diterapkan
                    Upt = data.upt || [];  // Misal data.upt adalah array upt yang difilter

                    // Update tampilan dan count setelah data difilter
                    filterCheckboxByLkId();
                    updateCounts();
                });
            } else if (category === 'LK' && !this.checked) {
                // Jika checkbox Lk tidak dicentang, reset filter
                Lk = [];
                Satwa = [];
                Upt = [];

                // Update tampilan dan count
                filterCheckboxByLkId();
                updateCounts();
            }
        });
    });

    // Menambahkan event listener untuk input pencarian
    const searchInputs = document.querySelectorAll('.conservation-search, .upt-search, .class-search');
    searchInputs.forEach((input, index) => {
        input.addEventListener('input', function(event) {
            filterItems(event, `.nav-item:nth-child(${index + 1}) .filter-label`);
        });
    });

    // Menambahkan event listener untuk tombol Clear
    document.querySelectorAll('.clear-conservation, .clear-upt, .clear-class').forEach(button => {
        button.addEventListener('click', function() {
            // Reset semua checkbox (setel ke unchecked)
            const container = this.closest('.details');
            const checkboxes = container.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);

            // Reset semua filter arrays (Lk, Upt, Satwa)
            Lk = [];
            Upt = [];
            Satwa = [];

            // Hapus semua kelas filter yang diterapkan
            document.querySelectorAll('.filter-label').forEach(item => {
                item.classList.remove('filter-selected');
                item.classList.remove('filter-matched');
            });

            // Reset pencarian, tampilkan semua item
            searchInputs.forEach(input => input.value = '');

            // Tampilkan semua item (reset display)
            document.querySelectorAll('.filter-item .filter-label').forEach(item => {
                item.style.display = '';
            });

            // Update counts setelah reset
            updateCounts();
        });
    });
});
