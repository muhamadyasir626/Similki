const role = document.querySelector('.sidebar-brand');
// console.log(role.id);
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

    var fontFamily = "'Roboto', Helvetica, sans-serif"
 
    // Date Picker
  if($('#dashboardDate').length) {
    flatpickr("#dashboardDate", {
      wrap: true,
      dateFormat: "d-M-Y",
      defaultDate: "today",
    });
  }
  // Date Picker - END

// // Ambil data spesies satwa berdasarkan LK
// $.ajax({
//     url: '/get-satwa',
//     type: 'GET',
//     success: function(data) {
//       console.log('Data berhasil diambil:', data);
  
//       // Mengolah data untuk chart
//       const spesiesNames = data.map(item => item.spesies);
//       const jumlahSatwa = data.map(item => item.jumlah);
  
//       // Konfigurasi dan render chart
//       var options = {
//         chart: {
//           type: "bar",
//           height: 300
//         },
//         series: [{
//           name: "Jumlah Satwa",
//           data: jumlahSatwa
//         }],
//         xaxis: {
//           categories: spesiesNames
//         },
//         colors: ["#008FFB"],
//         tooltip: {
//           y: {
//             formatter: function (val) {
//               return val + " ekor";
//             }
//           }
//         }
//       };
  
//       new ApexCharts(document.querySelector("#chartContainer"), options).render();
//     },
//     error: function(error) {
//       console.log("Error fetching data: ", error);
//     }
//   });

// 

// $.ajax({
//     url: '/getData', // URL endpoint untuk data satwa
//     type: 'GET',
//     success: function(response) {
//         console.log('Data berhasil diambil:', response);

//         // Ambil data satwa per lembaga konservasi
//         const satwaData = response.satwa_by_lk || [];

//         // Cek apakah data ada dan tidak kosong
//         if (satwaData.length === 0) {
//             console.error("Data satwa kosong");
//             return;
//         }

//         // Siapkan data untuk chart
//         const spesiesNames = [];
//         const jumlahSatwa = [];

//         satwaData.forEach(function(item) {
//             if (item.spesies && item.jumlah) {
//                 spesiesNames.push(item.spesies); // Nama spesies
//                 jumlahSatwa.push(item.jumlah);  // Jumlah individu
//             }
//         });

//         // Pastikan data untuk grafik valid
//         if (spesiesNames.length === 0 || jumlahSatwa.length === 0) {
//             console.error("Data untuk chart tidak lengkap.");
//             return;
//         }

//         // Konfigurasi dan render chart menggunakan ApexCharts
//         const options = {
//             chart: {
//                 type: "bar",
//                 height: 400, // Tinggi chart
//                 toolbar: { show: false }
//             },
//             series: [{
//                 name: "Jumlah Individu",
//                 data: jumlahSatwa
//             }],
//             xaxis: {
//                 categories: spesiesNames,
//                 title: { text: "Spesies" }
//             },
//             yaxis: {
//                 title: { text: "Jumlah Individu" }
//             },
//             colors: ["#1E90FF"], // Warna bar
//             tooltip: {
//                 y: {
//                     formatter: function(val) {
//                         return val + " ekor";
//                     }
//                 }
//             },
//             plotOptions: {
//                 bar: {
//                     horizontal: true, // Bar horizontal
//                     barHeight: "70%"  // Tinggi bar
//                 }
//             },
//             dataLabels: {
//                 enabled: true, // Menampilkan jumlah di bar
//                 style: {
//                     fontSize: '12px',
//                     colors: ['#333']
//                 }
//             }
//         };

//         // Render chart
//         const chartElement = document.querySelector("#jumlahSatwa");
//         if (chartElement) {
//             new ApexCharts(chartElement, options).render();
//         } else {
//             console.error("Elemen chart tidak ditemukan.");
//         }
//     },
//     error: function(error) {
//         console.error("Error fetching data: ", error);
//     }
// });

// Reduce function for species count
const speciesCounts = spesies.reduce((counts, item) => {
    const speciesName = item.species.nama_ilmiah || "Tidak Diketahui"; // Ganti 'id_spesies' dengan 'nama_ilmiah' jika tersedia
    counts[speciesName] = (counts[speciesName] || 0) + 1;// Pastikan mengakumulasi 'jumlah_individu'
    // console.log(counts);
    
    return counts;
    }, {});
    const speciesNames = Object.keys(speciesCounts);
    const individualCounts = Object.values(speciesCounts);
    
    // Jika Anda ingin menampilkan hanya top 10 spesies dengan jumlah terbanyak
    const topSpeciesData = speciesNames.sort((a, b) => speciesCounts[b] - speciesCounts[a]).slice(0, 10);
    const topIndividualCounts = topSpeciesData.map(name => speciesCounts[name]);
    

$.ajax({
    url: `/get-data/${role.id}`,
    method: 'GET',
    success: function (response) {
        console.log(response);
       // Options for the bar chart
                var barOptions = {
                    chart: {
                        type: "bar",
                        height: 400,
                        events: {
                            dataPointSelection: function(event, chartContext, config) {
                                const selectedLabel = config.w.config.labels[config.dataPointIndex];
                                alert(`You clicked on: ${selectedLabel}`);
                                console.log('Clicked on pie chart data:', selectedLabel);
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            barHeight: '60%'
                        }
                    },
                    series: [{
                        name: "Jumlah Individu",
                        data: topIndividualCounts
                    }],
                    xaxis: {
                        categories: topSpeciesData
                    },
                    colors: ["#FF4560"],
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " individu";
                            }
                        }
                    }
                };

                // Render the bar chart
                new ApexCharts(document.querySelector("#spesiesIndChart"), barOptions).render();
            },
            error: function(error) {
                console.log("Error fetching data: ", error);
            }
        });
    });

        // if (response.status === 'success') {
        //     const dataSatwa = response.data;

        //     // Pisahkan data untuk label dan jumlah
        //     const labels = dataSatwa.map(item => `Spesies ${item.spesies}`);
        //     const jumlah = dataSatwa.map(item => item.jumlah);

        //     // Buat grafik
        //     const ctx = document.getElementById('satwaChart').getContext('2d');
        //     const satwaChart = new Chart(ctx, {
        //         type: 'bar', // Tipe grafik (bisa 'line', 'pie', dll)
        //         data: {
        //             labels: labels, // Label untuk sumbu X
        //             datasets: [{
        //                 label: 'Jumlah Satwa',
        //                 data: jumlah, // Data untuk sumbu Y
        //                 backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna batang grafik
        //                 borderColor: 'rgba(75, 192, 192, 1)', // Warna border batang
        //                 borderWidth: 1 // Ketebalan border
        //             }]
        //         },
        //         options: {
        //             scales: {
        //                 y: {
        //                     beginAtZero: true // Mulai dari 0
        //                 }
        //             }
        //         }
        //     });
        // } else {
        //     alert('Gagal mengambil data.');
        // }
//     },


//     error: function () {
//         alert('Terjadi kesalahan saat mengambil data.');
//     }
// });

// });
