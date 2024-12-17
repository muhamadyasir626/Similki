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
    $(
        "#form-jenis_koleksi, #form-asal_satwa, #form-perolehan, #form-status_perlindungan, #form-confirm_no_sats-ln, #form-no_sats-ln, #form-pengambilan_satwa, #form-confirm_sk_menteri, #form-sk_menteri, #form-confirm_sk_kepala, #form-sk_kepala, #form-confirm_sk_ksdae, #form-sk_ksdae, #form-tanggal_titipan, #form-no_ba_titipan"
    ).hide();

    $("input[name='satwa_koleksi']").on("change", function () {
        const isHidup = $(this).val().toLowerCase() === "hidup";
        $("#form-jenis_koleksi").toggle(isHidup);
        if (!isHidup) {
            $("#form-jenis_koleksi")
                .find("input, select, textarea")
                .prop("required", false);
            // Jika bukan satwa hidup, langsung tampilkan asal satwa
            $("#form-asal_satwa").hide();
            $("#form-perolehan").hide();
        }
    });

    // Show 'No. Perolehan' and 'Asal Satwa' based on 'jenis_koleksi' selection
    $("#form-jenis_koleksi input[type='radio']").on("change", function () {
        const selectedValue = $(this).val().toLowerCase();
        if (selectedValue === "koleksi") {
            $("#form-perolehan").show();
            $("#form-perolehan").slideDown();
            $("#form-asal_satwa").show();
        } else {
            $("#form-perolehan").hide();
            $("#form-tanggal_titipan").hide();
            $("#form-no_ba_titipan").hide();
            $("#form-asal_satwa").show();
            $("#form-asal_satwa").slideDown();
        }
        if (selectedValue === "titipan") {
            $("#form-tanggal_titipan").show();
            $("#form-tanggal_titipan").slideDown();
            $("#form-no_ba_titipan").show();
        } else {
            $("#form-perolehan").hide();
            $("#form-asal_satwa").show();
            $("#form-asal_satwa").slideDown();
        }
    });

    $("input[name='asal_satwa']").on("change", function () {
        if ($(this).val().toLowerCase() === "endemik") {
            $("#form-status_perlindungan").show();
            $("#form-status_perlindungan").slideDown();
            $("#form-confirm_no_sats-ln").hide();
            $("#form-no_sats-ln").hide();
        } else {
            $("#form-confirm_no_sats-ln").show();
            $("#form-status_perlindungan").hide();
        }
    });

    $("input[name='confirm_no_sats-ln']").on("change", function () {
        $("#form-no_sats-ln").toggle($(this).val().toLowerCase() === "ya");
    });

    $("input[name='status_perlindungan']").on("change", function () {
        if ($(this).val() === "1") {
            $("#form-pengambilan_satwa").show();
            $("#form-pengambilan_satwa").slideDown();
            $("#form-confirm_sk_kepala").hide();
        } else {
            $("#form-confirm_sk_kepala").show();
            $("#form-confirm_sk_kepala").slideDown();
            $("#form-pengambilan_satwa").hide();
        }
    });

    $("input[name='confirm_sk_kepala']").on("change", function () {
        $("#form-sk_kepala").toggle($(this).val().toLowerCase() === "ya");
    });

    $("input[name='pengambilan_satwa']").on("change", function () {
        if ($(this).val() === "1") {
            $("#form-confirm_sk_menteri").show();
            $("#form-confirm_sk_ksdae").hide();
        } else {
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").show();
        }
    });

    $("input[name='confirm_sk_menteri']").on("change", function () {
        $("#form-sk_menteri").toggle($(this).val().toLowerCase() === "ya");
    });

    $("input[name='confirm_sk_ksdae']").on("change", function () {
        $("#form-sk_ksdae").toggle($(this).val().toLowerCase() === "ya");
    });

    // Ensure only visible inputs are required
    $("form").on("change", function () {
        $(this)
            .find("input, select, textarea")
            .each(function () {
                const isVisible = $(this).is(":visible");
                $(this).prop("required", isVisible);
            });
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
