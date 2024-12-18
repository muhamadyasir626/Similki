//FILTER BY LEMBAGA KONSERVASI
document.addEventListener('DOMContentLoaded', function () {
    feather.replace();

    // Ambil elemen count yang ada di halaman
    const lk_count = document.getElementById('lk_count');
    const species_count = document.getElementById('species_count');
    const skoleksi_count = document.getElementById('skoleksi_count');
    const stitipan_count = document.getElementById('stitipan_count');
    const sbelumtag_count = document.getElementById('sbelumtag_count');
    const shidup_count = document.getElementById('shidup_count');
    const endemik_count = document.getElementById('endemik_count');
    const eksotik_count = document.getElementById('eksotik_count');

    const lkSatwa = lk_count.innerText
    const speciesSatwa = species_count.innerText
    const koleksiSatwa = skoleksi_count.innerText
    const titipanSatwa = stitipan_count.innerText
    const belumTaggingSatwa = sbelumtag_count.innerText
    const hidupSatwa = shidup_count.innerText
    const endemikSatwa = endemik_count.innerText
    const eksotikSatwa = eksotik_count.innerText

    // Ambil nilai data-satwa
    const satwaValue = document.getElementById("data-satwas").getAttribute("data-satwa");
    const tagValue = document.getElementById("data-satwas").getAttribute("data-tag");
    const satwaObject = JSON.parse(satwaValue);
    const tagObject = JSON.parse(tagValue);
    // console.log("test",tagObject);

    // Inisialisasi array untuk menyimpan ID yang dipilih
    let Lk = [];  // Lembaga Konservasi
    let Upt = []; // UPT
    let Satwa = []; // Satwa

    // Fungsi untuk menyaring item berdasarkan pencarian
    function filterItems(event, itemsContainerSelector) {
        const filterText = event.target.value.toLowerCase();
        const items = document.querySelectorAll(itemsContainerSelector);

        items.forEach(item => {
            const itemText = item.textContent.toLowerCase();
            if (itemText.includes(filterText)) {
                item.style.display = '';
                item.classList.add('filter-matched'); // Tandai item yang sesuai
            } else {
                item.style.display = 'none';
                item.classList.remove('filter-matched'); // Hapus penandaan jika tidak sesuai
            }
        });
    }

    // Fungsi untuk filter berdasarkan checkbox
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

    // function updateCounts() {
    //     console.log('Updating counts...');
        
    //     // Periksa apakah semua array filter kosong
    //     let filteredSatwa;
    //     let filteredTag;
    
    //     if (Lk.length === 0 && Upt.length === 0 && Satwa.length === 0) {
    //         // Jika semua array filter kosong, gunakan data awal
    //         filteredSatwa = satwaObject;
    //         filteredTag = tagObject;
    //     } else {
    //         // Filter Satwa yang sesuai dengan kondisi filter
    //         filteredSatwa = satwaObject.filter(satwa => {
    //             return (
    //                 (Lk.length === 0 || Lk.includes(satwa.id_lk.toString())) &&
    //                 (Upt.length === 0 || Upt.includes(satwa.id_upt.toString())) &&
    //                 (Satwa.length === 0 || Satwa.includes(satwa.id.toString()))
    //             );
    //         });
    
    //         filteredTag = tagObject.filter(tag => {
    //             return filteredSatwa.some(satwa => tag.id_satwa === satwa.id);
    //         });
    //     }
    
    //     // Update jumlah lembaga konservasi
    //     let lembagaKonservasi = [...new Set(filteredSatwa.map(satwa => satwa.id_lk))];
    //     lk_count.innerText = lembagaKonservasi.length || 0;
    
    //     // Update jumlah spesies satwa
    //     let speciesSatwa = [...new Set(filteredSatwa.map(satwa => satwa.id_spesies))];
    //     species_count.innerText = speciesSatwa.length || 0;
    
    //     // Update jumlah kategori lainnya
    //     let koleksiSatwa = filteredSatwa.filter(satwa => satwa.status_satwa === 'satwa koleksi'); 
    //     let titipanSatwa = filteredSatwa.filter(satwa => satwa.status_satwa === 'satwa titipan');
    //     let belumTaggingSatwa = filteredTag.filter(tag => tag.jenis_tagging === 'belum ditagging');
    //     let hidupSatwa = filteredSatwa.filter(satwa => satwa.jenis_koleksi === 'satwa hidup');
    //     let endemikSatwa = filteredSatwa.filter(satwa => satwa.asal_satwa === 'endemik');
    //     let eksotikSatwa = filteredSatwa.filter(satwa => satwa.asal_satwa === 'eksotik');
    
    //     // Update elemen DOM
    //     skoleksi_count.innerText = koleksiSatwa.length || 0;
    //     stitipan_count.innerText = titipanSatwa.length || 0;
    //     sbelumtag_count.innerText = belumTaggingSatwa.length || 0;
    //     shidup_count.innerText = hidupSatwa.length || 0;
    //     endemik_count.innerText = endemikSatwa.length || 0;
    //     eksotik_count.innerText = eksotikSatwa.length || 0;
    
    //     // Debugging: Log hasil filter untuk memastikan data yang benar
    //     console.log(`LK: `, lembagaKonservasi);
    //     console.log(`Jenis Satwa: `, speciesSatwa);
    //     console.log(`Koleksi Satwa: `, koleksiSatwa);
    //     console.log(`Titipan Satwa: `, titipanSatwa);
    //     console.log(`Satwa Belum Tag`, belumTaggingSatwa);
    //     console.log(`Hidup Satwa: `, hidupSatwa);
    //     console.log(`Endemik Satwa: `, endemikSatwa);
    //     console.log(`Eksotik Satwa: `, eksotikSatwa);
    // }

//     function updateCounts() {
//     console.log('Updating counts...');
    
//     // Periksa apakah semua array filter kosong
//     let filteredSatwa, filteredTag;

//     if (Lk.length === 0 && Upt.length === 0 && Satwa.length === 0) {
//         // Jika semua array filter kosong, gunakan data awal
//         // filteredSatwa = [...satwaObject];
//         // filteredTag = [...tagObject];
//         lk_count.innerText = lkSatwa
//         species_count.innerText = speciesSatwa
//         skoleksi_count.innerText = koleksiSatwa
//         stitipan_count.innerText = titipanSatwa
//         sbelumtag_count.innerText = belumTaggingSatwa
//         shidup_count.innerText = hidupSatwa
//         endemik_count.innerText = endemikSatwa
//         eksotik_count.innerText = eksotikSatwa
//     } else {
//         // Filter Satwa yang sesuai dengan kondisi filter
//         filteredSatwa = satwaObject.filter(satwa => {
//             const lkMatch = Lk.length === 0 || Lk.includes(satwa.id_lk.toString());
//             const uptMatch = Upt.length === 0 || Upt.includes(satwa.id_upt.toString());
//             const satwaMatch = Satwa.length === 0 || Satwa.includes(satwa.id.toString());
//             return lkMatch && uptMatch && satwaMatch;
//         });

//         // Filter Tag yang terkait dengan Satwa yang tersaring
//         filteredTag = tagObject.filter(tag => {
//             return filteredSatwa.some(satwa => tag.id_satwa === satwa.id);
//         });

//          // Update jumlah lembaga konservasi
//         const lembagaKonservasi = [...new Set(filteredSatwa.map(satwa => satwa.id_lk))];
//         lk_count.innerText = lembagaKonservasi.length || 0;

//         // Update jumlah spesies satwa
//         const speciesSatwa = [...new Set(filteredSatwa.map(satwa => satwa.id_spesies))];
//         species_count.innerText = speciesSatwa.length || 0;

//         // Update jumlah kategori lainnya
//         const koleksiSatwa = filteredSatwa.filter(satwa => satwa.status_satwa === 'satwa koleksi');
//         const titipanSatwa = filteredSatwa.filter(satwa => satwa.status_satwa === 'satwa titipan');
//         const belumTaggingSatwa = filteredTag.filter(tag => tag.jenis_tagging === 'belum ditagging');
//         const hidupSatwa = filteredSatwa.filter(satwa => satwa.jenis_koleksi === 'satwa hidup');
//         const endemikSatwa = filteredSatwa.filter(satwa => satwa.asal_satwa === 'endemik');
//         const eksotikSatwa = filteredSatwa.filter(satwa => satwa.asal_satwa === 'eksotik');

//         // Update elemen DOM
//         skoleksi_count.innerText = koleksiSatwa.length || 0;
//         stitipan_count.innerText = titipanSatwa.length || 0;
//         sbelumtag_count.innerText = belumTaggingSatwa.length || 0;
//         shidup_count.innerText = hidupSatwa.length || 0;
//         endemik_count.innerText = endemikSatwa.length || 0;
//         eksotik_count.innerText = eksotikSatwa.length || 0;

//         // Debugging: Log hasil filter untuk memastikan data yang benar
//         console.group('Filter Results');
//         console.log('Filtered Lembaga Konservasi:', lembagaKonservasi);
//         console.log('Filtered Spesies Satwa:', speciesSatwa);
//         console.log('Filtered Koleksi Satwa:', koleksiSatwa);
//         console.log('Filtered Titipan Satwa:', titipanSatwa);
//         console.log('Filtered Belum Tagging Satwa:', belumTaggingSatwa);
//         console.log('Filtered Hidup Satwa:', hidupSatwa);
//         console.log('Filtered Endemik Satwa:', endemikSatwa);
//         console.log('Filtered Eksotik Satwa:', eksotikSatwa);
//         console.groupEnd();
//     }

   
// }

function updateCounts() {
    console.log('Updating counts...');
    
    let filteredSatwa, filteredTag;

    if (Lk.length === 0 && Upt.length === 0 && Satwa.length === 0) {
        // Jika semua array filter kosong, gunakan data awal
        lk_count.innerText = lkSatwa;
        species_count.innerText = speciesSatwa;
        skoleksi_count.innerText = koleksiSatwa;
        stitipan_count.innerText = titipanSatwa;
        sbelumtag_count.innerText = belumTaggingSatwa;
        shidup_count.innerText = hidupSatwa;
        endemik_count.innerText = endemikSatwa;
        eksotik_count.innerText = eksotikSatwa;

        // Update chart dengan data awal
        updateCharts(satwaObject, tagObject); // Menyegarkan chart dengan data asli
    } else {
        filteredSatwa = satwaObject.filter(satwa => {
            const lkMatch = Lk.length === 0 || Lk.includes(satwa.id_lk.toString());
            const uptMatch = Upt.length === 0 || Upt.includes(satwa.id_upt.toString());
            const satwaMatch = Satwa.length === 0 || Satwa.includes(satwa.id.toString());
            return lkMatch && uptMatch && satwaMatch;
        });

        filteredTag = tagObject.filter(tag => {
            return filteredSatwa.some(satwa => tag.id_satwa === satwa.id);
        });

        // Update jumlah berdasarkan data yang sudah difilter
        const lembagaKonservasi = [...new Set(filteredSatwa.map(satwa => satwa.id_lk))];
        lk_count.innerText = lembagaKonservasi.length || 0;
        const speciesSatwa = [...new Set(filteredSatwa.map(satwa => satwa.id_spesies))];
        species_count.innerText = speciesSatwa.length || 0;

        // Update jumlah kategori lainnya
        const koleksiSatwa = filteredSatwa.filter(satwa => satwa.status_satwa === 'satwa koleksi');
        const titipanSatwa = filteredSatwa.filter(satwa => satwa.status_satwa === 'satwa titipan');
        const belumTaggingSatwa = filteredTag.filter(tag => tag.jenis_tagging === 'belum ditagging');
        const hidupSatwa = filteredSatwa.filter(satwa => satwa.jenis_koleksi === 'satwa hidup');
        const endemikSatwa = filteredSatwa.filter(satwa => satwa.asal_satwa === 'endemik');
        const eksotikSatwa = filteredSatwa.filter(satwa => satwa.asal_satwa === 'eksotik');

        // Update jumlah elemen yang sudah difilter
        skoleksi_count.innerText = koleksiSatwa.length || 0;
        stitipan_count.innerText = titipanSatwa.length || 0;
        sbelumtag_count.innerText = belumTaggingSatwa.length || 0;
        shidup_count.innerText = hidupSatwa.length || 0;
        endemik_count.innerText = endemikSatwa.length || 0;
        eksotik_count.innerText = eksotikSatwa.length || 0;

        // Update chart dengan data yang sudah difilter
        updateCharts(filteredSatwa, filteredTag); // Menyegarkan chart dengan data yang difilter
    }

    console.group('Filter Results');
    console.log('Filtered Lembaga Konservasi:', lembagaKonservasi);
    console.log('Filtered Spesies Satwa:', speciesSatwa);
    console.log('Filtered Koleksi Satwa:', koleksiSatwa);
    console.log('Filtered Titipan Satwa:', titipanSatwa);
    console.log('Filtered Belum Tagging Satwa:', belumTaggingSatwa);
    console.log('Filtered Hidup Satwa:', hidupSatwa);
    console.log('Filtered Endemik Satwa:', endemikSatwa);
    console.log('Filtered Eksotik Satwa:', eksotikSatwa);
    console.groupEnd();
}



    // Menyaring item berdasarkan checkbox
    document.querySelectorAll('.filter-label input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let category = this.dataset.category;
            let value = this.value;

            // Debugging: Log nilai checkbox
            console.log(`Checkbox berubah! Kategori: ${category}, Nilai: ${value}, Dicentang: ${this.checked}`);

            // Menambahkan atau menghapus nilai dari array sesuai dengan kategori
            if (category === 'Satwa') {
                if (this.checked) {
                    Satwa.push(value); // Tambahkan ke Satwa jika dicentang
                } else {
                    Satwa = Satwa.filter(id => id !== value); // Hapus dari Satwa jika tidak dicentang
                }
            } else if (category === 'UPT') {
                if (this.checked) {
                    Upt.push(value); // Tambahkan ke Upt jika dicentang
                } else {
                    Upt = Upt.filter(id => id !== value); // Hapus dari Upt jika tidak dicentang
                }
            } else if (category === 'LK') {
                if (this.checked) {
                    Lk.push(value); // Tambahkan ke Lk jika dicentang
                } else {
                    Lk = Lk.filter(id => id !== value); // Hapus dari Lk jika tidak dicentang
                }
            }

            // Debugging: Log array setelah perubahan
            console.log(`Array Lk: ${Lk}`);
            console.log(`Array Upt: ${Upt}`);
            console.log(`Array Satwa: ${Satwa}`);

            // Menyaring item berdasarkan checkbox yang dipilih
            filterCheckbox();
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

