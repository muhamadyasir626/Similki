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

    // Date Picker
    if ($('#dashboardDate').length) {
        flatpickr("#dashboardDate", {
            wrap: true,
            dateFormat: "d-M-Y",
            defaultDate: "today",
        });
    }

    //bentuk lk
    $(document).ready(function () {
        const dataContainer = $('#jenisLKChart');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];

        //label
        // for (let key in dataObj) {
        //     if (dataObj.hasOwnProperty(key)) {
        //         labels.push(dataObj[key].label); 
        //         totals.push(dataObj[key].total); 
        //     }
        // }

        //total
        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label); 
                totals.push(dataObj[label]); 
            }
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
        };
    
        new ApexCharts(document.querySelector("#jenisLKChart"), options).render();
    });

    //wilayah lk
    $(document).ready(function () {
        const dataContainer = $('#wilayahLKChart');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));

        let labels = [];
        let totals = [];

        //label
        // for (let key in dataObj) {
        //     if (dataObj.hasOwnProperty(key)) {
        //         labels.push(dataObj[key].label); 
        //         totals.push(dataObj[key].total); 
        //     }
        // }

        //total
        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label); 
                totals.push(dataObj[label]); 
            }
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
        };
    
        new ApexCharts(document.querySelector("#wilayahLKChart"), options).render();
    });

    //jumlah individu spesies
    $(document).ready(function () {
        const dataContainer = $('#spesiesIndvChart');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));
        console.log(dataObj);

        let labels = [];
        let totals = [];

        //label
        // for (let key in dataObj) {
        //     if (dataObj.hasOwnProperty(key)) {
        //         labels.push(dataObj[key].label); 
        //         totals.push(dataObj[key].total); 
        //     }
        // }

        //total
        for (let label in dataObj) {
            if (dataObj.hasOwnProperty(label)) {
                labels.push(label); 
                totals.push(dataObj[label]); 
            }
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
                    columnWidth: '100%',
                    barSpacing: 100
                }
            },
            series: [{
                name: "Jumlah satwa",
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
        };
    
        new ApexCharts(document.querySelector("#spesiesIndvChart"), options).render();
    });

     //jumlah tagging
    $(document).ready(function () {
        const dataContainer = $('#chartContainer2');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));
        console.log(dataObj);
    
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
    
        var options = {
            chart: {
                type: "pie",
                height: 400,
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        const selectedLabel = labels[config.dataPointIndex];
                        alert(`You clicked on: ${selectedLabel}`);
                        console.log(`Clicked on pie chart data:`, selectedLabel);
                    }
                }
            },
            series: totals,
            labels: labels,
            colors: colors, 
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " satwa";
                    }
                }
            }
        };
    
        new ApexCharts(document.querySelector("#chartContainer2"), options).render();
    });

     //jumlah tagging & kelas satwa
    $(document).ready(function () {
        const dataContainer = $('#chartContainer1');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));
        console.log(dataObj);
    
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
    
        var options = {
            chart: {
                type: "pie",
                height: 400,
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        const selectedLabel = labels[config.dataPointIndex];
                        alert(`You clicked on: ${selectedLabel}`);
                        console.log(`Clicked on pie chart data:`, selectedLabel);
                    }
                }
            },
            series: totals,
            labels: labels,
            colors: colors, 
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " satwa";
                    }
                }
            }
        };
    
        new ApexCharts(document.querySelector("#chartContainer1"), options).render();
    });

    //jumlah satwa koleksi
    $(document).ready(function () {
        const dataContainer = $('#chartContainer3');
        const dataObj = JSON.parse(dataContainer.attr('data-counts'));
        console.log(dataObj);
    
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
    
        var options = {
            chart: {
                type: "pie",
                height: 400,
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        const selectedLabel = labels[config.dataPointIndex];
                        alert(`You clicked on: ${selectedLabel}`);
                        console.log(`Clicked on pie chart data:`, selectedLabel);
                    }
                }
            },
            series: totals,
            labels: labels,
            colors: colors, 
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " satwa";
                    }
                }
            }
        };
    
        new ApexCharts(document.querySelector("#chartContainer3"), options).render();
    });

    function generateRandomColor() {
        let maxVal = 0xFFFFFF; 
        let randomNumber = Math.random() * maxVal; 
        randomNumber = Math.floor(randomNumber);
        randomNumber = randomNumber.toString(16);
        let randColor = randomNumber.padStart(6, 0);   
        return `#${randColor.toUpperCase()}`
    }      
    // dashboard.js

    $(document).ready(function () {
        $('#classFilter').change(function () {
            const selectedClass = $(this).val(); // Mendapatkan kelas yang dipilih
            filterDataByClass(selectedClass);
        });
    
        function filterDataByClass(selectedClass) {
            const dataContainer = $('#jenisLKChart');
            let dataObj = JSON.parse(dataContainer.attr('data-counts'));
        
            if (selectedClass) {
                dataObj = Object.keys(dataObj).filter(key => dataObj[key].kelas === selectedClass)
                    .reduce((obj, key) => {
                        obj[key] = dataObj[key].jumlah; // Ambil jumlah yang relevan
                        return obj;
                    }, {});
            }
        
            updateCharts(dataObj); // Update semua grafik
        }
    
        function updateCharts(dataObj) {
            // Update grafik jenis LK
            updateChart('jenisLKChart', dataObj);
            
            // Update grafik wilayah LK
            updateChart('wilayahLKChart', dataObj);
            
            // Update grafik jumlah individu spesies
            updateChart('spesiesIndvChart', dataObj);
            
            // Update grafik jumlah tagging
            updateChart('chartContainer2', dataObj);
            
            // Update grafik jumlah tagging & kelas satwa
            updateChart('chartContainer1', dataObj);
            
            // Update grafik jumlah satwa koleksi
            updateChart('chartContainer3', dataObj);
        }
    
        let chartInstances = {}; // Simpan instance grafik global

        function updateChart(chartId, dataObj) {
            // Hapus instance grafik lama jika ada
            if (chartInstances[chartId]) {
                chartInstances[chartId].destroy();
            }

            let labels = [];
            let totals = [];
            for (let label in dataObj) {
                if (dataObj.hasOwnProperty(label)) {
                    labels.push(label);
                    totals.push(dataObj[label]);
                }
            }

            let options = {
                chart: {
                    type: "bar",
                    height: 400,
                },
                series: [{
                    name: "Jumlah",
                    data: totals,
                }],
                xaxis: {
                    categories: labels,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " lembaga"; // Ubah sesuai tipe data
                        },
                    },
                },
            };

            chartInstances[chartId] = new ApexCharts(document.querySelector(`#${chartId}`), options);
            chartInstances[chartId].render();
        }
    });
    
    $('#filterButton').click(function () {
        const selectedClass = $('#classFilter').val(); // Dapatkan nilai dropdown
        filterDataByClass(selectedClass); // Panggil fungsi filter
    });
    

// Ambil data satwa dan simpan di localStorage jika belum ada
function fetchDataAndCache() {
    fetch('/get-satwa')  // Sesuaikan dengan endpoint API yang memberikan data satwa
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('satwaData', JSON.stringify(data));  // Simpan ke localStorage
            return data;
        })
        .catch(error => {
            console.error('Terjadi kesalahan mengambil data satwa:', error);
        });
}

// Ambil daftar kelas satwa dan simpan di dropdown
function fetchClassOptions() {
    fetch('/filter-class')
        .then(response => response.json())
        .then(data => {
            const classFilter = document.getElementById('classFilter');
            classFilter.innerHTML = '<option value="">Pilih Kelas Satwa</option>';

            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item;
                option.textContent = item.charAt(0).toUpperCase() + item.slice(1);  // Capitalize first letter
                classFilter.appendChild(option);
            });
        })
        .catch(error => console.error('Terjadi kesalahan mengambil kelas satwa:', error));
}

// // Ambil data satwa dari localStorage
// function getSatwaData() {
//     const cachedData = localStorage.getItem('satwaData');
//     if (cachedData) {
//         return JSON.parse(cachedData);
//     } else {
//         fetchDataAndCache();
//         return [];  // Return empty if no data yet
//     }
// }

// // Filter data berdasarkan kelas satwa yang dipilih
// function filterSatwaByClass(classType) {
//     const data = getSatwaData();
//     return data.filter(satwa => satwa.class === classType);
// }

// // Tampilkan hasil filter ke dalam list
// function displayFilteredSatwa(filteredData) {
//     const listContainer = document.getElementById('satwaList');
//     listContainer.innerHTML = '';  // Clear the list

//     filteredData.forEach(satwa => {
//         const item = document.createElement('li');
//         item.textContent = `Nama: ${satwa.name} | Kelas: ${satwa.class}`;
//         listContainer.appendChild(item);
//     });
// }

// // Fungsi untuk memperbarui grafik berdasarkan data yang sudah difilter
// function updateAllCharts(filteredData) {
//     // Misalnya jika Anda memiliki beberapa grafik menggunakan ApexCharts, Anda bisa melakukan seperti ini:

//     // Update grafik pertama
//     if (charts.jenisLKChart) {
//         charts.jenisLKChart.updateSeries([{
//             name: "Jumlah Lembaga",
//             data: filteredData.map(satwa => satwa.someValue) // Sesuaikan dengan data yang relevan
//         }]);
//     }

//     // Update grafik kedua (jika ada)
//     if (charts.otherChart) {
//         charts.otherChart.updateSeries([{
//             name: "Jumlah Satwa",
//             data: filteredData.map(satwa => satwa.anotherValue) // Sesuaikan dengan data yang relevan
//         }]);
//     }

//     // Tambahkan update untuk grafik lainnya jika ada
// }

// Handle filter ketika tombol ditekan
function handleFilterByClass() {
    const classType = document.getElementById('classFilter').value;
    if (classType) {
        const filteredData = filterDataByClass(classType);
        displayFilteredSatwa(filteredData);
        updateAllCharts(filteredData); // Memperbarui semua grafik setelah filter diterapkan
    }
}

// Event listener untuk tombol filter
document.getElementById('filterButton').addEventListener('click', handleFilterByClass);

function filterDataByClass(classType) {
    console.log("Filtering data for class:", classType);
    const filteredData = allSatwaData.filter(satwa => satwa.class === classType);
    console.log("Filtered data:", filteredData);
    return filteredData;
}

// Memastikan data pertama kali dimuat jika belum ada di localStorage
if (!localStorage.getItem('satwaData')) {
    fetchDataAndCache();
}

// Memuat opsi kelas satwa saat halaman dimuat
fetchClassOptions();

});