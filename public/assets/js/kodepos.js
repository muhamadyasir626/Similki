document.getElementById("kodepos").addEventListener("input", debounce(searchPostalCode, 1000));
var selectedKelurahan = document.getElementById("kelurahan").getAttribute("data-selected");

window.addEventListener('DOMContentLoaded', function() {
    var postalCode = document.getElementById("kodepos").value;
    if (postalCode) {
        searchPostalCode();
    }

    document.getElementById("kelurahan").addEventListener("change", checkSelectedOption);
});

function searchPostalCode() {
    var postalCode = document.getElementById("kodepos").value;

    if (postalCode.length === 5) {
        fetch(`/api/search?postalCode=${postalCode}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.data && data.data.length > 0) {
                    var locationData = data.data[0];

                    document.getElementById("provinsi").value = locationData.province || "";
                    document.getElementById("kota_kab").value = locationData.regency || "";
                    document.getElementById("kecamatan").value = locationData.district || "";
                    
                    clearKelurahanDropdown();
                    
                    data.data.forEach(village => {
                        addKelurahanOption(village.village);
                    });
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
    document.getElementById("kota_kab").value = "";
    document.getElementById("kecamatan").value = "";
    clearKelurahanDropdown();
}

function clearKelurahanDropdown() {
    var select = document.getElementById("kelurahan");
    select.innerHTML = '<option value="" hidden>Pilih Kelurahan/Desa</option>';
}

function addKelurahanOption(kelurahanName) {
    var select = document.getElementById("kelurahan");
    var option = document.createElement("option");
    option.value = kelurahanName;
    option.textContent = kelurahanName;

    if (kelurahanName === "Some Selected Village") {
        option.setAttribute("data-selected", "true");
    }

    select.appendChild(option);
    selectOptionByValue(selectedKelurahan);


}

function checkSelectedOption() {
    var select = document.getElementById("kelurahan");
    var selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption && selectedOption.getAttribute("data-selected") === "true") {
        console.log("Opsi dengan data-selected dipilih:", selectedOption.textContent);
    }
}

function selectOptionByValue(selectedKelurahan) {
    var select = document.getElementById("kelurahan");
    var options = select.options;

    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        if (option.value === selectedKelurahan) {
            option.selected = true;
            break;
        }
    }
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
