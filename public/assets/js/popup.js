// Tunggu hingga seluruh konten halaman dimuat
// document.addEventListener("DOMContentLoaded", function () {
//     // Ambil semua tombol yang memiliki id dinamis
//     const buttons = document.querySelectorAll("button");

//     // Tambahkan event listener untuk setiap tombol
//     buttons.forEach((button) => {
//         button.addEventListener("click", function () {
//             const id = this.id; // Ambil ID tombol yang diklik
//             console.log(id);
//             // Lakukan fetch data berdasarkan ID
//             fetch(`/lembaga-konservasi/${id}`)
//                 .then((response) => {
//                     if (!response.ok) {
//                         throw new Error("Network response was not ok");
//                     }
//                     return response.json(); // Misalnya response berupa JSON
//                 })
//                 .then((data) => {
//                     console.log(data); // Tampilkan data di console (atau tampilkan di UI)
//                     alert("Data: " + JSON.stringify(data));
//                 })
//                 .catch((error) => {
//                     console.error("Error:", error);
//                     alert("Terjadi kesalahan saat memuat data.");
//                 });
//         });
//     });
// });
// }

//nanti uncomment aja
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

// document.querySelectorAll("button[id]").forEach((button) => {
//     button.addEventListener("click", function () {
//         const detail = {
//             Nama: this.getAttribute("data-nama"),
//             UPT: this.getAttribute("data-upt"),
//             "Bentuk Lembaga": this.getAttribute("data-bentuk"),
//             Akreditasi: this.getAttribute("data-akreditasi"),
//             "Tahun Izin": this.getAttribute("data-tahun"),
//             Alamat: this.getAttribute("data-tahun"),
//         };
//         openPopup(detail);
//     });
// });
let deleteId = null; // Variable to store the ID of the item to be deleted

function openPopup(details) {
    let content = "";
    for (const [key, value] of Object.entries(details)) {
        content += `<div class="detail-item"><strong>${key}:</strong> <span>${value}</span></div>`;
    }

    document.getElementById("popupContent").innerHTML = content;
    document.getElementById("detailPopup").style.display = "block";
}

function closePopup() {
    document.getElementById("detailPopup").style.display = "none";
}

function confirmDelete(button) {
    deleteId = button.getAttribute("data-id"); // Store the ID
    document.getElementById("deletePopup").style.display = "block"; // Show the delete confirmation popup
}

function closeDeletePopup() {
    document.getElementById("deletePopup").style.display = "none"; // Hide the delete confirmation popup
}

// Event listener for detail buttons
document.querySelectorAll(".detail-button").forEach((button) => {
    button.addEventListener("click", function () {
        const detail = {
            Nama: this.getAttribute("data-nama"),
            UPT: this.getAttribute("data-upt"),
            "Bentuk Lembaga": this.getAttribute("data-bentuk"),
            Status: this.getAttribute("data-status"),
            Akreditasi: this.getAttribute("data-akreditasi"),
            "Tahun Izin": this.getAttribute("data-tahun"),
            Alamat: this.getAttribute("data-alamat"),
        };
        openPopup(detail);
    });
});

// Handle delete confirmation button click
document
    .getElementById("confirmDeleteButton")
    .addEventListener("click", function () {
        if (deleteId) {
            fetch(`/lembaga-konservasi/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Include CSRF token for security
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    alert("Data berhasil dihapus!"); // Optional: You can replace this with a success message in a popup
                    location.reload(); // Reload page to see changes
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menghapus data."); // Optional: You can replace this with an error message in a popup
                });

            closeDeletePopup(); // Close the delete confirmation popup after initiating deletion
        }
    });
