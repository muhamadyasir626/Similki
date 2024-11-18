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
      console.log('Data berhasil diambil:', data);
      
  
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
                height: 250,
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
                    height: 250,
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: '60%',
                    }
                },
                series: [{
                    name: "Jumlah Lembaga",
                    data: jumlahData
                }],
                xaxis: {
                    categories: provinsiData
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

            new ApexCharts(document.querySelector("#wilayahLKChart"), options).render();
        },
        error: function(error) {
            console.log("Error fetching data: ", error);
        }
    });
    
});

// //jmlh spesies individu
// $.ajax({
//   url: '/get-satwa',
//   type: 'GET',
//   success: function(data) {
//       console.log('Data satwa berhasil diambil:', data);

//       // Menghitung jumlah individu per spesies
//       const speciesCounts = data.reduce((counts, item) => {
//           const speciesName = item.spesies || "Tidak Diketahui";
//           counts[speciesName] = (counts[speciesName] || 0) + item.jumlah_individu;
//           return counts;
//       }, {});

//       // Mengonversi hasil ke format yang dapat digunakan di chart
//       const speciesNames = Object.keys(speciesCounts);
//       const individualCounts = Object.values(speciesCounts);

//       // Membatasi jumlah spesies yang ditampilkan menjadi 10 spesies teratas
//       const topSpeciesData = speciesNames.slice(0, 10);
//       const topIndividualCounts = individualCounts.slice(0, 10);

//       console.log('Data spesies:', topSpeciesData);
//       console.log('Jumlah individu per spesies:', topIndividualCounts);

//       // Konfigurasi chart dengan data spesies dan jumlah individu
//       var options = {
//           chart: {
//               type: "bar",
//               height: 400,
//           },
//           plotOptions: {
//             bar: {
//                 horizontal: true,  // Mengubah bar menjadi horizontal
//                 barHeight: '60%',  // Lebar bar
//             }
//           },
//           series: [{
//               name: "Jumlah Individu",
//               data: topIndividualCounts  // Jumlah individu per spesies
//           }],
//           xaxis: {
//               categories: topSpeciesData  // Daftar spesies (dibatasi 10)
//           },
//           colors: ["#FF4560"],
//           tooltip: {
//               y: {
//                   formatter: function (val) {
//                       return val + " individu";
//                   }
//               }
//           }
//       };

//       // Render chart di elemen dengan id #jenisLKChart
//       new ApexCharts(document.querySelector("#spesiesIndvChart"), options).render();
//   },
//   error: function(error) {
//       console.log("Error fetching data: ", error);
//   }
// });

// Pie chart
$(document).ready(function() {
  
  $.ajax({
      url: '/get-satwa',
      type: 'GET',
      success: function(response) {
          const data = response.data;

          // Menghitung jumlah taksa
          const taksaCounts = data.reduce((counts, item) => {
              const taksa = item.kelas || "Tidak Diketahui";
              counts[taksa] = (counts[taksa] || 0) + 1;
              return counts;
          }, {});

          // Menghitung jumlah jenis koleksi
          const koleksiCounts = data.reduce((counts, item) => {
              const koleksi = item.jenis_koleksi || "Tidak Diketahui";
              counts[koleksi] = (counts[koleksi] || 0) + 1;
              return counts;
          }, {});

          // // Menghitung jumlah jenis tagging
          // const taggingCounts = data.reduce((counts, item) => {
          //     const tagging = item.jenis_tagging || "Tidak Diketahui";
          //     counts[tagging] = (counts[tagging] || 0) + 1;
          //     return counts;
          // }, {});

          // Menyusun data untuk chart
          const chartData = [
              {
                  data: Object.values(taksaCounts),
                  labels: Object.keys(taksaCounts)
              },
              {
                  data: Object.values(koleksiCounts),
                  labels: Object.keys(koleksiCounts)
              },
              // {
              //     data: Object.values(taggingCounts),
              //     labels: Object.keys(taggingCounts)
              // }
          ];

          // Membuat Pie Chart untuk masing-masing data
          chartData.forEach((item, index) => {
              var options = {
                  chart: {
                      type: 'pie',
                      height: 350,
                  },
                  series: item.data,  // Data untuk Pie Chart
                  labels: item.labels,  // Label kategori
                  title: {
                      text: item.name
                  },
                  tooltip: {
                      y: {
                          formatter: function(val) {
                              return val + " satwa";  // Menampilkan jumlah satwa per kategori
                          }
                      }
                  },
                  colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"],  // Warna untuk setiap kategori
              };

              // Render Pie Chart dalam elemen yang sesuai
              new ApexCharts(document.querySelector("#chartContainer" + (index + 1)), options).render();
          });
      },
      error: function(error) {
          console.log("Error fetching data: ", error);
      }
  });
  
});



  // Revenue Chart
  if ($('#revenueChart').length) {
    var lineChartOptions = {
      chart: {
        type: "line",
        height: '400',
        parentHeightOffset: 0,
        foreColor: colors.bodyColor,
        background: colors.cardBg,
        toolbar: {
          show: false
        },
      },
      theme: {
        mode: 'light'
      },
      tooltip: {
        theme: 'light'
      },
      colors: [colors.primary, colors.danger, colors.warning],
      grid: {
        padding: {
          bottom: -4,
        },
        borderColor: colors.gridBorder,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [
        {
          name: "Revenue",
          data: revenueChartData
        },
      ],
      xaxis: {
        type: "datetime",
        categories: revenueChartCategories,
        lines: {
          show: true
        },
        axisBorder: {
          color: colors.gridBorder,
        },
        axisTicks: {
          color: colors.gridBorder,
        },
        crosshairs: {
          stroke: {
            color: colors.secondary,
          },
        },
      },
      yaxis: {
        title: {
          text: 'Revenue ( $1000 x )',
          style:{
            size: 9,
            color: colors.muted
          }
        },
        tickAmount: 4,
        tooltip: {
          enabled: true
        },
        crosshairs: {
          stroke: {
            color: colors.secondary,
          },
        },
      },
      markers: {
        size: 0,
      },
      stroke: {
        width: 2,
        curve: "straight",
      },
    };
    var apexLineChart = new ApexCharts(document.querySelector("#revenueChart"), lineChartOptions);
    apexLineChart.render();
  }
  // Revenue Chart - END





  // Monthly Sales Chart
  if($('#monthlySalesChart').length) {
    var options = {
      chart: {
        type: 'bar',
        height: '318',
        parentHeightOffset: 0,
        foreColor: colors.bodyColor,
        background: colors.cardBg,
        toolbar: {
          show: false
        },
      },
      theme: {
        mode: 'light'
      },
      tooltip: {
        theme: 'light'
      },
      colors: [colors.primary],  
      fill: {
        opacity: .9
      } , 
      grid: {
        padding: {
          bottom: -4
        },
        borderColor: colors.gridBorder,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [{
        name: 'Sales',
        data: [152,109,93,113,126,161,188,143,102,113,116,124]
      }],
      xaxis: {
        type: 'datetime',
        categories: ['01/01/2023','02/01/2023','03/01/2023','04/01/2023','05/01/2023','06/01/2023','07/01/2023', '08/01/2023','09/01/2023','10/01/2023', '11/01/2023', '12/01/2023'],
        axisBorder: {
          color: colors.gridBorder,
        },
        axisTicks: {
          color: colors.gridBorder,
        },
      },
      yaxis: {
        title: {
          text: 'Number of Sales',
          style:{
            size: 9,
            color: colors.muted
          }
        },
      },
      legend: {
        show: true,
        position: "top",
        horizontalAlign: 'center',
        fontFamily: fontFamily,
        itemMargin: {
          horizontal: 8,
          vertical: 0
        },
      },
      stroke: {
        width: 0
      },
      dataLabels: {
        enabled: true,
        style: {
          fontSize: '10px',
          fontFamily: fontFamily,
        },
        offsetY: -27
      },
      plotOptions: {
        bar: {
          columnWidth: "50%",
          borderRadius: 4,
          dataLabels: {
            position: 'top',
            orientation: 'vertical',
          }
        },
      },
    }
    
    var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChart"), options);
    apexBarChart.render();
  }
  // Monthly Sales Chart - END





  // Cloud Storage Chart
  if ($('#storageChart').length) {
    var options = {
      chart: {
        height: 260,
        type: "radialBar"
      },
      series: [67],
      colors: [colors.primary],
      plotOptions: {
        radialBar: {
          hollow: {
            margin: 15,
            size: "70%"
          },
          track: {
            show: true,
            background: colors.light,
            strokeWidth: '100%',
            opacity: 1,
            margin: 5, 
          },
          dataLabels: {
            showOn: "always",
            name: {
              offsetY: -11,
              show: true,
              color: colors.muted,
              fontSize: "13px"
            },
            value: {
              color: colors.bodyColor,
              fontSize: "30px",
              show: true
            }
          }
        }
      },
      fill: {
        opacity: 1
      },
      stroke: {
        lineCap: "round",
      },
      labels: ["Storage Used"]
    };
    
    var chart = new ApexCharts(document.querySelector("#storageChart"), options);
    chart.render();    
  }
  // Cloud Storage Chart - END


});
