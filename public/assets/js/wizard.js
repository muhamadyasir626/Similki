$(function () {
    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,
        onStepChanging: function (event, currentIndex, newIndex) {
            if (newIndex < currentIndex) {
                return true; // Mengizinkan navigasi mundur tanpa validasi
            }

            let isValid = true;
            const currentSection = $("#wizard-p-" + currentIndex);

            currentSection.find("div[id^='form-']").each(function () {
                $(this)
                    .find("input, select, textarea")
                    .each(function () {
                        const isVisible = $(this).is(":visible");
                        const inputName = $(this).attr("name");

                        // Validasi input yang required
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

                        // Validasi radio atau checkbox
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

            if (isValid) {
                // Ambil data dari formulir di langkah saat ini
                const formData = {};
                currentSection
                    .find("input, select, textarea")
                    .each(function () {
                        const name = $(this).attr("name");
                        if (name) {
                            formData[name] = $(this).val();
                        }
                    });

                // Simpan data ke sessionStorage
                const sessionData = getSessionData();
                sessionData[`step_${currentIndex}`] = formData;
                sessionStorage.setItem("data", JSON.stringify(sessionData));
            } else {
                $("#popup-warning").fadeIn();
            }

            return isValid;
        },

        onFinished: function () {
            sessionStorage.setItem("data", "{}");

            const data = JSON.parse(sessionStorage.getItem("data"));
            $.ajax({
                type: "POST",
                url: "/satwas",
                data: data,
                success: function (response) {
                    alert("Form submitted successfully!");
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert("An error occurred. Please try again.");
                },
            });
        },
    });

    $("#close-popup").on("click", function () {
        $("#popup-warning").fadeOut();
    });

    function toggleRequiredFields() {
        $("form")
            .find("input, select, textarea")
            .each(function () {
                const isVisible = $(this).is(":visible");
                $(this).prop("required", isVisible);
            });
    }

    function getSessionData() {
        const data = sessionStorage.getItem("data");
        return data ? JSON.parse(data) : {};
    }

    function setSessionData(stepKey, formData) {
        const data = getSessionData();
        data[stepKey] = formData;
        sessionStorage.setItem("data", JSON.stringify(data));
        console.log("Data tersimpan:", data);
    }

    function checkSessionData() {
        const data = sessionStorage.getItem("data");
        console.log("Data di sessionStorage:", data);
    }

    checkSessionData();

    $(
        "#form-jenis_koleksi, #form-asal_satwa, #form-perolehan, #form-status_perlindungan, #form-confirm_no_sats-ln, #form-no_sats-ln, #form-pengambilan_satwa, #form-confirm_sk_menteri, #form-sk_menteri, #form-confirm_sk_kepala, #form-sk_kepala, #form-confirm_sk_ksdae, #form-sk_ksdae"
    ).hide();

    //form

    $("input[name='satwa_koleksi']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("satwa_koleksi", selectedValue);

        $("#form-jenis_koleksi input[type='radio']").prop("checked", false);
        $("#form-perolehan input").val("");
        $("#form-asal_satwa input[type='radio']").prop("checked", false);
        $("#form-status_perlindungan input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-confirm_no_sats-ln input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-no_sats-ln input").val("");
        $("#form-pengambilan_satwa input[type='radio']").prop("checked", false);
        $("#form-confirm_sk_menteri input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-sk_menteri input").val("");
        $("#form-confirm_sk_kepala input[type='radio']").prop("checked", false);
        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-jenis_koleksi").hide();
        $("#form-perolehan").hide();
        $("#form-asal_satwa").hide();
        $("#form-status_perlindungan").hide();
        $("#form-confirm_no_sats-ln").hide();
        $("#form-no_sats-ln").hide();
        $("#form-pengambilan_satwa").hide();
        $("#form-confirm_sk_menteri").hide();
        $("#form-sk_menteri").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        const isHidup = $(this).val().toLowerCase() === "hidup";
        if (isHidup) {
            $("#form-jenis_koleksi").show();
        }
    });

    $("#form-jenis_koleksi input[type='radio']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("form-jenis_koleksi", selectedValue);

        $("#form-perolehan input").val("");
        $("#form-asal_satwa input[type='radio']").prop("checked", false);
        $("#form-status_perlindungan input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-confirm_no_sats-ln input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-no_sats-ln input").val("");
        $("#form-pengambilan_satwa input[type='radio']").prop("checked", false);
        $("#form-confirm_sk_menteri input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-sk_menteri input").val("");
        $("#form-confirm_sk_kepala input[type='radio']").prop("checked", false);
        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-perolehan").hide();
        $("#form-asal_satwa").hide();
        $("#form-status_perlindungan").hide();
        $("#form-confirm_no_sats-ln").hide();
        $("#form-no_sats-ln").hide();
        $("#form-pengambilan_satwa").hide();
        $("#form-confirm_sk_menteri").hide();
        $("#form-sk_menteri").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        const selectVal = $(this).val().toLowerCase();
        if (selectVal === "satwa koleksi") {
            $("#form-perolehan").show();
            $("#form-asal_satwa").show();
        } else {
            $("#form-asal_satwa").show();
        }
    });

    $("input[name='asal_satwa']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("asal_satwa", selectedValue);

        $("#form-status_perlindungan input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-confirm_no_sats-ln input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-no_sats-ln input").val("");
        $("#form-pengambilan_satwa input[type='radio']").prop("checked", false);
        $("#form-confirm_sk_menteri input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-sk_menteri input").val("");
        $("#form-confirm_sk_kepala input[type='radio']").prop("checked", false);
        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-status_perlindungan").hide();
        $("#form-confirm_no_sats-ln").hide();
        $("#form-no_sats-ln").hide();
        $("#form-pengambilan_satwa").hide();
        $("#form-confirm_sk_menteri").hide();
        $("#form-sk_menteri").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        if ($(this).val().toLowerCase() === "endemik") {
            $("#form-status_perlindungan").show();
        } else {
            $("#form-confirm_no_sats-ln").show();
        }
    });

    $("input[name='confirm_no_sats-ln']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("confirm_no_sats-ln", selectedValue);

        $("#form-no_sats-ln").toggle($(this).val().toLowerCase() === "ya");
    });

    $("input[name='status_perlindungan']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("status_perlindungan", selectedValue);

        $("#form-pengambilan_satwa input[type='radio']").prop("checked", false);
        $("#form-confirm_sk_menteri input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-sk_menteri input").val("");
        $("#form-confirm_sk_kepala input[type='radio']").prop("checked", false);
        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-pengambilan_satwa").hide();
        $("#form-confirm_sk_menteri").hide();
        $("#form-sk_menteri").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        if ($(this).val() === "1") {
            $("#form-pengambilan_satwa").show();
        } else {
            $("#form-confirm_sk_kepala").show();
        }
    });

    $("input[name='confirm_sk_kepala']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("confirm_sk_kepala", selectedValue);

        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        if ($(this).val().toLowerCase() === "ya") {
            $("#form-sk_kepala").show();
        } else {
            $("#form-confirm_sk_ksdae").show();
        }
    });

    $("input[name='pengambilan_satwa']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("pengambilan_satwa", selectedValue);

        $("#form-confirm_sk_menteri input[type='radio']").prop(
            "checked",
            false
        );
        $("#form-sk_menteri input").val("");
        $("#form-confirm_sk_kepala input[type='radio']").prop("checked", false);
        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-confirm_sk_menteri").hide();
        $("#form-sk_menteri").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        if ($(this).val() === "1") {
            $("#form-confirm_sk_menteri").show();
        } else {
            $("#form-confirm_sk_kepala").show();
        }
    });

    $("input[name='confirm_sk_menteri']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("confirm_sk_menteri", selectedValue);

        $("#form-sk_menteri input").val("");
        $("#form-confirm_sk_kepala input[type='radio']").prop("checked", false);
        $("#form-sk_kepala input").val("");
        $("#form-confirm_sk_ksdae input[type='radio']").prop("checked", false);
        $("#form-sk_ksdae input").val("");

        $("#form-sk_menteri").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_ksdae").hide();

        if ($(this).val().toLowerCase() === "ya") {
            $("#form-sk_menteri").show();
        } else {
            $("#form-confirm_sk_kepala").show();
        }
    });

    $("input[name='confirm_sk_ksdae']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("confirm_sk_ksdae", selectedValue);

        $("#form-sk_ksdae input").val("");

        $("#form-sk_ksdae").hide();

        if ($(this).val().toLowerCase() === "ya") {
            $("#form-sk_ksdae").show();
        }
    });

    //form

    $("form").on("change", function () {
        $(this)
            .find("input, select, textarea")
            .each(function () {
                const isVisible = $(this).is(":visible");
                $(this).prop("required", isVisible);
            });
    });

    $("#custom-next").on("click", function () {
        $("#wizard").steps("next");
    });

    $("#custom-previous").on("click", function () {
        $("#wizard").steps("previous");
    });
});
