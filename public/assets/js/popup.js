// let deleteId = null;

// function openPopup(details) {
//     let content = "";
//     for (const [key, value] of Object.entries(details)) {
//         content += `<div class="detail-item"><strong>${key}:</strong> <span>${value}</span></div>`;
//     }

//     document.getElementById("popupContent").innerHTML = content;
//     document.getElementById("detailPopup").style.display = "block";
// }

// function closePopup() {
//     document.getElementById("detailPopup").style.display = "none";
// }

// function confirmDelete(button) {
//     deleteId = button.getAttribute("data-id");
//     document.getElementById("deletePopup").style.display = "block";
// }

// function closeDeletePopup() {
//     document.getElementById("deletePopup").style.display = "none";
// }

// // detail
// document.querySelectorAll(".detail-button").forEach((button) => {
//     button.addEventListener("click", function () {
//         const detail = {
//             Nama: this.getAttribute("data-nama") || "-",
//             UPT: this.getAttribute("data-upt") || "-",
//             "Bentuk Lembaga": this.getAttribute("data-bentuk") || "-",
//             Status: this.getAttribute("data-status") || "-",
//             Akreditasi: this.getAttribute("data-akreditasi") || "-",
//             "Tahun Izin": this.getAttribute("data-tahun") || "-",
//             Alamat: this.getAttribute("data-alamat") || "-",
//         };
//         openPopup(detail);
//     });
// });

// // delete
// document
//     .getElementById("confirmDeleteButton")
//     .addEventListener("click", function () {
//         if (deleteId) {
//             fetch(`/lembaga-konservasi/${deleteId}`, {
//                 method: "DELETE",
//                 headers: {
//                     "Content-Type": "application/json",
//                     "X-CSRF-TOKEN": "{{ csrf_token() }}",
//                 },
//             })
//                 .then((response) => {
//                     if (!response.ok) {
//                         throw new Error("Network response was not ok");
//                     }
//                     return response.json();
//                 })
//                 .then((data) => {
//                     alert("Data berhasil dihapus!");
//                     location.reload();
//                 })
//                 .catch((error) => {
//                     console.error("Error:", error);
//                     alert("Terjadi kesalahan saat menghapus data.");
//                 });

//             closeDeletePopup();
//         }
//     });

let deleteId = null;
let currentId = null; // Untuk menyimpan ID lembaga saat ini

/**
 * Membuka pop-up detail dengan konten yang relevan.
 */
function openPopup(details) {
    let content = "";

    // Tambahkan item-detail ke konten pop-up
    for (const [key, value] of Object.entries(details)) {
        content += `<div class="detail-item"><strong>${key}:</strong> <span>${value}</span></div>`;
    }

    // Tampilkan tombol edit jika tersedia
    document.getElementById("editDataButton").style.display = "inline-block";

    // Populasi konten pop-up dengan informasi detail
    document.getElementById("popupContent").innerHTML = content;
    document.getElementById("detailPopup").style.display = "block";

    // Simpan ID lembaga saat ini
    currentId = details.id;
}

/**
 * Menutup pop-up detail.
 */
function closePopup() {
    document.getElementById("detailPopup").style.display = "none";
}

/**
 * Mengkonfirmasikan penghapusan data.
 */
function confirmDelete(button) {
    deleteId = button.getAttribute("data-id");
    document.getElementById("deletePopup").style.display = "block";
}

/**
 * Menutup konfirmasi penghapusan data.
 */
function closeDeletePopup() {
    document.getElementById("deletePopup").style.display = "none";
}

// Event listener untuk tombol detail pada daftar lembaga konservasi
document.querySelectorAll(".detail-button").forEach((button) => {
    button.addEventListener("click", function () {
        const detail = {
            id: this.getAttribute("data-id"), // Ambil ID untuk pengeditan
            Nama: this.getAttribute("data-nama") || "-",
            UPT: this.getAttribute("data-upt") || "-",
            "Bentuk Lembaga": this.getAttribute("data-bentuk") || "-",
            Status: this.getAttribute("data-status") || "-",
            Akreditasi: this.getAttribute("data-akreditasi") || "-",
            "Tahun Izin": this.getAttribute("data-tahun") || "-",
            Alamat: this.getAttribute("data-alamat") || "-",
        };
        openPopup(detail);
    });
});

// Fungsi untuk menampilkan formulir edit-data ketika diklik tombol Edit Data
document
    .getElementById("editDataButton")
    .addEventListener("click", function () {
        const formHtml = `
        <form id="editForm">
            <label>Nama:</label><input type="text" name="nama" required><br>
            <label>UPT:</label><input type="text" name="upt" required><br>
            <label>Bentuk Lembaga:</label><input type="text" name="bentuk_lk" required><br>
            <label>Akreditasi:</label><input type="text" name="akreditasi"><br>
            <label>Tahun Izin:</label><input type="number" name="tahun_izin"><br>
            <button type="submit">Simpan</button>
        </form>
    `;

        document.getElementById("popupContent").innerHTML = formHtml;

        // Populasi form dengan data yang ada
        const formElements = document.forms["editForm"].elements;
        formElements["nama"].value = detail.Nama;
        formElements["upt"].value = detail.UPT;
        formElements["bentuk_lk"].value = detail["Bentuk Lembaga"];
        formElements["akreditasi"].value = detail.Akreditasi;
        formElements["tahun_izin"].value = detail["Tahun Izin"];

        // Handle pengiriman formulir
        document
            .getElementById("editForm")
            .addEventListener("submit", function (event) {
                event.preventDefault();

                const updatedData = {
                    nama: formElements["nama"].value,
                    upt: formElements["upt"].value,
                    bentuk_lk: formElements["bentuk_lk"].value,
                    akreditasi: formElements["akreditasi"].value,
                    tahun_izin: formElements["tahun_izin"].value,
                };

                fetch(`/lembaga-konservasi/${currentId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify(updatedData),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then((data) => {
                        alert(data.message); // Tampilkan pesan sukses
                        location.reload(); // Reload halaman untuk melihat data yang diperbarui
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan saat memperbarui data.");
                    });

                closePopup(); // Tutup pop-up setelah pengiriman
            });
    });

// Event listener untuk tombol konfirmasi penghapusan
document
    .getElementById("confirmDeleteButton")
    .addEventListener("click", function () {
        if (deleteId) {
            fetch(`/lembaga-konservasi/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    alert(data.message); // Tampilkan pesan sukses
                    location.reload(); // Reload halaman setelah penghapusan
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menghapus data.");
                });

            closeDeletePopup(); // Tutup pop-up konfirmasi penghapusan
        }
    });
