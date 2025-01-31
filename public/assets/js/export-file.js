document
    .getElementById("previewBtn")
    .addEventListener("click", async function () {
        try {
            const response = await fetch("/get-preview-data"); // Endpoint untuk mengambil preview data
            if (!response.ok) throw new Error("Gagal memuat preview data");

            const data = await response.json();
            document.getElementById("preview").value = JSON.stringify(
                data,
                null,
                2
            );
        } catch (error) {
            alert(error.message);
        }
    });

document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("start_date");
    const endDateInput = document.getElementById("end_date");

    startDateInput.addEventListener("change", function () {
        const startDate = startDateInput.value;
        if (startDate) {
            // Set tanggal minimum untuk tanggal akhir
            endDateInput.setAttribute("min", startDate);
        } else {
            // Jika tanggal awal tidak dipilih, hapus atribut min
            endDateInput.removeAttribute("min");
        }
    });
});