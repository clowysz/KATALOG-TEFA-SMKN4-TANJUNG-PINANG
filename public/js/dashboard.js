document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('jurusanChart');

    if (!canvas) {
        return;
    }

    const labels = window.jurusanChartLabels || [];
    const data = window.jurusanChartData || [];

    if (labels.length === 0) {
        return;
    }

    new Chart(canvas, {
        type: 'bar',

        data: {
            labels: labels,

            datasets: [{
                label: 'Jumlah Pesanan',

                data: data,

                backgroundColor: [
                    '#D8893D',
                    '#A85C5C',
                    '#5F9275',
                    '#315B7A',
                    '#6FA6C8',
                    '#D6AD4B'
                ],

                borderRadius: 6,
                borderWidth: 0
            }]
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },

                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});