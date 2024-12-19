$(function () {
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

                        // Validate radio/checkbox groups
                        if ($(this).is(":radio") || $(this).is(":checkbox")) {
                            const groupName = $(this).attr("name");
                            const isChecked =
                                $(`input[name='${groupName}']:checked`).length >
                                0;
                            if (!isChecked && isVisible) {
                                isValid = false;
                                $(this)
                                    .closest("div")
                                    .find(".error-message")
                                    .text("Please select an option.")
                                    .show();
                            } else {
                                $(this)
                                    .closest("div")
                                    .find(".error-message")
                                    .hide();
                            }
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

    // Ensure only visible inputs are required
    function toggleRequiredFields() {
        $("form")
            .find("input, select, textarea")
            .each(function () {
                const isVisible = $(this).is(":visible");
                $(this).prop("required", isVisible);
            });
    }

    // Hide all conditional forms initially
    $("#form-no-izin,  #form-no-tgl-surat, #form-nama-pimpinan, #form-izin-tsl, #form-tahun-akre, #form-nilai-akre, #form-pks, #form-pks-lk-lain").hide();
    

     // Show the field when "Ya" is selected
     $('#form-akred input[name="akreditasi"]').on('change', function () {
        var akreditasi = $("input[name='akreditasi']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (akreditasi === 'ya') {
            $('#form-tahun-akre').show();
            $('#form-nilai-akre').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-tahun-akre').hide();
            $('#form-nilai-akre').hide();
        }
    });

    $('#form-no-surat input[name="no_surat"]').on('change', function () {
        var no_surat = $("input[name='no_surat']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (no_surat === 'ya') {
            $('#form-no-tgl-surat').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-no-tgl-surat').hide();
        }
    });

    $('#form-izin-peroleh input[name="izin_peroleh"]').on('change', function () {
        var izin_peroleh = $("input[name='izin_peroleh']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (izin_peroleh === 'ya') {
            $('#form-no-izin').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-no-izin').hide();
        }
    });

    $('#form-tsl input[name="tsl"]').on('change', function () {
        var tsl = $("input[name='tsl']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (tsl === 'ya') {
            $('#form-izin-tsl').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-izin-tsl').hide();
        }
    });

    $('#form-pks input[name="pks_lk"]').on('change', function () {
        var pks_lk = $("input[name='pks_lk']:checked").val(); // Dapatkan nilai yang dipilih

        // Jika "Ya" dipilih
        if (pks_lk === 'ya') {
            $('#form-pks-lk-lain').show();
        } else {
            // Jika "Tidak" dipilih, sembunyikan form-form terkait
            $('#form-pks-lk-lain').hide();
        }
    });

    // Trigger next step manually
    $("#custom-next").on("click", function () {
        $("#wizard").steps("next");
    });

    // Trigger previous step manually
    $("#custom-previous").on("click", function () {
        $("#wizard").steps("previous");
    });
});