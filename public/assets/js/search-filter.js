const lk_count = document.getElementById('lk_count');
var jumlah_lk = JSON.parse(lk_count.getAttribute('data-lk-count'));
lk_count.innerText = jumlah_lk ? jumlah_lk.length : 0;

const species_count = document.getElementById('species_count');
var jumlah_spesies = JSON.parse(species_count.getAttribute('data-spesies-count'));
species_count.innerText = jumlah_spesies ? jumlah_spesies.length : 0;

const skoleksi_count = document.getElementById('skoleksi_count');
var jumlah_koleksi = JSON.parse(skoleksi_count.getAttribute('data-skoleksi-count'));
skoleksi_count.innerText = jumlah_koleksi ? jumlah_koleksi.length : 0;

const stitipan_count = document.getElementById('stitipan_count');
var jumlah_titipan = JSON.parse(stitipan_count.getAttribute('data-skoleksi-count'));
stitipan_count.innerText = jumlah_titipan ? jumlah_titipan.length : 0;

const sbelumtag_count = document.getElementById('sbelumtag_count');
var jumlah_belumtag = JSON.parse(sbelumtag_count.getAttribute('data-skoleksi-count'));
sbelumtag_count.innerText = jumlah_belumtag ? jumlah_belumtag.length : 0;

const shidup_count = document.getElementById('shidup_count');
var jumlah_hidup = JSON.parse(shidup_count.getAttribute('data-skoleksi-count'));
shidup_count.innerText = jumlah_hidup ? jumlah_hidup.length : 0;

const initialData = {
    // data statis
    Lk: jumlah_lk.length,
    // Spesies: jumlah_spesies.length,
    // Koleksi: jumlah_koleksi.length,
    // Titipan: jumlah_titipan.length,
    // BelumTag: jumlah_belumtag.length,
    // Hidup: jumlah_hidup.length,
};
console.log(initialData.Lk);

document.addEventListener('DOMContentLoaded', function () {
    feather.replace();

    // Inisialisasi array untuk menyimpan ID yang dipilih
    let Lk = []; // Lembaga Konservasi
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

    // Fungsi untuk memperbarui nilai count pada elemen
    function updateCounts() {
        const lk_count = document.getElementById('lk_count');
        const species_count = document.getElementById('species_count');
        const skoleksi_count = document.getElementById('skoleksi_count');
        const stitipan_count = document.getElementById('stitipan_count');
        const sbelumtag_count = document.getElementById('sbelumtag_count');
        const shidup_count = document.getElementById('shidup_count');

        lk_count.innerText = Lk.length || initialData.Lk;
        species_count.innerText = Satwa.length || 0;
        skoleksi_count.innerText = Upt.length || 0;
        stitipan_count.innerText = Upt.length || 0; // Sesuaikan sesuai kategori
        sbelumtag_count.innerText = Satwa.length || 0;
        shidup_count.innerText = Satwa.length || 0;
    }

    // Menyimpan urutan awal setiap elemen dalam container dengan class .details
    function storeInitialOrder(container) {
        const items = container.querySelectorAll('.filter-label');
        items.forEach((item, index) => {
            item.setAttribute('data-initial-index', index); // Menyimpan urutan awal elemen
        });
    }

    function sortItems(container) {
        let itemsArray = Array.from(container.querySelectorAll('.filter-label'));
        // Tentukan apakah ada checkbox yang dicentang
        const anyChecked = itemsArray.some(item => item.querySelector('input[type="checkbox"]').checked);

        // Jika ada checkbox yang dicentang, urutkan berdasarkan status checked terlebih dahulu
        if (anyChecked) {
            itemsArray.sort((a, b) => {
                const aChecked = a.querySelector('input[type="checkbox"]').checked;
                const bChecked = b.querySelector('input[type="checkbox"]').checked;

                // Urutkan berdasarkan apakah dicentang atau tidak (checked = true, un-checked = false)
                return (bChecked - aChecked) || (parseInt(a.dataset.initialIndex) - parseInt(b.dataset.initialIndex));
            });
        } else {
            // Jika tidak ada yang dicentang, urutkan berdasarkan urutan awal
            itemsArray.sort((a, b) => parseInt(a.dataset.initialIndex) - parseInt(b.dataset.initialIndex));
        }

        // Setelah diurutkan, tambahkan elemen kembali ke dalam container sesuai urutan baru
        itemsArray.forEach(item => container.appendChild(item));
    }

    // Menyimpan urutan awal setiap elemen dalam container dengan class .details
    document.querySelectorAll('.details').forEach(details => storeInitialOrder(details));

    const searchInputs = document.querySelectorAll('.conservation-search, .upt-search, .class-search');
    searchInputs.forEach((input, index) => {
        input.addEventListener('input', function(event) {
            filterItems(event, `.nav-item:nth-child(${index + 1}) .filter-label`);
        });
    });

    // Menambahkan event listener untuk perubahan checkbox
    document.querySelectorAll('.filter-label input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let category = this.dataset.category;
            let value = this.value;
            sortItems(this.closest('.details'));

            // Menambahkan atau menghapus nilai dari array sesuai dengan kategori
            if (this.checked) {
                if (category === 'Satwa') {
                    Satwa.push(value);
                } else if (category === 'UPT') {
                    Upt.push(value);
                } else if (category === 'LK') {
                    Lk.push(value);
                }
            } else {
                if (category === 'Satwa') {
                    Satwa = Satwa.filter(id => id !== value);
                } else if (category === 'UPT') {
                    Upt = Upt.filter(id => id !== value);
                } else if (category === 'LK') {
                    Lk = Lk.filter(id => id !== value);
                }
            }

            // Menyaring item berdasarkan checkbox yang dipilih
            filterCheckbox();
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

           
            const initialLkCount = JSON.parse(lk_count.getAttribute('data-lk-count')).length;
            // const initialSpeciesCount = JSON.parse(species_count.getAttribute('data-spesies-count')).length;
            // const initialSkoleksiCount = JSON.parse(skoleksi_count.getAttribute('data-skoleksi-count')).length;
            // const initialStitipanCount = JSON.parse(stitipan_count.getAttribute('data-skoleksi-count')).length;
            // const initialBelumTagCount = JSON.parse(sbelumtag_count.getAttribute('data-skoleksi-count')).length;
            // const initialHidupCount = JSON.parse(shidup_count.getAttribute('data-skoleksi-count')).length;

            lk_count.innerText = initialLkCount || 0;
            // species_count.innerText = initialSpeciesCount || 0;
            // skoleksi_count.innerText = initialSkoleksiCount || 0;
            // stitipan_count.innerText = initialStitipanCount || 0;
            // sbelumtag_count.innerText = initialBelumTagCount || 0;
            // shidup_count.innerText = initialHidupCount || 0;

            // Tampilkan semua item (reset display)
            document.querySelectorAll('.filter-item .filter-label').forEach(item => {
                item.style.display = '';
            });
        });
    });

});


















