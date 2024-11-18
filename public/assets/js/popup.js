// Tunggu hingga seluruh konten halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua tombol yang memiliki id dinamis
    const buttons = document.querySelectorAll("button");

    // Tambahkan event listener untuk setiap tombol
    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.id; // Ambil ID tombol yang diklik
            console.log(id);
            // Lakukan fetch data berdasarkan ID
            fetch(`/lembaga-konservasi/${id}`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json(); // Misalnya response berupa JSON
                })
                .then((data) => {
                    console.log(data); // Tampilkan data di console (atau tampilkan di UI)
                    alert("Data: " + JSON.stringify(data));
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat memuat data.");
                });
        });
    });
});

//POPUP
function openPopup(detail) {
    document.getElementById("popupContent").innerHTML = detail;
    document.getElementById("detailPopup").style.display = "block";
}

function closePopup() {
    document.getElementById("detailPopup").style.display = "none";
}

document.querySelectorAll("button[id]").forEach((button) => {
    button.addEventListener("click", function () {
        const detail = `Detail untuk ID ${this.id}`;
        openPopup(detail);
    });
});
