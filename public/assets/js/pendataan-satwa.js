document.addEventListener("DOMContentLoaded", function () {
    const form1 = document.getElementById("pendataan1");
    const form2 = document.getElementById("pendataan2");
    const form3 = document.getElementById("pendataan3");
    //button nya blm ke define
    const submitButton = document.getElementById("submit-all");

    submitButton.addEventListener("click", function (event) {
        event.preventDefault();

        const formData = new FormData();

        new FormData(form1).forEach((value, key) => {
            formData.append(key, value);
        });
        new FormData(form2).forEach((value, key) => {
            formData.append(key, value);
        });
        new FormData(form3).forEach((value, key) => {
            formData.append(key, value);
        });

        fetch("{{ route(`satwa.store`) }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    form1.reset();
                    form2.reset();
                    form3.reset();
                } else {
                    console.error(data.errors);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred while submitting the form.");
            });
    });
});

$("#validasi_tanggal").on("focus", function () {
    $(this).prop("type", "date"); // Mengubah tipe menjadi date saat difokuskan
});

$("#validasi_tanggal").on("blur", function () {
    $(this).prop("type", "text"); // Kembalikan tipe ke text saat kehilangan fokus (optional)
});
