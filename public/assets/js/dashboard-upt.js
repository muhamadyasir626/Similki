$(function () {
    'use strict';

    // Warna dan font global
    var colors = {
        primary: "#6571ff",
        secondary: "#7987a1",
        success: "#05a34a",
        info: "#66d1d1",
        warning: "#fbbc06",
        danger: "#ff3366",
        light: "#e9ecef",
        dark: "#060c17",
        muted: "#7987a1",
        gridBorder: "rgba(77, 138, 240, .15)",
        bodyColor: "#000",
        cardBg: "#fff",
    };

    var fontFamily = "'Roboto', Helvetica, sans-serif";

    // Inisialisasi Date Picker
    if ($('#dashboardDate').length) {
        flatpickr("#dashboardDate", {
            wrap: true,
            dateFormat: "d-M-Y",
            defaultDate: "today",
        });
    }

    // Fungsi untuk mengambil data dari backend
    async function fetchData() {
        try {
            const response = await fetch('get_data.php'); // Pastikan path ke file PHP benar
            const data = await response.json();

            // Data dari backend
            const lembagaData = data.lembaga;
            const satwaData = data.satwa;

            // Grafik 1: Statistik Lembaga Konservasi di bawah UPT
            const optionsLembaga = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                colors: [colors.primary, colors.info],
                series: [
                    {
                        name: 'Jumlah Satwa',
                        data: lembagaData.map(lk => lk.jumlah_satwa)
                    },
                    {
                        name: 'Luas Area (ha)',
                        data: lembagaData.map(lk => lk.luas_area)
                    }
                ],
                xaxis: {
                    categories: lembagaData.map(lk => lk.nama),
                    title: { text: 'Nama Lembaga Konservasi' }
                },
                yaxis: {
                    title: { text: 'Statistik Lembaga' }
                },
                title: {
                    text: 'Monitoring Lembaga Konservasi',
                    align: 'center'
                }
            };

            const chartLembaga = new ApexCharts(document.querySelector("#chart-upt-lembaga"), optionsLembaga);
            chartLembaga.render();

            // Grafik 2: Jumlah Spesies Satwa per Lembaga Konservasi
            const optionsSatwa = {
                chart: {
                    type: 'pie',
                    height: 350
                },
                colors: [colors.success, colors.warning, colors.danger],
                series: satwaData.map(lk => lk.jumlah_spesies),
                labels: satwaData.map(lk => lk.nama),
                title: {
                    text: 'Data Satwa di Lembaga Konservasi',
                    align: 'center'
                }
            };

            const chartSatwa = new ApexCharts(document.querySelector("#chart-satwa-lembaga"), optionsSatwa);
            chartSatwa.render();

        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    // Panggil fungsi fetchData untuk memuat grafik
    fetchData();
});
