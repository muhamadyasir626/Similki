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
        "#form-jenis_koleksi, #form-asal_satwa, #form-perolehan, #form-status_perlindungan, #form-confirm_no_sats-ln, #form-no_sats-ln, #form-pengambilan_satwa, #form-confirm_sk_menteri, #form-sk_menteri, #form-confirm_sk_kepala, #form-sk_kepala, #form-confirm_sk_ksdae, #form-sk_ksdae, #form-no_ba_titipan, #form-tanggal_tagging, #form-tahun_titipan, #form-tanggal_titipan"
    ).hide();

    //form

    $("input[name='satwa_koleksi']").on("change", function () {
        const selectedValue = $(this).val();
        setSessionData("satwa_koleksi", selectedValue);

        // Reset semua form yang terkait
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
        $("#form-no_ba_titipan input").val("");
        $("#form-tanggal_titipan input").val("");

        // Sembunyikan semua form yang terkait
        $(
            "#form-jenis_koleksi, #form-perolehan, #form-asal_satwa, #form-status_perlindungan, #form-confirm_no_sats-ln, #form-no_sats-ln, #form-pengambilan_satwa, #form-confirm_sk_menteri, #form-sk_menteri, #form-confirm_sk_kepala, #form-sk_kepala, #form-confirm_sk_ksdae, #form-sk_ksdae, #form-no_ba_titipan, #form-tanggal_titipan"
        ).hide();

        // Tampilkan form berdasarkan kondisi
        const isHidup = selectedValue.toLowerCase() === "hidup";
        const isTitipan = selectedValue.toLowerCase() === "satwa titipan";

        if (isHidup) {
            $("#form-jenis_koleksi").show();
        }
        if (isTitipan) {
            $("#form-no_ba_titipan").show();
            $("#form-tanggal_titipan").show();
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

        const selectKoleksi = $(this).val().toLowerCase();
        if (selectKoleksi === "satwa koleksi") {
            $("#form-perolehan").show();
            $("#form-asal_satwa").show();
        } else {
            $("#form-asal_satwa").show();
        }

        const selectTitipan = $(this).val();

        if (selectTitipan.toLowerCase() === "satwa titipan") {
            $("#form-no_ba_titipan").show();
            $("#form-tanggal_titipan").show();
        } else {
            $("#form-no_ba_titipan").hide();
            $("#form-tanggal_titipan").hide();
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

$(function () {
    "use strict";

    function collectFormData(formSections) {
        const data = {};

        formSections.each((section) => {
            const formData = $(section)
                .find("input, select, textarea")
                .serializeArray();

            formData.forEach((item) => {
                data[item.name] = item.value;
            });
        });

        return data;
    }

    function validateVisibleFields(formSection) {
        let isValid = true;

        formSection.find('div[id^="form-"]').each((_, div) => {
            $(div)
                .find("input, select, textarea")
                .each((_, inputField) => {
                    if (
                        $(inputField).prop("required") &&
                        !$(inputField).val().trim() &&
                        $(inputField).is(":visible")
                    ) {
                        isValid = false;
                        $(inputField.siblings(".error-message"))
                            .text("Field is required.")
                            .show();
                    } else {
                        $(inputField.siblings(".error-message")).hide();
                    }

                    if (
                        ($(inputField).is(":radio") ||
                            $(inputField).is(":checkbox")) &&
                        !$(
                            `input[name="${$(inputField).attr(
                                "name"
                            )}"]:checked`
                        ).length > 0
                    ) {
                        isValid = false;
                        $(inputField.closest("div"))
                            .find(".error-message")
                            .text("Please select an option.")
                            .show();
                    } else {
                        $(inputField.closest("div"))
                            .find(".error-message")
                            .hide();
                    }
                });
        });

        return isValid;
    }

    function onFinishedSubmit(event) {
        alert("Form submitted successfully!");
    }

    function clearFormValues(formId) {
        $(formId)
            .find("input, select, textarea")
            .each(function () {
                $(this).val("");
            });
    }
    $(function () {
        "use strict";

        $(
            "#form-alasan_belum_tagging, #form-jenis_tagging, #form-kode_tagging, #form-ba_tagging"
        ).hide();

        $("input[name='perilaku_satwa']").on("change", function () {
            // Reset nilai semua form yang akan muncul selanjutnya
            $("#form-jenis_kelamin input[type='radio']").prop("checked", false);
            $("#form-confirm_tagging input[type='radio']").prop(
                "checked",
                false
            );
            $("#form-nama_satwa_ina input").val("");
            $("#form-nama_panggilan input").val("");
            $("#takson_hewan input").val("");

            // Sembunyikan semua form yang akan muncul selanjutnya
            $("#form-jenis_kelamin").hide();
            $("#form-confirm_tagging").hide();
            $("#form-kode_tagging").hide();
            $("#form-nama_satwa_ina").hide();
            $("#form-nama_panggilan").hide();
            $("#takson_hewan").hide();

            if ($(this).val() === "1") {
                // Individu
                $("#form-jenis_kelamin").show();
                $("#form-confirm_tagging").show();
                $("#form-nama_satwa_ina").show();
                $("#form-nama_panggilan").show();
                $("#takson_hewan").show();
            } else {
                // Berkelompok
                $("#form-jenis_kelamin").show();
                $("#form-confirm_tagging").show();
                $("#form-nama_satwa_ina").show();
                $("#form-nama_panggilan").show();
                $("#takson_hewan").show();
            }
        });

        $("input[name='confirm_tagging']").on("change", function () {
            // Reset nilai semua form yang akan muncul selanjutnya
            $("#form-jenis_tagging input[type='radio']").prop("checked", false);
            $("#form-ba_tagging input").val("");
            $("#form-tanggal_tagging input").val("");
            $("#form-no_ba_kelahiran input").val("");
            $("#form-no_ba_kematian input").val("");
            $("#form-validasi_tanggal input").val("");
            $("#form-tahun_titipan input").val("");
            $("#form-keterangan input").val("");
            $("#form-alasan_belum_tagging input").val("");

            // Sembunyikan semua form yang akan muncul selanjutnya
            $("#form-jenis_tagging").hide();
            $("#form-ba_tagging").hide();
            $("#form-tanggal_tagging").hide();
            $("#form-no_ba_kelahiran").hide();
            $("#form-no_ba_kematian").hide();
            $("#form-validasi_tanggal").hide();
            $("#form-keterangan").hide();
            $("#form-alasan_belum_tagging").hide();

            if ($(this).val().toLowerCase() === "ya") {
                $("#form-jenis_tagging").show();
                $("#form-kode_tagging").show();
                $("#form-ba_tagging").show();
                $("#form-tanggal_tagging").show();
                $("#form-no_ba_kelahiran").show();
                $("#form-no_ba_kematian").show();
                $("#form-validasi_tanggal").show();
                $("#form-keterangan").show();
                $("#form-alasan_belum_tagging").hide();

                // Clear hidden form values
                clearFormValues("#form-ba_tagging");
                clearFormValues("#form-no_ba_kelahiran");
                clearFormValues("#form-no_ba_kematian");
                clearFormValues("#form-keterangan");
                clearFormValues("#form-jenis_tagging");
                clearFormValues("#form-kode_tagging");
                clearFormValues("#form-tanggal_tagging");
                clearFormValues("#form-validasi_tanggal");
            } else {
                $("#form-no_ba_kelahiran").show();
                $("#form-no_ba_kematian").show();
                $("#form-validasi_tanggal").show();
                $("#form-alasan_belum_tagging").show();
                $("#form-keterangan").show();
                $("#form-jenis_tagging").hide();
                $("#form-kode_tagging").hide();
                $("#form-ba_tagging").hide();
                $("#form-tanggal_tagging").hide();

                clearFormValues("#form-alasan_belum_tagging");
            }
        });

        function clearFormValues(formId) {
            $(formId)
                .find("input, select, textarea")
                .each(function () {
                    $(this).val("");
                });
        }

        $("form").on("change", function () {
            $(this)
                .find("input, select, textarea")
                .each(function () {
                    const isVisible = $(this).is(":visible");
                    $(this).prop("required", isVisible);
                });
        });
    });

    var forms = document.querySelectorAll("[id^='stage']");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            var formId = form.id;
            var url = form.action;
            var formData = new FormData(form);
            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            document.getElementById("validation-errors").innerHTML = "";

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            fetch(url, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": token,
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((errorData) => {
                            displayValidationErrors(errorData.errors);
                            throw new Error("Validation failed");
                        });
                    }

                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        transitionStage(formId);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });

    function displayValidationErrors(errors) {
        let errorsContainer = document.getElementById("validation-errors");
        let errorsHtml = "";

        if (errors) {
            errorsHtml +=
                '<div class="font-medium text-red-600">Tolong Periksa kembali</div>';
            errorsHtml +=
                '<ul class="mt-3 list-disc list-inside text-sm text-red-600">';
            Object.keys(errors).forEach(function (key) {
                errors[key].forEach(function (error) {
                    errorsHtml += "<li>" + error + "</li>";
                });
            });
            errorsHtml += "</ul>";
        }

        errorsContainer.innerHTML = errorsHtml;
    }

    function transitionStage(formId) {
        switch (formId) {
            case "stage1":
                stage1to2();
                break;
            case "stage2":
                window.location.href = "/";
                break;
            default:
                console.log(
                    "No such stage exists or no transition function is defined."
                );
                break;
        }
    }

    toggleConditionalForms();
    function toggleConditionalForms() {
        $("input[name='perilaku_satwa']").trigger("change");
        $("input[name='confirm_tagging']").trigger("change");
    }
});
