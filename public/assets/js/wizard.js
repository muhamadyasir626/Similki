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
        //   sessionStorage.getItem("data", "{}");

        // const data = JSON.parse(sessionStorage.getItem("data"));
        // const data = getSessionData();
        // console.log(data);

        
          $.ajax({
              type: "POST",
              url: "/satwa",
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

  $(
      "#form-jenis_koleksi, #form-asal_satwa, #form-perolehan, #form-status_perlindungan, #form-confirm_no_sats-ln, #form-no_sats-ln, #form-pengambilan_satwa, #form-confirm_sk_menteri, #form-sk_menteri, #form-confirm_sk_kepala, #form-sk_kepala, #form-confirm_sk_ksdae, #form-sk_ksdae, #form-no_ba_titipan, #form-tanggal_tagging, #form-tahun_titipan, #form-tanggal_titipan"
  ).hide();

  //form

  $('#nama_lk_display').on('input', function () {
    let selectedValue = $(this).val();

    let selectedOption = $('#lk_options option[value="' + selectedValue + '"]');

    let selectedId = selectedOption.attr('id');

    console.log('ID Lembaga Konservasi:', selectedId);

    

});

  $("input[name='satwa_koleksi']").on("change", function () {
    let selectedValue = $(this).val();
    //reset sessionStorage
    for (let i = sessionStorage.length - 1; i >= 0; i--) {
      let key = sessionStorage.key(i);  // Mendapatkan nama kunci
      if (key !== 'data' && key !== 'id_lk') {  // Mengecualikan 'data'
          sessionStorage.removeItem(key);  // Menghapus item yang tidak termasuk 'data'
      }
  }

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
      let isHidup = selectedValue.toLowerCase() === "hidup";
      let isTitipan = selectedValue.toLowerCase() === "satwa titipan";

      if (isHidup) {
          $("#form-jenis_koleksi").show();
      }
      if (isTitipan) {
          $("#form-no_ba_titipan").show();
          $("#form-tanggal_titipan").show();
      }
  });

  $("#form-jenis_koleksi input[type='radio']").on("change", function () {
      let selectedValue = $(this).val();

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

      let selectKoleksi = $(this).val().toLowerCase();
      if (selectKoleksi === "satwa koleksi") {
          $("#form-perolehan").show();
          $("#form-asal_satwa").show();
      } else {
          $("#form-asal_satwa").show();
      }

      let selectTitipan = $(this).val();

      if (selectTitipan.toLowerCase() === "satwa titipan") {
          $("#form-no_ba_titipan").show();
          $("#form-tanggal_titipan").show();
      } else {
          $("#form-no_ba_titipan").hide();
          $("#form-tanggal_titipan").hide();
      }
  });

  $("input[name='asal_satwa']").on("change", function () {
      let selectedValue = $(this).val();

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

  $('#perolehan').on('input', function () {
    let perolehanValue = $(this).val();  // Mengambil nilai dari input
});

  $("input[name='confirm_no_sats-ln']").on("change", function () {

    $("#form-no_sats-ln").toggle($(this).val().toLowerCase() === "ya");
    
    $('#no_sats-ln').on('input', function () {
      let inputValue = $(this).val();
    });    
  });

  $("input[name='status_perlindungan']").on("change", function () {
      let selectedValue = $(this).val();

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
      let selectedValue = $(this).val();
    // 

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
      let selectedValue = $(this).val();

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
      let selectedValue = $(this).val();

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
      let selectedValue = $(this).val();

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

  $(function () {
      "use strict";

      const formsToHide = [
          "#form-alasan_belum_tagging",
          "#form-jenis_tagging",
          "#form-kode_tagging",
          "#form-ba_tagging",
          "#form-no_ba_kematian",
          "#form-no_ba_kelahiran",
      ];

      // Initial hide for all forms
      formsToHide.forEach((form) => $(form).hide());

      $("input[name='perilaku_satwa']").on("change", function () {
          resetForms([
              "#form-jenis_kelamin",
              "#form-confirm_tagging",
              "#form-nama_satwa_ina",
              "#form-nama_panggilan",
              "#ListSpecies_hewan",
          ]);

          if ($(this).val() === "1") {
              showForms([
                  "#form-jenis_kelamin",
                  "#form-confirm_tagging",
                  "#form-nama_satwa_ina",
                  "#form-nama_panggilan",
                  "#ListSpecies_hewan",
              ]);
          }
      });

      $("input[name='confirm_tagging']").on("change", function () {
          resetForms([
              "#form-jenis_tagging",
              "#form-ba_tagging",
              "#form-tanggal_tagging",
              "#form-no_ba_kelahiran",
              "#form-no_ba_kematian",
              "#form-validasi_tanggal",
              "#form-keterangan",
              "#form-alasan_belum_tagging",
          ]);

          if ($(this).val().toLowerCase() === "ya") {
              showForms([
                  "#form-jenis_tagging",
                  "#form-kode_tagging",
                  "#form-ba_tagging",
                  "#form-tanggal_tagging",
                  "#form-no_ba_kelahiran",
                  "#form-validasi_tanggal",
                  "#form-keterangan",
              ]);
          } else {
              showForms([
                  "#form-no_ba_kelahiran",
                  "#form-no_ba_kematian",
                  "#form-validasi_tanggal",
                  "#form-alasan_belum_tagging",
                  "#form-keterangan",
              ]);
          }
      });

      $("input[name='status_satwa']").on("change", function () {
          resetForms(["#form-no_ba_kelahiran", "#form-no_ba_kematian"]);

          if ($(this).val().toLowerCase() === "ya") {
              showForms(["#form-no_ba_kelahiran"]);
          } else {
              showForms(["#form-no_ba_kematian"]);
          }
      });

      function resetForms(formIds) {
          formIds.forEach((formId) => {
              $(formId)
                  .find("input, select, textarea")
                  .each(function () {
                      $(this).val("").prop("checked", false);
                  });
              $(formId).hide();
          });
      }

      function showForms(formIds) {
          formIds.forEach((formId) => {
              $(formId).show();
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

  // var forms = document.querySelectorAll("[id^='stage']");

  // forms.forEach(function (form) {
  //     form.addEventListener("submit", function (event) {
  //         event.preventDefault();
  //         var formId = form.id;
  //         var url = form.action;
  //         var formData = new FormData(form);
  //         const token = document
  //             .querySelector('meta[name="csrf-token"]')
  //             .getAttribute("content");

  //         document.getElementById("validation-errors").innerHTML = "";

  //         if (!form.checkValidity()) {
  //             form.reportValidity();
  //             return;
  //         }

  //         fetch(url, {
  //             method: "POST",
  //             body: formData,
  //             headers: {
  //                 "X-CSRF-TOKEN": token,
  //             },
  //         })
  //             .then((response) => {
  //                 if (!response.ok) {
  //                     return response.json().then((errorData) => {
  //                         displayValidationErrors(errorData.errors);
  //                         throw new Error("Validation failed");
  //                     });
  //                 }

  //                 return response.json();
  //             })
  //             .then((data) => {
  //                 if (data.success) {
  //                     transitionStage(formId);
  //                 }
  //             })
  //             .catch((error) => {
  //                 console.error("Error:", error);
  //             });
  //     });
  // });

  // function displayValidationErrors(errors) {
  //     let errorsContainer = document.getElementById("validation-errors");
  //     let errorsHtml = "";

  //     if (errors) {
  //         errorsHtml +=
  //             '<div class="font-medium text-red-600">Tolong Periksa kembali</div>';
  //         errorsHtml +=
  //             '<ul class="mt-3 list-disc list-inside text-sm text-red-600">';
  //         Object.keys(errors).forEach(function (key) {
  //             errors[key].forEach(function (error) {
  //                 errorsHtml += "<li>" + error + "</li>";
  //             });
  //         });
  //         errorsHtml += "</ul>";
  //     }

  //     errorsContainer.innerHTML = errorsHtml;
  // }

  // function transitionStage(formId) {
  //     switch (formId) {
  //         case "stage1":
  //             stage1to2();
  //             break;
  //         case "stage2":
  //             window.location.href = "/";
  //             break;
  //         default:
  //             console.log(
  //                 "No such stage exists or no transition function is defined."
  //             );
  //             break;
  //     }
  // }

  // toggleConditionalForms();
  // function toggleConditionalForms() {
  //     $("input[name='perilaku_satwa']").trigger("change");
  //     $("input[name='confirm_tagging']").trigger("change");
  // }
});
