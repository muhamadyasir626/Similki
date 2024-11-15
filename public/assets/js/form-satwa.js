document.addEventListener("DOMContentLoaded", function () {
    // Ambil tombol "Next" dari wizard (biasanya tombol dengan kelas tertentu)
    const nextButtons = document.querySelectorAll(".wizard .next");

    // Tambahkan event listener untuk setiap tombol Next
    nextButtons.forEach((button) => {
        button.addEventListener("click", function () {
            // Cek apakah kita sedang berpindah ke step tertentu
            const currentStep = document.querySelector(".current"); // Cek step yang aktif saat ini

            // Misalnya, kita ingin melakukan fetch saat pindah ke step 2
            if (currentStep && currentStep.id === "step-1") {
                // Fetch data saat pengguna berpindah ke step 2
                fetchData(currentStep);
            }
        });
    });

    // Fungsi untuk mengambil data menggunakan fetch
    function fetchData(currentStep) {
        // Misalnya, kita ingin mengambil data berdasarkan ID step atau ID form
        const stepId = currentStep.id;
        console.log("Fetching data for:", stepId);

        // Menggunakan fetch dengan URL dinamis
        fetch(`/satwa/pendataan1/`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Misalnya response berupa JSON
            })
            .then((data) => {
                // Tampilkan data di console atau lakukan sesuatu dengan data
                console.log("Fetched Data:", data);
                alert("Data berhasil dimuat: " + JSON.stringify(data));

                // Kamu juga bisa memperbarui tampilan di DOM berdasarkan data
                // Contoh: Update form atau elemen yang relevan
                updateFormWithFetchedData(data);
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                alert("Terjadi kesalahan saat memuat data.");
            });
    }

    // Fungsi untuk memperbarui form atau elemen berdasarkan data yang diterima
    function updateFormWithFetchedData(data) {
        // Misalnya, update elemen dengan ID tertentu
        const formElement = document.querySelector("#form-jenis_koleksi");
        if (formElement && data) {
            formElement.innerHTML = `<p>Data yang diterima: ${data.someValue}</p>`;
        }
    }
});
