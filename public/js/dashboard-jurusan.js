document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('performaChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Total Dilihat', 'Total Dicari'],
                datasets: [{
                    data: [1411, 288], // Data gabungan dari statistik
                    backgroundColor: [
                        '#3B698F', // Biru TEFA
                        '#D8893D'  // Oranye RPL
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Membuat lubang tengah yang modern
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
    }
});