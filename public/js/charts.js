// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// By Status Chart
let byStatus = document.getElementById('byStatusChart');
let byStatusChart = new Chart(byStatus, {
    type: 'pie',
    data: {
        labels: ['Admitted', 'Recovered', 'Died', 'TBA'],
        datasets: [{
            data: [
                $('#byStatusAdmittedValue')[0].innerHTML,
                $('#byStatusRecoveredValue')[0].innerHTML,
                $('#byStatusDiedValue')[0].innerHTML,
                $('#byStatusTbaValue')[0].innerHTML,
            ],
            backgroundColor: ['rgba(246, 194, 62)', 'rgb(28, 200, 138)', 'rgb(231, 74, 59)', '#dfdfdf'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
    },
});

// By Sex Chart
let bySex = document.getElementById('bySexChart');
let bySexChart = new Chart(bySex, {
    type: 'pie',
    data: {
        labels: ['Male', 'Female', 'TBA'],
        datasets: [{
            data: [
                $('#bySexMaleValue')[0].innerHTML,
                $('#bySexFemaleValue')[0].innerHTML,
                $('#bySexTbaValue')[0].innerHTML,
            ],
            backgroundColor: ['#007DD9', '#F964A3', '#dfdfdf'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
    },
});

// Bar Chart Example
let ctx = document.getElementById("byAgeChart");
let myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Below 17', '18 to 30', '31 to 45', '45 to 60', 'Above 60', 'TBA'],
        datasets: [{
            label: 'Total',
            backgroundColor: '#4e73df',
            hoverBackgroundColor: '#2e59d9',
            borderColor: "#4e73df",
            data: [
                $('#byAge0Value')[0].innerHTML,
                $('#byAge1Value')[0].innerHTML,
                $('#byAge2Value')[0].innerHTML,
                $('#byAge3Value')[0].innerHTML,
                $('#byAge4Value')[0].innerHTML,
                $('#byAgeTbaValue')[0].innerHTML,
            ],
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'age'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 6
                },
                maxBarThickness: 25,
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 150,
                    maxTicksLimit: 5,
                    padding: 10,
                },
                gridLines: {
                    color: 'rgb(234, 236, 244)',
                    zeroLineColor: 'rgb(234, 236, 244)',
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
    }
});
