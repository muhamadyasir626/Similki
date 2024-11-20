$(function() {
  'use strict'



  var colors = {
    primary        : "#6571ff",
    secondary      : "#7987a1",
    success        : "#05a34a",
    info           : "#66d1d1",
    warning        : "#fbbc06",
    danger         : "#ff3366",
    light          : "#e9ecef",
    dark           : "#060c17",
    muted          : "#7987a1",
    gridBorder     : "rgba(77, 138, 240, .15)",
    bodyColor      : "#000",
    cardBg         : "#fff"
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

//Jenis lembaga konservasi
  $.ajax({
    url: '/get-lembaga-konservasi',
    type: 'GET',
    success: function(data) {
      // console.log('Data berhasil diambil:', data);
      
  
        // Menghitung jumlah lembaga per provinsi
        const bentukCounts = data.reduce((counts, item) => {
            const bentuk_lk = item.bentuk_lk || "Tidak Diketahui";
            counts[bentuk_lk] = (counts[bentuk_lk] || 0) + 1;
            return counts;
        }, {});
  
        // Mengonversi hasil ke format yang dapat digunakan di chart
        const bentukLKData = Object.keys(bentukCounts);
        const jumlahData = Object.values(bentukCounts);
  
        // console.log('Data bentuk LK:', bentukLKData);
        // console.log('Jumlah lembaga per bentuk LK:', jumlahData);
  
        // Konfigurasi chart dengan data provinsi dan jumlah lembaga
        var options = {
            chart: {
                type: "bar",
                height: 400,
            },
            plotOptions: {
              bar: {
                  horizontal: true,  // Mengubah bar menjadi horizontal
                  columnWidth: '60%',  // Lebar bar, semakin kecil semakin besar jaraknya
                  barSpacing: 50
              }
            },
            series: [{
                name: "Jumlah Lembaga",
                data: jumlahData  // Jumlah lembaga per provinsi
            }],
            xaxis: {
                categories: bentukLKData  // Daftar provinsi
            },
            colors: ["#FF4560", "#008FFB", "#00E396", "#FEB019"],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " lembaga";
                    }
                }
            }
        };
  
        new ApexCharts(document.querySelector("#jenisLKChart"), options).render();
    },
    error: function(error) {
        console.log("Error fetching data: ", error);
    }
  });

//Wilayah LK
$(document).ready(function() {
  
    $.ajax({
        url: '/get-lembaga-konservasi',
        type: 'GET',
        success: function(data) {
      // console.log('Data berhasil diambil:', data);

            const provinsiCounts = data.reduce((counts, item) => {
                const provinsi = item.provinsi || "Tidak Diketahui";
                counts[provinsi] = (counts[provinsi] || 0) + 1;
                return counts;
            }, {});

            const provinsiData = Object.keys(provinsiCounts);
            const jumlahData = Object.values(provinsiCounts);

            var options = {
              chart: {
                  type: "bar",
                  height: 400, 
                  animations: {
                      enabled: true,
                      easing: "easeinout",
                      speed: 800,
                  },
              },
              plotOptions: {
                  bar: {
                      horizontal: true,
                      // columnWidth: "50%", // Lebar bar
                      distributed: true, // Warna berbeda untuk setiap bar
                      // borderRadius: 4, // Sudut bar membulat
                  },
              },
              series: [{
                  name: "Jumlah Lembaga",
                  data: jumlahData, // Data jumlah lembaga
              }],
              xaxis: {
                  categories: provinsiData, // Nama provinsi
                  labels: {
                      style: {
                          fontSize: "12px", // Ukuran teks
                          fontFamily: "'Roboto', Helvetica, sans-serif",
                      },
                  },
              },
              yaxis: {
                  labels: {
                      style: {
                          fontSize: "12px",
                          fontFamily: "'Roboto', Helvetica, sans-serif",
                      },
                  },
              },
              colors: ["#FF4560",], // Warna bar
              tooltip: {
                  y: {
                      formatter: function (val) {
                          return val + " lembaga"; // Format tooltip
                      },
                  },
              },
              grid: {
                  borderColor: "rgba(77, 138, 240, 0.15)", // Warna grid
              },
              dataLabels: {
                  enabled: true, // Aktifkan label data
                  style: {
                      fontSize: "10px",
                      colors: ["#fff"],
                  },
                  formatter: function (val) {
                      return val;
                  },
              },
              legend: {
                  show: false, // Sembunyikan legend jika tidak perlu
              },
          };
          
          // Render ulang chart
          new ApexCharts(document.querySelector("#wilayahLKChart"), options).render();
          
        },
        error: function(error) {
            console.log("Error fetching data: ", error);
        }
    });
    
});



//satwa chart
 $(document).ready(function() {
    $.ajax({
        url: '/get-satwa',
        type: 'GET',
        success: function(response) {
            const Class = response.class;
            const jenis_tagging = response.jenis_tagging;
            const jenis_koleksi = response.jenis_koleksi;
            const spesies = response.spesies;
            
          console.log(spesies);


            // Reduce functions for various counts
            const taksaCounts = Class.reduce((counts, item) => {
                const taksa = item || "Tidak Diketahui";
                counts[taksa] = (counts[taksa] || 0) + 1;
                return counts;
            }, {});

            const koleksiCounts = jenis_koleksi.reduce((counts, item) => {
                const koleksi = item || "Tidak Diketahui";
                counts[koleksi] = (counts[koleksi] || 0) + 1;
                return counts;
            }, {});

            const taggingCounts = jenis_tagging.reduce((counts, item) => {
                const tagging = item || "Tidak Diketahui";
                counts[tagging] = (counts[tagging] || 0) + 1;
                return counts;
            }, {});

            // Reduce function for species count
            const speciesCounts = spesies.reduce((counts, item) => {
              const speciesName = item.id_spesies || "Tidak Diketahui";
                counts[speciesName] = (counts[speciesName] || 0) + item;
                return counts;
            }, {});
          

            const speciesNames = Object.keys(speciesCounts);
            const individualCounts = Object.values(speciesCounts);

            // Top 10 species counts
            const topSpeciesData = speciesNames.slice(0, 10);
            const topIndividualCounts = individualCounts.slice(0, 10);

            // Chart data for pie charts
            const chartData = [
                {
                    data: Object.values(taksaCounts),
                    labels: Object.keys(taksaCounts),
                },
                {
                    data: Object.values(koleksiCounts),
                    labels: Object.keys(koleksiCounts)
                },
                {
                    data: Object.values(taggingCounts),
                    labels: Object.keys(taggingCounts)
                }
            ];

            // Create pie charts for each data
            chartData.forEach((item, index) => {
                var options = {
                    chart: {
                        type: 'pie',
                        height: 400,
                        width: '100%'
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                width: '100%',
                                height: 300
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'left',
                            }
                        }
                    }],
                    series: item.data,
                    labels: item.labels,
                    colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0", '#FC8F54', '#FA812F', '#AF1740', '#4CC9FE']
                };

                new ApexCharts(document.querySelector("#chartContainer" + (index + 1)), options).render();
            });

            // Options for the bar chart
            var barOptions = {
                chart: {
                    type: "bar",
                    height: 400
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
            new ApexCharts(document.querySelector("#spesiesIndvChart"), barOptions).render();
        },
        error: function(error) {
            console.log("Error fetching data: ", error);
        }
    });
});





//   // Revenue Chart
//   if ($('#revenueChart').length) {
//     var lineChartOptions = {
//       chart: {
//         type: "line",
//         height: '400',
//         parentHeightOffset: 0,
//         foreColor: colors.bodyColor,
//         background: colors.cardBg,
//         toolbar: {
//           show: false
//         },
//       },
//       theme: {
//         mode: 'light'
//       },
//       tooltip: {
//         theme: 'light'
//       },
//       colors: [colors.primary, colors.danger, colors.warning],
//       grid: {
//         padding: {
//           bottom: -4,
//         },
//         borderColor: colors.gridBorder,
//         xaxis: {
//           lines: {
//             show: true
//           }
//         }
//       },
//       series: [
//         {
//           name: "Revenue",
//           data: revenueChartData
//         },
//       ],
//       xaxis: {
//         type: "datetime",
//         categories: revenueChartCategories,
//         lines: {
//           show: true
//         },
//         axisBorder: {
//           color: colors.gridBorder,
//         },
//         axisTicks: {
//           color: colors.gridBorder,
//         },
//         crosshairs: {
//           stroke: {
//             color: colors.secondary,
//           },
//         },
//       },
//       yaxis: {
//         title: {
//           text: 'Revenue ( $1000 x )',
//           style:{
//             size: 9,
//             color: colors.muted
//           }
//         },
//         tickAmount: 4,
//         tooltip: {
//           enabled: true
//         },
//         crosshairs: {
//           stroke: {
//             color: colors.secondary,
//           },
//         },
//       },
//       markers: {
//         size: 0,
//       },
//       stroke: {
//         width: 2,
//         curve: "straight",
//       },
//     };
//     var apexLineChart = new ApexCharts(document.querySelector("#revenueChart"), lineChartOptions);
//     apexLineChart.render();
//   }
//   // Revenue Chart - END





//   // Monthly Sales Chart
//   if($('#monthlySalesChart').length) {
//     var options = {
//       chart: {
//         type: 'bar',
//         height: '318',
//         parentHeightOffset: 0,
//         foreColor: colors.bodyColor,
//         background: colors.cardBg,
//         toolbar: {
//           show: false
//         },
//       },
//       theme: {
//         mode: 'light'
//       },
//       tooltip: {
//         theme: 'light'
//       },
//       colors: [colors.primary],  
//       fill: {
//         opacity: .9
//       } , 
//       grid: {
//         padding: {
//           bottom: -4
//         },
//         borderColor: colors.gridBorder,
//         xaxis: {
//           lines: {
//             show: true
//           }
//         }
//       },
//       series: [{
//         name: 'Sales',
//         data: [152,109,93,113,126,161,188,143,102,113,116,124]
//       }],
//       xaxis: {
//         type: 'datetime',
//         categories: ['01/01/2023','02/01/2023','03/01/2023','04/01/2023','05/01/2023','06/01/2023','07/01/2023', '08/01/2023','09/01/2023','10/01/2023', '11/01/2023', '12/01/2023'],
//         axisBorder: {
//           color: colors.gridBorder,
//         },
//         axisTicks: {
//           color: colors.gridBorder,
//         },
//       },
//       yaxis: {
//         title: {
//           text: 'Number of Sales',
//           style:{
//             size: 9,
//             color: colors.muted
//           }
//         },
//       },
//       legend: {
//         show: true,
//         position: "top",
//         horizontalAlign: 'center',
//         fontFamily: fontFamily,
//         itemMargin: {
//           horizontal: 8,
//           vertical: 0
//         },
//       },
//       stroke: {
//         width: 0
//       },
//       dataLabels: {
//         enabled: true,
//         style: {
//           fontSize: '10px',
//           fontFamily: fontFamily,
//         },
//         offsetY: -27
//       },
//       plotOptions: {
//         bar: {
//           columnWidth: "50%",
//           borderRadius: 4,
//           dataLabels: {
//             position: 'top',
//             orientation: 'vertical',
//           }
//         },
//       },
//     }
    
//     var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChart"), options);
//     apexBarChart.render();
//   }
//   // Monthly Sales Chart - END





//   // Cloud Storage Chart
//   if ($('#storageChart').length) {
//     var options = {
//       chart: {
//         height: 260,
//         type: "radialBar"
//       },
//       series: [67],
//       colors: [colors.primary],
//       plotOptions: {
//         radialBar: {
//           hollow: {
//             margin: 15,
//             size: "70%"
//           },
//           track: {
//             show: true,
//             background: colors.light,
//             strokeWidth: '100%',
//             opacity: 1,
//             margin: 5, 
//           },
//           dataLabels: {
//             showOn: "always",
//             name: {
//               offsetY: -11,
//               show: true,
//               color: colors.muted,
//               fontSize: "13px"
//             },
//             value: {
//               color: colors.bodyColor,
//               fontSize: "30px",
//               show: true
//             }
//           }
//         }
//       },
//       fill: {
//         opacity: 1
//       },
//       stroke: {
//         lineCap: "round",
//       },
//       labels: ["Storage Used"]
//     };
    
//     var chart = new ApexCharts(document.querySelector("#storageChart"), options);
//     chart.render();    
//   }
//   // Cloud Storage Chart - END


});