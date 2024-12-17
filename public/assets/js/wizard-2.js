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
            "#form-jumlah, #form-jumlah_keseluruhan_gender, #form-jenis_kelamin, #form-confirm_tagging, #form-alasan_belum_tagging, #form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-nama_panggilan, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina"
        ).hide();

        // $("input[name='perilaku_satwa']").on("change", function () {
        //     if ($(this).val() === "1") {
        //         // Individu
        //         $("#form-jenis_kelamin").show();
        //         $("#form-confirm_tagging").show();
        //         $("#form-nama_satwa_ina").show();
        //         $("#form-nama_panggilan").show();
        //         $("#takson_hewan").show();
        //         clearFormValues("#form-total_satwa");
        //     } else {
        //         // Berkelompok
        //         $("#form-jenis_kelamin").show();
        //         $("#form-confirm_tagging").show();
        //         $("#form-nama_satwa_ina").show();
        //         $("#form-nama_panggilan").show();
        //         $("#takson_hewan").show();
        //         clearFormValues("#form-jumlah");
        //         clearFormValues("#form-total_satwa");
        //     }
        // });
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
            $("#form-jumlah input").val("");
            $("#form-total_satwa input").val("");

            // Sembunyikan semua form yang akan muncul selanjutnya
            $("#form-jenis_kelamin").hide();
            $("#form-confirm_tagging").hide();
            $("#form-nama_satwa_ina").hide();
            $("#form-nama_panggilan").hide();
            $("#takson_hewan").hide();
            $("#form-jumlah").hide();
            $("#form-total_satwa").hide();

            if ($(this).val() === "1") {
                // Individu
                $("#form-jenis_kelamin").show();
                $("#form-confirm_tagging").show();
                $("#form-nama_satwa_ina").show();
                $("#form-nama_panggilan").show();
                $("#takson_hewan").show();
                clearFormValues("#form-total_satwa");
            } else {
                // Berkelompok
                $("#form-jenis_kelamin").show();
                $("#form-confirm_tagging").show();
                $("#form-nama_satwa_ina").show();
                $("#form-nama_panggilan").show();
                $("#takson_hewan").show();
                clearFormValues("#form-jumlah");
                clearFormValues("#form-total_satwa");
            }
        });

        // $("input[name='confirm_tagging']").on("change", function () {
        //     if ($(this).val().toLowerCase() === "ya") {
        //         $("#form-jenis_tagging").show();
        //         $("#form-ba_tagging").show();
        //         $("#form-tanggal_tagging").show();
        //         $("#form-no_ba_titipan").show();
        //         $("#form-no_ba_kelahiran").show();
        //         $("#form-no_ba_kematian").show();
        //         $("#form-validasi_tanggal").show();
        //         $("#form-tahun_titipan").show();
        //         $("#form-keterangan").show();
        //         $("#form-alasan_belum_tagging").hide();

        //         // Clear hidden form values
        //         clearFormValues("#form-ba_tagging");
        //         clearFormValues("#form-no_ba_titipan");
        //         clearFormValues("#form-no_ba_kelahiran");
        //         clearFormValues("#form-no_ba_kematian");
        //         clearFormValues("#form-keterangan");
        //         clearFormValues("#form-jenis_tagging");
        //         clearFormValues("#form-tanggal_tagging");
        //         clearFormValues("#form-validasi_tanggal");
        //         clearFormValues("#form-tahun_titipan");
        //     } else {
        //         $("#form-alasan_belum_tagging").show();
        //         $("#form-jenis_tagging").hide();
        //         $("#form-ba_tagging").hide();
        //         $("#form-tanggal_tagging").hide();

        //         clearFormValues("#form-alasan_belum_tagging");
        //     }
        // });

        $("input[name='confirm_tagging']").on("change", function () {
            // Reset nilai semua form yang akan muncul selanjutnya
            $("#form-jenis_tagging input[type='radio']").prop("checked", false);
            $("#form-ba_tagging input").val("");
            $("#form-tanggal_tagging input").val("");
            $("#form-no_ba_titipan input").val("");
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
            $("#form-no_ba_titipan").hide();
            $("#form-no_ba_kelahiran").hide();
            $("#form-no_ba_kematian").hide();
            $("#form-validasi_tanggal").hide();
            $("#form-tahun_titipan").hide();
            $("#form-keterangan").hide();
            $("#form-alasan_belum_tagging").hide();

            if ($(this).val().toLowerCase() === "ya") {
                $("#form-jenis_tagging").show();
                $("#form-ba_tagging").show();
                $("#form-tanggal_tagging").show();
                $("#form-no_ba_titipan").show();
                $("#form-no_ba_kelahiran").show();
                $("#form-no_ba_kematian").show();
                $("#form-validasi_tanggal").show();
                $("#form-tahun_titipan").show();
                $("#form-keterangan").show();
                $("#form-alasan_belum_tagging").hide();

                // Clear hidden form values
                clearFormValues("#form-ba_tagging");
                clearFormValues("#form-no_ba_titipan");
                clearFormValues("#form-no_ba_kelahiran");
                clearFormValues("#form-no_ba_kematian");
                clearFormValues("#form-keterangan");
                clearFormValues("#form-jenis_tagging");
                clearFormValues("#form-tanggal_tagging");
                clearFormValues("#form-validasi_tanggal");
                clearFormValues("#form-tahun_titipan");
            } else {
                $("#form-alasan_belum_tagging").show();
                $("#form-jenis_tagging").hide();
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
