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

     //jumlah tagging
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
});
