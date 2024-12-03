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
  //jenis lk
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

  //kelas satwa 
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

  $(document).ready(function () {
  const dataContainer = $('#spesiesIndvChart');
  const dataObj = JSON.parse(dataContainer.attr('data-counts'));

  let labels = [];
  let totals = [];
  let filteredLabels = [];
  let filteredTotals = [];

  // Parse data
  for (let label in dataObj) {
      if (dataObj.hasOwnProperty(label)) {
          labels.push(label);
          totals.push(dataObj[label]);
      }
  }

  // Grafik awal
  const chartOptions = {
      chart: {
          type: "bar",
          height: 400,
      },
      plotOptions: {
          bar: {
              horizontal: true,
              columnWidth: "100%",
              barSpacing: 100
          }
      },
      series: [{
          name: "Jumlah satwa",
          data: totals
      }],
      xaxis: {
          categories: labels
      },
      colors: ["#008FFB", "#00E396", "#FEB019"],
      tooltip: {
          y: {
              formatter: function (val) {
                  return val + " individu";
              }
          }
      }
  };

  const speciesChart = new ApexCharts(document.querySelector("#spesiesIndvChart"), chartOptions);
  speciesChart.render();

  // Fungsi untuk filter data
  window.filterChartData = function () {
      const searchQuery = $('#searchSpecies').val().toLowerCase();
      filteredLabels = [];
      filteredTotals = [];

      labels.forEach((label, index) => {
          if (label.toLowerCase().includes(searchQuery)) {
              filteredLabels.push(label);
              filteredTotals.push(totals[index]);
          }
      });

      // Update grafik dengan data hasil filter
      speciesChart.updateOptions({
          xaxis: {
              categories: filteredLabels
          },
          series: [{
              name: "Jumlah satwa",
              data: filteredTotals
          }]
      });
  };
});




  // // Fungsi untuk mengambil data dari backend
  // async function fetchData() {
  //     try {
  //         const response = await fetch('get_data.php'); // Pastikan path ke file PHP benar
  //         const data = await response.json();

  //         // Data dari backend
  //         const lembagaData = data.lembaga;
  //         const satwaData = data.satwa;

  //         // Grafik 1: Statistik Lembaga Konservasi di bawah UPT
  //         const optionsLembaga = {
  //             chart: {
  //                 type: 'bar',
  //                 height: 350
  //             },
  //             colors: [colors.primary, colors.info],
  //             series: [
  //                 {
  //                     name: 'Jumlah Satwa',
  //                     data: lembagaData.map(lk => lk.jumlah_satwa)
  //                 },
  //                 {
  //                     name: 'Luas Area (ha)',
  //                     data: lembagaData.map(lk => lk.luas_area)
  //                 }
  //             ],
  //             xaxis: {
  //                 categories: lembagaData.map(lk => lk.nama),
  //                 title: { text: 'Nama Lembaga Konservasi' }
  //             },
  //             yaxis: {
  //                 title: { text: 'Statistik Lembaga' }
  //             },
  //             title: {
  //                 text: 'Monitoring Lembaga Konservasi',
  //                 align: 'center'
  //             }
  //         };

  //         const chartLembaga = new ApexCharts(document.querySelector("#chart-upt-lembaga"), optionsLembaga);
  //         chartLembaga.render();

  //         // Grafik 2: Jumlah Spesies Satwa per Lembaga Konservasi
  //         const optionsSatwa = {
  //             chart: {
  //                 type: 'pie',
  //                 height: 350
  //             },
  //             colors: [colors.success, colors.warning, colors.danger],
  //             series: satwaData.map(lk => lk.jumlah_spesies),
  //             labels: satwaData.map(lk => lk.nama),
  //             title: {
  //                 text: 'Data Satwa di Lembaga Konservasi',
  //                 align: 'center'
  //             }
  //         };

  //         const chartSatwa = new ApexCharts(document.querySelector("#chart-satwa-lembaga"), optionsSatwa);
  //         chartSatwa.render();

  //     } catch (error) {
  //         console.error("Error fetching data:", error);
  //     }
  // }

  // // Panggil fungsi fetchData untuk memuat grafik
  // fetchData();

  function generateRandomColor() {
      let maxVal = 0xFFFFFF; 
      let randomNumber = Math.random() * maxVal; 
      randomNumber = Math.floor(randomNumber);
      randomNumber = randomNumber.toString(16);
      let randColor = randomNumber.padStart(6, 0);   
      return `#${randColor.toUpperCase()}`
  }      
});