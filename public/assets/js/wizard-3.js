$(function () {
    // Inisialisasi wizard
    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,
        onStepChanging: function (event, currentIndex, newIndex) {
            console.log("Moving from step", currentIndex, "to step", newIndex);

            // Allow moving back
            if (newIndex < currentIndex) {
                return true;
            }

            let isValid = true;
            const currentSection = $("#wizard-p-" + currentIndex);

            // Validate all visible fields in the current step
            currentSection.find("div[id^='form-']").each(function () {
                $(this)
                    .find("input, select, textarea")
                    .each(function () {
                        const isVisible = $(this).is(":visible");
                        const inputName = $(this).attr("name");

                        console.log(
                            "Validating:",
                            inputName,
                            "Value:",
                            $(this).val(),
                            "Visible:",
                            isVisible
                        );

                        // Validate required fields
                        if (
                            $(this).prop("required") &&
                            isVisible &&
                            !$(this).val().trim()
                        ) {
                            isValid = false;
                            $(this)
                                .siblings(".error-message")
                                .text("Field is required.")
                                .show();
                        } else {
                            $(this).siblings(".error-message").hide();
                        }
                    });
            });

            if (!isValid) {
                alert("Isi semua kolom jika ingin melanjutkan pertanyaan.");
            }

            return isValid; // Return whether the step is valid
        },

        // Custom submit button for final step
        onFinished: function () {
            alert("Form submitted successfully!");
        },
    });

    $('#form-punya-anak').hide();
    $('#form-dipisahkan').hide();
    $('#form-pasangan').hide();
    $('#form-tanggal-dipasangkan').hide();
    $('#form-tanggal-dipisahkan').hide();
    $('#form-alasan-pisah').hide();

    // Show the form-pasangan field when "Sudah" is selected
    $('#form-punya-pasangan input[name="status"]').on('change', function () {
        var status = $("input[name='status']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Sudah" dipilih
        if (status === 'sudah') {
            $('#form-pasangan').show();  // Tampilkan form pasangan
            $('#form-tanggal-dipasangkan').show(); // Tampilkan form tanggal dipasangkan
            $('#form-punya-anak').show();
        } else {
            // Jika "Belum" dipilih, sembunyikan form-form terkait
            $('#form-pasangan').hide();
            $('#form-tanggal-dipasangkan').hide();
            $('#form-tanggal-dipisahkan').hide();
            $('#form-punya-anak').hide();
        }
    });

    // Show the form-anak field when "Sudah" is selected
    $('#form-punya-anak input[name="punya_anak"]').on('change', function () {
        var punya_anak = $("input[name='punya_anak']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (punya_anak === 'ya') {
            $('#form-anak').show(); // Tampilkan form tanggal dipasangkan
            $('#form-dipisahkan').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-anak').hide();
        }
    });

    // Show the form-anak field when "Sudah" is selected
    $('#form-dipisahkan input[name="dipisahkan"]').on('change', function () {
        var dipisahkan = $("input[name='dipisahkan']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (dipisahkan === 'sudah') {
            $('#form-tanggal-dipisahkan').show(); // Tampilkan form tanggal dipasangkan
            $('#form-alasan-pisah').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-tanggal-dipisahkan').hide();
            $('#form-alasan-pisah').show();
        }
    });
});
