$(function () {
    
    // Initialize wizard
    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,

        // Custom submit button for the final step
        onFinished: function (event, currentIndex) {
            let verification = validateForm()

            if (verification.isValid) {
                event.preventDefault();

                savegenealogy();

            } else {
                console.log('gagal')        
                $('#error-messages').empty();

                // Display each error message in the list
                verification.errors.forEach(function (error) {
                    $('#error-messages').append('<div class="error-item">' + '<li>' + error + '</li>' + '</div>');
                });
                
                $('#error-container').show();
            }
        },
    });
    
    // Initially show necessary sections
    $('#form-namaIbu, #form-namaAyah, #form-namaSatwa, #form-status').show();
    $('#form-punya-anak, #form-dipisahkan, #form-pasangan, #form-tanggal-dipasangkan, #form-tanggal-dipisahkan, #form-alasan-pisah').hide();

    // Show the form-pasangan field when "Sudah" is selected
    $('#form-punya-pasangan input[name="status"]').on('change', function () {
        var status = $("input[name='status']:checked").val(); // Get selected value
        console.log("Status selected:", status);  // Debugging log

        if (status === 'sudah') {
            $('#form-pasangan, #form-tanggal-dipasangkan, #form-punya-anak').show();
        } else {
            $('#form-pasangan, #form-tanggal-dipasangkan, #form-tanggal-dipisahkan, #form-punya-anak').hide();
        }
    });

    // Show the form-anak field when "Sudah" is selected
    $('#form-punya-anak input[name="punya_anak"]').on('change', function () {
        var punya_anak = $("input[name='punya_anak']:checked").val();
        // console.log("Punya Anak selected:", punya_anak);  // Debugging log

        if (punya_anak === 'ya') {
            $('#form-anak, #form-dipisahkan').show();
        } else {
            $('#form-anak').hide();
        }
    });

    // Show the form-dipisahkan field when "Sudah" is selected
    $('#form-dipisahkan input[name="dipisahkan"]').on('change', function () {
        var dipisahkan = $("input[name='dipisahkan']:checked").val();
        console.log("Dipisahkan selected:", dipisahkan);  // Debugging log

        if (dipisahkan === 'sudah') {
            $('#form-tanggal-dipisahkan, #form-alasan-pisah').show();
        } else {
            $('#form-tanggal-dipisahkan, #form-alasan-pisah').hide();
        }
    });

    // Function to validate form fields
    function validateForm() {
        let isValid = true;
        var errors = [];  // Array to store error messages

        // Validate 'form-namaSatwa' field
        var namaSatwaVal = $('#namaSatwa').val();
        if (!namaSatwaVal) {
            errors.push("Isi nama Satwa terlebih dahulu!");
            isValid = false;
        }

        // Validate 'form-namaIbu' field
        var namaIbuVal = $('#namaIbu').val();
        if (!namaIbuVal) {
            errors.push("Tolong isi Ibu dari satwa dahulu!");
            isValid = false;
        }

        // Validate 'form-namaAyah' field
        var namaAyahVal = $('#namaAyah').val();
        if (!namaAyahVal) {
            errors.push("Tolong isi Ayah dari satwa dahulu!");
            isValid = false;
        }

        // Validate 'form-status' field (Radio button validation)
        var statusVal = $("input[name='status']:checked").val();  // Mengambil nilai radio button yang dipilih
        console.log("Status terpilih:", statusVal);  // Debugging log untuk melihat nilai
        if (!statusVal) {
            errors.push("Isi status satwa!");  // Jika tidak ada pilihan, tambahkan pesan kesalahan
            isValid = false;
        }

        // Validate if 'pasangan' field is filled when form-pasangan is visible
        if ($('#form-pasangan').is(":visible")) {
            var pasanganVal = $('#pasangan').val();
            if (!pasanganVal) {
                errors.push("Tolong pilih pasangan satwa!");
                isValid = false;
            }
        }

          // Validate if 'tanggal dipasangkan' field is filled when form-tanggal-dipasangkan is visible
        if ($('#form-tanggal-dipasangkan').is(":visible")) {
            var tanggalDipasangkanVal = $('#tanggal_dipasangkan').val();
            if (!tanggalDipasangkanVal) {
                errors.push("Tolong pilih tanggal dipasangkan!");
                isValid = false;
            }
        }

        if ($('#form-punya-anak').is(":visible")) {
            var statusPunyaAnak = $("input[name='punya_anak']:checked").val();  // Get selected radio button value
            if (!statusPunyaAnak) {
                errors.push("Tolong isi apakah satwa memiliki anak!");  // Add error if no option selected
                isValid = false;
            } 
        }

        // Validate if 'anak' field is filled when form-anak is visible
        if ($('#form-anak').is(":visible")) {
            var anakVal = $('#anak').val();
            if (!anakVal) {
                errors.push("Tolong pilih anak satwa!");
                isValid = false;
            }
        }

        // Validate if 'tanggal dipisahkan' field is filled when form-tanggal-dipasahkan is visible
        if ($('#form-tanggal-dipasahkan').is(":visible")) {
            var tanggalDipisahkanVal = $('#tanggal_dipasahkan').val();
            if (!tanggalDipisahkanVal) {
                errors.push("Tolong pilih tanggal dipisahkan!");
                isValid = false;
            }
        }

        if ($('form-alasan-pisah').is(':visible')) {
            var alasanDipisahkanVal = $('#alasan').val();
            if (!alasanDipisahkanVal) {
                errors.push("Tolong isi alasan kenapa dipisahkan!");
            }
        }
        

        return {isValid, errors};
    }

    function savegenealogy(){
        const token = localStorage.getItem('auth_token');

        const formData = {
            id_satwa: $('#namaSatwa').val(),
            id_jenis_kelamin: $('#namaSatwa option:selected').attr('jenis_kelamin'),
            id_ibu: $('#namaIbu').val(),
            id_ayah: $('#namaAyah').val(),
            status: $("input[name='status']:checked").val(),
            id_pasangan: $('#pasangan').val(),
            tanggalDipasangkan: $('#tanggal_dipasangkan').val(),
            punyaAnak: $("input[name='punya_anak']:checked").val(),
            id_anak: $('#anak').val(),
            tanggalDipisahkan: $('#tanggal_dipasahkan').val(),
            alasanDipisah: $('#alasan').val(),
        }
        
        $.ajax({
            url: `/api/store-genealogy`,
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            data: formData,
            success: function (response) {
                console.log(response.success);
                showNotification(response.message, response.success);

            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
        
    }
});








$(document).ready(function() {
    // Fungsi untuk mengupdate dropdown dan menghapus pilihan yang sudah dipilih
    function updateSelectOptions() {
        var selectedIds = [];
        var selectedIdSpesies = $('#namaSatwa').find('option:selected').attr('id_spesies'); // Ambil id_spesies dari namaSatwa

        // Ambil semua elemen select yang terlibat
        $('select').each(function() {
            var selectedOption = $(this).val();
            if (selectedOption) {
                selectedIds.push(selectedOption);
            }
        });

        // Looping melalui semua elemen select selain #namaSatwa
        $('select').not('#namaSatwa').each(function() {
            $(this).find('option').each(function() {
                var optionValue = $(this).val();
                var optionSpesiesId = $(this).attr('id_spesies'); // Ambil id_spesies dari option

                // Jika option sudah dipilih, sembunyikan di dropdown lain
                if (selectedIds.includes(optionValue) && optionValue !== "") {
                    $(this).prop('hidden', true);
                } else {
                    if (optionSpesiesId === selectedIdSpesies) {
                        $(this).prop('hidden', false); // Menampilkan option jika id_spesies sama
                        // console.log('id spesies', optionSpesiesId)
                    }
                    else {
                        $(this).prop('hidden', true); // Sembunyikan jika id_spesies tidak cocok
                    }
                }

                // Menampilkan option jika id_spesies cocok dengan id_spesies yang dipilih pada namaSatwa
                
            });
        });
    }

    // Fungsi untuk mengosongkan semua input selain #namaSatwa saat #namaSatwa berubah
    function clearOtherInputs() {
        // Clear all selects except #namaSatwa
        $('#namaAyah, #namaIbu, #pasangan, #anak').prop('selected', false);

        // Clear other inputs like text, radio, date
        $('input[type="text"], input[type="radio"], input[type="date"], textarea').prop('checked', false);

        $('#form-pasangan, #form-tanggal-dipasangkan, #form-tanggal-dipisahkan, #form-punya-anak').hide();

        // Clear any visible error messages
        $('.error-message').hide();
    }

    // Update dropdown ketika pilihan berubah
    $('#namaSatwa').on('change', function() {
        updateSelectOptions(); // Update dropdown berdasarkan pilihan #namaSatwa
        clearOtherInputs(); // Clear all inputs when #namaSatwa changes
    });

    // Update dropdown ketika pilihan pada #namaAyah, #namaIbu, #pasangan, atau #anak berubah
    $('#namaAyah, #namaIbu, #pasangan, #anak').on('change', function() {
        updateSelectOptions();
    });

    // Panggil fungsi ini saat halaman pertama kali dimuat untuk memastikan dropdown sesuai dengan id_spesies
    updateSelectOptions();
});


$(document).ready(function () {
    let namaSatwaId;

    // Handle change event on namaSatwa select element
    $('#namaSatwa').change(function() {
        namaSatwaId = $(this).find('option:selected').attr('jenis_kelamin');
        fetchPasangan(); // Call fetchPasangan when namaSatwa changes
    });

    // Handle change event on status radio buttons
    $('#status_sudah, #status_belum').change(function() {
        fetchPasangan(); // Call fetchPasangan when status changes
    });

    // Function to fetch pasangan
    function fetchPasangan() {
        var statusPasangan = $('input[name="status"]:checked').val(); // Get selected status
        const token = localStorage.getItem('auth_token');
    
        // Cek apakah namaSatwaId dan status valid
        if (namaSatwaId && statusPasangan == "sudah") {
            console.log('Fetch Pasangan called with valid status and namaSatwaId');
            
            $.ajax({
                url: '/api/getcouple/' + namaSatwaId,
                type: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token); 
                },
                success: function(data) {
                    // Menampilkan form pasangan
                    $('#form-pasangan').show(); 
                
                    // Mengosongkan opsi sebelumnya di dropdown
                    $('#pasangan').empty(); 
                
                    // Menambahkan opsi default "Pilih Nama Pasangan"
                    $('#pasangan').append('<option value="" disabled selected>Pilih Nama Pasangan</option>');
                
                    // Menampilkan setiap pasangan dari data yang diterima
                    $.each(data.listCouple, function(index, satwa) {
                
                        // Memastikan bahwa satwa.listCouple ada dan memiliki properti yang benar
                        if (satwa) {
                            // Menambahkan option baru ke dropdown
                            $('#pasangan').append('<option value="' + satwa.id + '">' + satwa.nama_panggilan + ' - ' + satwa.species.nama_ilmiah + '</option>');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching pasangan:', error);
                    $('#form-pasangan').hide(); // Menyembunyikan form jika terjadi error
                }
                
            });
        } else {
            console.log('Invalid status or namaSatwaId');
        }
    }
    
});

  