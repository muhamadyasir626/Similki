let deleteId = null; // Variable to store the ID of the item to be deleted
let id_lk = null;
var status_updated = null;
function openPopup(details) {
    let pks = details.PKS.split(/(?=\d\. )/); // Memecah string PKS berdasarkan digit yang diikuti oleh titik dan spasi
    
    document.getElementById('nama').value = details.Nama;
    document.getElementById('upt').value = details.UPT;
    document.getElementById('bentuk_lembaga').value = details['Bentuk Lembaga'];
    document.getElementById('nama_pimpinan').value = details['Nama Pimpinan'];
    document.getElementById('akreditasi').value = details.Akreditasi;
    document.getElementById('badges-akreditasi').textContent = details.Akreditasi;
    document.getElementById('tahun_akred').value = details['tahun akred'];
    document.getElementById('tahun_izin').value =  details['Tahun Izin'];
    document.getElementById('pengelola').value = details.pengelola;
    document.getElementById('alamat').value = details.Alamat;
    document.getElementById('link_sk').href = details.SK;
    document.getElementById('link_sk').textContent = details.Nama;
    document.getElementById('input_sk').value = details.SK;
    document.getElementById('legalitas_perizinan').value = details['Legalitas Perizinan'];
    document.getElementById('nomor_tanggal_surat').value = details['Nomor Tanggal Surat'];
    document.getElementById('izin_tsl').value = details['Izin TSL'];
    document.getElementById('pks').value = pks.join("\n");
    
    let akreditasiElement = document.getElementById('badges-akreditasi');
    akreditasiElement.classList.remove('badge','badge-success', 'badge-info', 'badge-warning', 'badge-secondary');
    switch(details.Akreditasi) {
        case 'A':
            akreditasiElement.classList.add('badge', 'bg-success'); // Green for "A"
            break;
        case 'B':
            akreditasiElement.classList.add('badge', 'bg-info'); // Yellow for "B"
            break;
        case 'C':
            akreditasiElement.classList.add('badge', 'bg-warning'); // Red for "C"
            break;
        case '-':
            akreditasiElement.classList.add('badge', 'bg-secondary'); // Gray for others
            break;
    }

    document.getElementById("detailPopup").style.display = "flex";
}

function closePopup() {
    document.getElementById("detailPopup").style.display = "none";
    // console.log('status updated',status_updated);
    if (status_updated === 'success') {
        window.location.reload();
    } 
}


function confirmDelete(button) {
    deleteId = button.getAttribute("data-id"); 
    document.getElementById("deletePopup").style.display = "block";
}

function closeDeletePopup() {
    document.getElementById("deletePopup").style.display = "none"; 
}

// Event listener for detail buttons
document.querySelectorAll(".detail-button").forEach((button) => {
    button.addEventListener("click", function () {
        const detail = {
            id:this.getAttribute('id'),
            Nama:  this.getAttribute("data-nama"),
            UPT: this.getAttribute("data-upt"),
            "Bentuk Lembaga": this.getAttribute("data-bentuk"),
            "Nama Pimpinan": this.getAttribute("data-nama_pimpinan"),
            Akreditasi: this.getAttribute("data-akreditasi"),
            "Tahun Izin": this.getAttribute("data-tahun"),
            "tahun akred": this.getAttribute("data-tahun_akred"),
            pengelola:this.getAttribute("data-pengelola"),
            Alamat: this.getAttribute("data-alamat"),
            SK: this.getAttribute("data-link_sk"),
            "Legalitas Perizinan": this.getAttribute("data-legalitas_perizinan"),
            "Nomor Tanggal Surat": this.getAttribute("data-nomor_tanggal_surat"),
            "PKS": this.getAttribute("data-pks_dengan_lk_lainnya"),
            "Izin TSL": this.getAttribute("data-izin_perolehan_tsl"),
        };
        id_lk = detail.id;
        openPopup(detail);
    });
});



document
    .getElementById("confirmDeleteButton")
    .addEventListener("click", function () {
        if (deleteId) {
            fetch(`/lembaga-konservasi/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", 
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    // alert("Data berhasil dihapus!"); 
                    showNotification(data.message,data.status)

                    window.location.reload();
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menghapus data.");
                });

            closeDeletePopup();
        }
    });


    function openEditForm() {
        console.log('Membuka form edit...');
        document.getElementById('edit-button').style.display = "none";
        document.getElementById('close-button').style.display = "none";
        document.getElementById('submit-button').style.display = "block";
        document.getElementById('cancel-button').style.display = "block";
        
        var fields = [
            'nama', 'upt', 'bentuk_lembaga', 'nama_pimpinan', 'akreditasi', 'tahun_izin','tahun_akred','pengelola',
            'alamat', 'input_sk', 'legalitas_perizinan', 'nomor_tanggal_surat', 'izin_tsl', 'pks'
        ];
        
        fields.forEach(function(fieldId) {
            var field = document.getElementById(fieldId);
            if (field) {
                field.removeAttribute('disabled');
                field.dataset.originalValue = field.value; 
                field.style.border = "1px solid black";
            }
        });
    
        document.getElementById('badges-akreditasi').style.display = 'none';
        document.getElementById('link_sk').style.display = 'none';
        document.getElementById('input_sk').style.display = "flex";
        document.getElementById('akreditasi').style.display = "flex";
    }
    

function toggleElementVisibility(ids, visible) {
    ids.forEach(id => {
        document.getElementById(id).style.display = visible ? 'block' : 'none';
    });
}

function enableField(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    field.removeAttribute('disabled');
    field.style.border = "1px solid black";
    field.style.display = "flex";
}


function cancelEditForm() {
    console.log('Membatalkan perubahan form edit...');

    document.getElementById('edit-button').style.display = "block";
    document.getElementById('close-button').style.display = "block";
    document.getElementById('submit-button').style.display = "none";
    document.getElementById('cancel-button').style.display = "none";
    
    var fields = [
        'nama', 'upt', 'bentuk_lembaga', 'nama_pimpinan', 'akreditasi', 'tahun_izin','tahun_akred','pengelola',
        'alamat', 'input_sk', 'legalitas_perizinan', 'nomor_tanggal_surat', 'izin_tsl', 'pks'
    ];
    
    fields.forEach(function(fieldId) {
        var field = document.getElementById(fieldId);
        if (field) {
            field.value = field.dataset.originalValue; // Mengembalikan nilai asli
            field.setAttribute('disabled', 'disabled');
            field.style.border = "none";
        }
    });

    document.getElementById('badges-akreditasi').style.display = 'block';
    document.getElementById('link_sk').style.display = 'block';
    document.getElementById('input_sk').style.display = "none";
    document.getElementById('akreditasi').style.display = "none";
}


    
function submitForm() {
    const csrfToken = document.querySelector('meta[name="_token"]').getAttribute('content');
    const token = localStorage.getItem('auth_token');
    const data = {
        nama: document.getElementById('nama').value,
        upt: document.getElementById('upt').value,
        bentuk_lk: document.getElementById('bentuk_lembaga').value,
        nama_pimpinan: document.getElementById('nama_pimpinan').value,
        nilai_akred: document.getElementById('akreditasi').value,
        tahun_akred: document.getElementById('tahun_akred').value,
        tahun_izin: document.getElementById('tahun_izin').value,
        pengelola: document.getElementById('pengelola').value,
        alamat: document.getElementById('alamat').value,
        link_sk:document.getElementById('link_sk').href,
        legalitas_perizinan: document.getElementById('legalitas_perizinan').value,
        nomor_tanggal_surat: document.getElementById('nomor_tanggal_surat').value,
        izin_perolehan_tsl: document.getElementById('izin_tsl').value,
        pks_dengan_lk_lainnya: document.getElementById('pks').value,
    };

    console.log(data);

    const url = `/lembaga-konservasi/${id_lk}`;

    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json().then(data => {
                    throw new Error('Error: ' + (data.errors     || response.error));
                });
            } else {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
        }
        return response.json();
    })    
    .then(responseData => {
        console.log('Success:', responseData.wilayah);
        // Disable all inputs
        document.querySelectorAll('#popupContent input, #popupContent textarea').forEach(input => {
            input.disabled = true;
        });
    
        // Update displayed values
        document.getElementById('nama').value = responseData.data.nama;
        document.getElementById('upt').value = responseData.wilayah;
        document.getElementById('bentuk_lembaga').value = responseData.data.bentuk_lk;
        document.getElementById('nama_pimpinan').value = responseData.data.nama_pimpinan;
        document.getElementById('akreditasi').value = responseData.data.nilai_akred;
        document.getElementById('tahun_akred').value = responseData.data.tahun_akred;
        document.getElementById('tahun_izin').value = responseData.data.tahun_izin;
        document.getElementById('pengelola').value = responseData.data.pengelola;
        document.getElementById('alamat').value = responseData.data.alamat;
        document.getElementById('link_sk').href = responseData.data.link_sk;
        document.getElementById('legalitas_perizinan').value = responseData.data.legalitas_perizinan;
        document.getElementById('nomor_tanggal_surat').value = responseData.data.nomor_tanggal_surat;
        document.getElementById('izin_tsl').value = responseData.data.izin_perolehan_tsl;
        document.getElementById('pks').value = responseData.data.pks_dengan_lk_lainnya;
    
        showNotification(responseData.message,responseData.status)
        updateButtonStates();
    })
    .catch(error => {
        console.error('Error:', error);
    });

}

function updateButtonStates() {
    document.getElementById('edit-button').style.display = "block";
    document.getElementById('close-button').style.display = "block";
    document.getElementById('submit-button').style.display = "none";
    document.getElementById('cancel-button').style.display = "none";
    
    var fields = [
        'nama', 'upt', 'bentuk_lembaga', 'nama_pimpinan', 'akreditasi', 'tahun_izin','tahun_akred','pengelola',
        'alamat', 'input_sk', 'legalitas_perizinan', 'nomor_tanggal_surat', 'izin_tsl', 'pks'
    ];
    
    fields.forEach(function(fieldId) {
        var field = document.getElementById(fieldId);
        if (field) {
            field.setAttribute('disabled', 'disabled');
            field.style.border = "none";
        }
    });
    status_updated = 'success';
}

document.addEventListener('DOMContentLoaded', function() {
    loadNotification();
});
