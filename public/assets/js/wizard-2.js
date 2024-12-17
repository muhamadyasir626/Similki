// $(function () {
//     "use strict";

//     // Fungsi untuk mengumpulkan data dari form
//     function collectData() {
//         const data = {};
//         $("#wizard section").each(function () {
//             const formData = $(this)
//                 .find("input, select, textarea")
//                 .serializeArray();
//             formData.forEach((item) => {
//                 data[item.name] = item.value;
//             });
//         });
//         return data;
//     }

//     // Tombol submit
//     $("#submit-button").on("click", function (event) {
//         event.preventDefault();

//         if (validateCurrentStep()) {
//             const formData = collectData();
//             console.log("Data berhasil dikumpulkan:", formData);

//             alert("Data berhasil disimpan ke console!");
//         } else {
//             alert("Silakan periksa kembali form yang belum valid.");
//         }
//     });

//     // Awalnya sembunyikan semua form lanjutan
//     $(
//         "#form-jumlah, #form-jumlah_keseluruhan_gender, #form-jenis_kelamin, #form-confirm_tagging, #form-alasan_belum_tagging, #form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-nama_panggilan, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina, #form-nama_panggilan, #takson_hewan, #form-total_satwa"
//     ).hide();

//     // Fungsi untuk validasi hanya pada elemen yang terlihat
//     function validateVisibleFields() {
//         let isValid = true;
//         $(
//             ":visible input[required], :visible textarea[required], :visible select[required]"
//         ).each(function () {
//             if (!this.checkValidity()) {
//                 isValid = false;
//                 $(this).addClass("is-invalid");
//                 $(this).siblings(".error-message").remove();
//                 $(this).after(
//                     `<span class="error-message text-danger">${this.validationMessage}</span>`
//                 );
//             } else {
//                 $(this).removeClass("is-invalid");
//                 $(this).siblings(".error-message").remove();
//             }
//         });
//         return isValid;
//     }

//     // Tampilkan atau sembunyikan form berdasarkan pilihan perilaku_satwa
//     $("input[name='perilaku_satwa']").on("change", function () {
//         if ($(this).val() === "Ya") {
//             $("#form-jumlah").show();
//             $("#form-total_satwa").show();
//             $(
//                 "#form-jenis_kelamin, #form-jumlah_keseluruhan_gender, #takson_hewan, #form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-alasan_belum_tagging, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina"
//             ).hide();
//         } else {
//             $("#form-jumlah").hide();
//             $("#form-total_satwa").hide();
//             $("#form-jenis_kelamin").show();
//             $("#form-jumlah_keseluruhan_gender").show();
//             $("#takson_hewan").show();
//         }
//         validateVisibleFields();
//     });

//     // Tampilkan form confirm_tagging setelah memilih jenis kelamin
//     $("#form-jenis_kelamin input[type='radio']").on("change", function () {
//         $("#form-confirm_tagging").show();
//         validateVisibleFields();
//     });

//     // Tampilkan atau sembunyikan form berdasarkan pilihan confirm_tagging
//     $("input[name='confirm_tagging']").on("change", function () {
//         if ($(this).val() === "Ya") {
//             $(
//                 "#form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina"
//             ).show();
//             $("#form-alasan_belum_tagging").hide();
//         } else {
//             $(
//                 "#form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian"
//             ).hide();
//             $(
//                 "#form-alasan_belum_tagging, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina"
//             ).show();
//         }
//         validateVisibleFields();
//     });
// });

$(function () {
    "use strict";

    // Fungsi untuk mengumpulkan data dari form
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

    // Fungsi untuk validasi field visible
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

    // Custom submit button for final step
    function onFinishedSubmit(event) {
        alert("Form submitted successfully!");
    }

    function clearFormValues(formId) {
        $(formId).find("input, select, textarea").each(function () {
            $(this).val('');
        });
    }    
    // Awalnya sembunyikan semua form lanjutan
    // $(
    //     "#form-jumlah, #form-jumlah_keseluruhan_gender, #form-jenis_kelamin, #form-confirm_tagging, #form-alasan_belum_tagging, #form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-nama_panggilan, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina, #takson_hewan, #form-total_satwa"
    // ).hide();

    // $("input[name='perilaku_satwa']").on("change", function () {
    //     if ($(this).val() === "1") {
    //         $("#form-jumlah").show();
    //         $("#form-jenis_kelamin").hide();
    //         $("#form-jumlah_keseluruhan_gender").hide();
    //         $("#form-confirm_tagging").hide();
    //         //individu form
    //         $("#form-nama_satwa_ina").hide();
    //         $("#form-nama_panggilan").hide();
    //         $("#takson_hewan").hide();
    //         //berkelompok form
    //         $("#form-total_satwa").show();

    //         // Clear hidden form values
    //         clearFormValues("#form-jenis_kelamin");
    //         clearFormValues("#form-jumlah_keseluruhan_gender");
    //         clearFormValues("#form-confirm_tagging");
    //         clearFormValues("#form-nama_satwa_ina");
    //         clearFormValues("#form-nama_panggilan");
    //         clearFormValues("#takson_hewan");
    //         clearFormValues("#form-total_satwa");
            
    //     } else {
    //         $("#form-jenis_kelamin").show();
    //         $("#form-jumlah_keseluruhan_gender").show();
    //         $("#form-confirm_tagging").show();
    //         $("#form-jumlah").hide();
    //         //individu form
    //         $("#form-nama_satwa_ina").show();
    //         $("#form-nama_panggilan").show();
    //         $("#takson_hewan").show();
    //         //berkelompok form
    //         $("#form-total_satwa").hide();

    //         // Clear hidden form values
    //         clearFormValues("#form-jumlah");
    //         clearFormValues("#form-total_satwa");
    //     }
    // });

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

    //     } else {
    //         $("#form-alasan_belum_tagging").show();
    //         $("#form-jenis_tagging").hide();
    //         $("#form-ba_tagging").hide();
    //         $("#form-tanggal_tagging").hide();
    //         $("#form-no_ba_titipan").hide();
    //         $("#form-no_ba_kelahiran").hide();
    //         $("#form-no_ba_kematian").hide();
    //         $("#form-validasi_tanggal").hide();
    //         $("#form-tahun_titipan").hide();
    //         $("#form-keterangan").hide();

    //         clearFormValues("#form-alasan_belum_tagging");
    //     }
    // });

    // // Ensure only visible inputs are required
    // $("form").on("change", function () {
    //     $(this)
    //         .find("input, select, textarea")
    //         .each(function () {
    //             const isVisible = $(this).is(":visible");
    //             $(this).prop("required", isVisible);
    //         });
    // });
    $(function () {
        "use strict";
    
        // Awalnya sembunyikan semua form lanjutan
        $(
            "#form-jumlah, #form-jumlah_keseluruhan_gender, #form-jenis_kelamin, #form-confirm_tagging, #form-alasan_belum_tagging, #form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-nama_panggilan, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina, #takson_hewan, #form-total_satwa"
        ).hide();
    
        // Event handler untuk perilaku satwa
        $("input[name='perilaku_satwa']").on("change", function () {
            if ($(this).val() === "1") { // Individu
                $("#form-jumlah").show();
                $("#form-jenis_kelamin").hide();
                $("#form-jumlah_keseluruhan_gender").hide();
                $("#form-confirm_tagging").hide();
                $("#form-nama_satwa_ina").hide();
                $("#form-nama_panggilan").hide();
                $("#takson_hewan").hide();
                $("#form-total_satwa").show(); // Tidak tampilkan form total satwa saat individu
    
                // Clear hidden form values
                clearFormValues("#form-total_satwa");
            } else { // Berkelompok
                $("#form-jenis_kelamin").show();
                $("#form-jumlah_keseluruhan_gender").show();
                $("#form-confirm_tagging").show();
                $("#form-jumlah").hide();
                $("#form-nama_satwa_ina").show();
                $("#form-nama_panggilan").show();
                $("#takson_hewan").show();
                $("#form-total_satwa").hide(); // Menyembunyikan form total satwa jika berkelompok
    
                // Clear hidden form values
                clearFormValues("#form-jumlah");
                clearFormValues("#form-total_satwa");
            }
        });

        $("input[name='confirm_tagging']").on("change", function () {
            // console.log("Nilai confirm_tagging:", $(this).val());
            if ($(this).val().toLowerCase() === "ya") {
                // console.log("Menampilkan form tagging");
                $("#form-jenis_tagging").show();
                $("#form-ba_tagging").show();
                $("#form-tanggal_tagging").show();
                // $("#form-no_ba_titipan").show();
                $("#form-no_ba_kelahiran").show();
                $("#form-no_ba_kematian").show();
                $("#form-validasi_tanggal").show();
                // $("#form-tahun_titipan").show();
                $("#form-keterangan").show();
                $("#form-alasan_belum_tagging").hide(); // Pastikan ini tersembunyi

                // Clear hidden form values
                clearFormValues("#form-ba_tagging");
                // clearFormValues("#form-no_ba_titipan");
                clearFormValues("#form-no_ba_kelahiran");
                clearFormValues("#form-no_ba_kematian");
                clearFormValues("#form-keterangan");
                clearFormValues("#form-jenis_tagging");
                clearFormValues("#form-tanggal_tagging");
                clearFormValues("#form-validasi_tanggal");
                // clearFormValues("#form-tahun_titipan");
            } else {
                // console.log("Menampilkan alasan belum tagging");
                $("#form-alasan_belum_tagging").show();
                $("#form-jenis_tagging").hide();
                
                clearFormValues("#form-alasan_belum_tagging");
            }
        });
        
    
        // // Event handler untuk konfirmasi tagging
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
        //         $("#form-alasan_belum_tagging").hide(); // Sembunyikan alasan jika tagging disetujui
    
        //         // Clear hidden form values
        //         clearFormValues("#form-ba_tagging");
        //         clearFormValues("#form-no_ba_titipan");
        //         clearFormValues("#form-no_ba_kelahiran");
        //         clearFormValues("#form-no_ba_kematian");
        //         clearFormValues("#form-keterangan");

        //     } else { // Tidak
        //         $("#form-alasan_belum_tagging").show();
        //         $("#form-jenis_tagging").hide();
        //         $("#form-ba_tagging").hide();
        //         $("#form-tanggal_tagging").hide();
        //         $("#form-no_ba_titipan").hide();
        //         $("#form-no_ba_kelahiran").hide();
        //         $("#form-no_ba_kematian").hide();
        //         $("#form-validasi_tanggal").hide();
        //         $("#form-tahun_titipan").hide();
        //         $("#form-keterangan").hide();
    
        //         clearFormValues("#form-alasan_belum_tagging");
        //     }
        // });
    
        // Fungsi untuk mengosongkan nilai form yang tersembunyi
        function clearFormValues(formId) {
            $(formId).find("input, select, textarea").each(function () {
                $(this).val('');
            });
        }
    
        // Pastikan hanya input yang terlihat yang wajib diisi
        $("form").on("change", function () {
            $(this)
                .find("input, select, textarea")
                .each(function () {
                    const isVisible = $(this).is(":visible");
                    $(this).prop("required", isVisible);
                });
        });
    });
    

    // $("#submit-button").on("click", function (event) {
    //     event.preventDefault();

    //     const formSection = $("your-form-section-selector"); // Replace with your actual form section selector
    //     const csrf_token = document.
    //     if (validateVisibleFields(formSection)) {
    //         const formData = collectFormData(formSection);
    //         console.log("Data collected:", formData);

    //         // Send data to the backend
    //         fetch("/satwa", {
    //             // URL of your API endpoint
    //             method: "POST",
    //             headers: {
    //                 "Content-Type": "application/json",
    //             },
    //             body: JSON.stringify(formData), // Convert formData object to JSON string
    //         })
    //             .then((response) => response.json())
    //             .then((data) => {
    //                 if (data.success) {
    //                     alert("Data successfully submitted to the database!");
    //                 } else {
    //                     alert("An error occurred. Please try again.");
    //                 }
    //             })
    //             .catch((error) => {
    //                 console.error("Error:", error);
    //                 alert("There was an issue submitting the form.");
    //             });
    //     } else {
    //         alert("Please complete all required fields before submitting.");
        
    // });

    //dynamic form

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

        // for (let entry of formData.entries()) {
        //     console.log(entry[0] + ": " + entry[1]);
        // }

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
                // alert('An error occurred, please try again.');
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
            break; // Mencegah eksekusi lanjut ke case berikutnya
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

    // Inisialisasi logika form bersyarat
    toggleConditionalForms();
    function toggleConditionalForms() {
        $("input[name='perilaku_satwa']").trigger("change"); // Trigger the change event manually
        $("input[name='confirm_tagging']").trigger("change"); // Trigger this change event as well
    }
});
