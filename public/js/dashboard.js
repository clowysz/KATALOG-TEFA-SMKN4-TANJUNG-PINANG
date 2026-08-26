document.addEventListener("DOMContentLoaded", function() {
    // Memastikan elemen canvas ada di halaman
    const ctx = document.getElementById('jurusanChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['RPL', 'DKV', 'TKJ', 'Animasi', 'GIM', 'PSPT'],
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: [24, 18, 12, 8, 5, 4], // Data sesuai desainmu
                    backgroundColor: [
                        '#D8893D', // RPL
                        '#A85C5C', // DKV
                        '#5F9275', // TKJ
                        '#315B7A', // Animasi
                        '#6FA6C8', // GIM
                        '#D6AD4B'  // PSPT
                    ],
                    borderRadius: 6, // Biar bar-nya membulat ujungnya
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Sembunyikan tulisan 'Jumlah Pesanan' di atas grafik agar lebih clean
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
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
    }
});