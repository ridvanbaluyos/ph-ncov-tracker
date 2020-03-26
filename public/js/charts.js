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



