// Get Postal Kode
document
    .getElementById("kodepos")
    .addEventListener("input", debounce(searchPostalCode, 1000));

function searchPostalCode() {
    var postalCode = document.getElementById("kodepos").value;

    if (postalCode.length === 5) {
        fetch(`/api/search?postalCode=${postalCode}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.data && data.data.length > 0) {
                    var locationData = data.data[0];

                    document.getElementById("provinsi").value =
                        locationData.province || "";
                    document.getElementById("kota_kab").value =
                        locationData.regency || "";
                    document.getElementById("kecamatan").value =
                        locationData.district || "";
                    document.getElementById("kelurahan").value =
                        locationData.village || "";
                } else {
                    clearLocationFields();
                }
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                clearLocationFields();
            });
    } else {
        clearLocationFields();
    }
}

function clearLocationFields() {
    document.getElementById("provinsi").value = "";
    document.getElementById("kota").value = "";
    document.getElementById("kecamatan").value = "";
    document.getElementById("kelurahan").value = "";
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

let signupConent = document.querySelector(".signup-form-container"),
    stagebtn1b = document.querySelector(".stagebtn1b"),
    stagebtn2a = document.querySelector(".stagebtn2a"),
    stagebtn2b = document.querySelector(".stagebtn2b"),
    stagebtn3a = document.querySelector(".stagebtn3a"),
    stagebtn3b = document.querySelector(".stagebtn3b"),
    signupContent1 = document.querySelector(".stage1-content"),
    signupContent2 = document.querySelector(".stage2-content"),
    signupContent3 = document.querySelector(".stage3-content");

signupContent2.style.display = "none";
signupContent3.style.display = "none";

function stage1to2() {
    signupContent1.style.display = "none";
    signupContent3.style.display = "none";
    signupContent2.style.display = "block";
    document.querySelector(".stageno-1").innerText = "✔";
    document.querySelector(".stageno-1").style.backgroundColor = "#6A994E";
    document.querySelector(".stageno-1").style.color = "#fff";
}
function stage2to1() {
    signupContent1.style.display = "block";
    signupContent3.style.display = "none";
    signupContent2.style.display = "none";
}
function stage2to3() {
    signupContent1.style.display = "none";
    signupContent3.style.display = "block";
    signupContent2.style.display = "none";
    document.querySelector(".stageno-2").innerText = "✔";
    document.querySelector(".stageno-2").style.backgroundColor = "#6A994E";
    document.querySelector(".stageno-2").style.color = "#fff";
}
function stage3to2() {
    signupContent1.style.display = "none";
    signupContent3.style.display = "none";
    signupContent2.style.display = "block";
}

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
            stage2to3();
            break; // Mencegah eksekusi lanjut ke case berikutnya
        case "stage3":
            window.location.href = "/";
            break;
        default:
            console.log(
                "No such stage exists or no transition function is defined."
            );
            break;
    }
}

//update wilayah
document
    .getElementById("bentuk_upt")
    .addEventListener("change", debounce(getWilayahUpt, 100));
function getWilayahUpt() {
    var bentuk_upt = document.getElementById("bentuk_upt").value;
    console.log("value bentuk " + bentuk_upt);

    fetch(`/get-wilayah-upt?bentuk=${bentuk_upt}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Not OK");
            }
            return response.json();
        })
        .then((data) => {
            console.log(data.data);
            if (data.data && data.data.length > 0) {
                updateWilayahDropdown(data.data);
            }
        })
        .catch((error) => {
            console.error("Failed fetch:", error);
        });
}

function updateWilayahDropdown(data) {
    const wilayahDropdown = document.getElementById("wilayah_upt");
    wilayahDropdown.innerHTML =
        '<option value="" hidden>Pilih Wilayah</option>';
    if (data && data.length > 0) {
        data.forEach((item) => {
            wilayahDropdown.innerHTML += `<option value="${item.wilayah}">${item.wilayah}</option>`;
        });
    }
}

// show n hide input
document.getElementById("id_role").addEventListener("change", toggleinput);

function toggleinput() {
    var roleSelect = document.getElementById("id_role");

    // Getting all elements by class returns a collection, handle them as arrays
    var bentuk_upt = document.getElementsByClassName("bentuk_upt");
    var wilayah_upt = document.getElementsByClassName("wilayah_upt");
    var id_lk = document.getElementsByClassName("id_lk");
    var id_spesies = document.getElementsByClassName("id_spesies");

    // Hide all elements in each category
    Array.from(bentuk_upt).forEach((el) => (el.style.display = "none"));
    Array.from(wilayah_upt).forEach((el) => (el.style.display = "none"));
    Array.from(id_lk).forEach((el) => (el.style.display = "none"));
    Array.from(id_spesies).forEach((el) => (el.style.display = "none"));

    var selectedOptionRole =
        roleSelect.options[roleSelect.selectedIndex].id.toLowerCase();
    // console.log(selectedOptionRole);

    switch (selectedOptionRole) {
        case "lk":
        case "drh":
        case "sk":
            Array.from(id_lk).forEach((el) => (el.style.display = "block"));
            // console.log('berhasil');
            break;
        case "upt":
            Array.from(bentuk_upt).forEach(
                (el) => (el.style.display = "block")
            );
            Array.from(wilayah_upt).forEach(
                (el) => (el.style.display = "block")
            );
            break;
        case "sb":
            Array.from(id_spesies).forEach(
                (el) => (el.style.display = "block")
            );
            break;
    }
}

function togglePasswordVisibility(fieldId, imgElement) {
  const field = document.getElementById(fieldId);
  const type = field.getAttribute("type") === "password" ? "text" : "password";
  field.setAttribute("type", type);

  const img = imgElement.querySelector('img');
  if (type === "text") {
      img.src = imgElement.getAttribute('data-show'); 
      img.alt = "show password";
  } else {
      img.src = imgElement.getAttribute('data-hide');
      img.alt = "hide password";
  }
}