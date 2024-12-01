$(function () {
    'use strict'

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
        cardBg: "#fff"
    }

    var fontFamily = "'Roboto', Helvetica, sans-serif"

    // Simpan instance grafik untuk setiap chart
    var charts = {};

    // Fungsi untuk memperbarui seluruh grafik
    function updateCharts() {
        updateJenisLKChart();
        updateWilayahLKChart();
        updateSpesiesIndvChart();
        updateTaggingChart();
        updateKelasSatwaChart();
        updateSatwaKoleksiChart();
    }

    // Update untuk Grafik Jenis LK
    function updateJenisLKChart() {
        const dataContainer = $('#jenisLKChart');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];
        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label);
                totals.push(dataObj[label]);
            }
        }

        // Jika grafik sudah ada, destroy dan buat ulang
        if (charts.jenisLKChart) {
            charts.jenisLKChart.destroy();
        }

        var options = {
            chart: {
                type: "bar",
                height: 400,
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        const selectedLabel = config.w.config.xaxis.categories[config.dataPointIndex];
                        alert(`You clicked on: ${selectedLabel}`);
                        console.log(`Clicked on bar chart data:`, selectedLabel);
                    }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: '60%',
                    barSpacing: 50
                }
            },
            series: [{
                name: "Jumlah Lembaga",
                data: totals, // Pastikan `totals` adalah array yang berisi data
            }],
            xaxis: {
                categories: labels, // Pastikan `labels` adalah array yang berisi label
            },
            colors: ["#008FFB", "#00E396", "#FEB019"],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " lembaga";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#jenisLKChart"), options);

        chart.render();
        charts.jenisLKChart = chart; // Simpan instansi grafik
    }

    // Update untuk Grafik Wilayah LK
    function updateWilayahLKChart() {
        const dataContainer = $('#wilayahLKChart');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];
        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label);
                totals.push(dataObj[label]);
            }
        }

        // Jika grafik sudah ada, destroy dan buat ulang
        if (charts.wilayahLKChart) {
            charts.wilayahLKChart.destroy();
        }

        var chart = new ApexCharts(document.querySelector("#wilayahLKChart"), {
                chart: {
                    type: "bar",
                    height: 400,
                    events: {
                        dataPointSelection: function (event, chartContext, config) {
                            const selectedLabel = config.w.config.xaxis.categories[config.dataPointIndex];
                            alert(`You clicked on: ${selectedLabel}`);
                            console.log(`Clicked on bar chart data:`, selectedLabel);
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: '60%',
                        barSpacing: 50
                    }
                },
                series: [{
                    name: "Jumlah Lembaga",
                    data: totals,
                }],
                xaxis: {
                    categories: labels,
                },
                colors: [ "#008FFB", "#00E396", "#FEB019"],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " lembaga";
                        }
                    }
                }
        });

        chart.render();
        charts.wilayahLKChart = chart; // Simpan instansi grafik
    }

    // Update untuk Grafik Spesies Individu
    function updateSpesiesIndvChart() {
        const dataContainer = $('#spesiesIndvChart');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];
        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label);
                totals.push(dataObj[label]);
            }
        }

        // Jika grafik sudah ada, destroy dan buat ulang
        if (charts.spesiesIndvChart) {
            charts.spesiesIndvChart.destroy();
        }

        var chart = new ApexCharts(document.querySelector("#spesiesIndvChart"), {
            chart: {
                type: 'pie',
            },
            series: totals,
            labels: labels,
            colors: ["#008FFB", "#00E396", "#FEB019"]
        });

        chart.render();
        charts.spesiesIndvChart = chart; // Simpan instansi grafik
    }

    // Update untuk Grafik Tagging
    function updateTaggingChart() {
        const dataContainer = $('#chartContainer2');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];
        let colors = [];

        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label);
                totals.push(dataObj[label]);
                colors.push(generateRandomColor());
            }
        }

        // Jika grafik sudah ada, destroy dan buat ulang
        if (charts.taggingChart) {
            charts.taggingChart.destroy();
        }

        var chart = new ApexCharts(document.querySelector("#chartContainer2"), {
            chart: {
                type: 'pie',
            },
            series: totals,
            labels: labels,
            colors: colors
        });

        chart.render();
        charts.taggingChart = chart; // Simpan instansi grafik
    }

    // Update untuk Grafik Kelas Satwa
    function updateKelasSatwaChart() {
        const dataContainer = $('#chartContainer1');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];
        let colors = [];

        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label);
                totals.push(dataObj[label]);
                colors.push(generateRandomColor());
            }
        }

        // Jika grafik sudah ada, destroy dan buat ulang
        if (charts.kelasSatwaChart) {
            charts.kelasSatwaChart.destroy();
        }

        var chart = new ApexCharts(document.querySelector("#chartContainer1"), {
            chart: {
                type: 'pie',
            },
            series: totals,
            labels: labels,
            colors: colors
        });

        chart.render();
        charts.kelasSatwaChart = chart; // Simpan instansi grafik
    }

    // Update untuk Grafik Satwa Koleksi
    function updateSatwaKoleksiChart() {
        const dataContainer = $('#chartContainer3');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];
        let colors = [];

        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label);
                totals.push(dataObj[label]);
                colors.push(generateRandomColor());
            }
        }

        // Jika grafik sudah ada, destroy dan buat ulang
        if (charts.satwaKoleksiChart) {
            charts.satwaKoleksiChart.destroy();
        }

        var chart = new ApexCharts(document.querySelector("#chartContainer3"), {
            chart: {
                type: 'pie',
            },
            series: totals,
            labels: labels,
            colors: colors
        });

        chart.render();
        charts.satwaKoleksiChart = chart; // Simpan instansi grafik
    }

    // Fungsi untuk menghasilkan warna acak untuk pie chart
    function generateRandomColor() {
        let maxVal = 0xFFFFFF;
        let randomNumber = Math.random() * maxVal;
        randomNumber = Math.floor(randomNumber);
        randomNumber = randomNumber.toString(16);
        let randColor = randomNumber.padStart(6, 0);
        return `#${randColor.toUpperCase()}`
    }

    // Memanggil fungsi updateCharts untuk memperbarui semua grafik
    updateCharts();
});
