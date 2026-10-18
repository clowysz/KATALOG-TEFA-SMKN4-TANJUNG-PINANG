/* =========================================================
   DASHBOARD TEFA (admin_tefa/dashboard)

   Grafik "Pesanan Berdasarkan Jurusan".
   Data dikirim dari blade lewat atribut pada <canvas>:
        data-labels = daftar nama jurusan  (JSON)
        data-values = jumlah pesanan       (JSON)
   Tinggi grafik diatur oleh CSS (.chart-wrap).
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("jurusanChart");

    if (!canvas) {
        return;
    }

    const BAR_COLORS = [
        "#D8893D",
        "#A85C5C",
        "#5F9275",
        "#315B7A",
        "#6FA6C8",
        "#D6AD4B",
    ];

    // Baca data JSON dari atribut; kembalikan [] jika rusak / kosong
    function readData(attribute) {
        try {
            const parsed = JSON.parse(canvas.dataset[attribute] || "[]");

            return Array.isArray(parsed) ? parsed : [];
        } catch (error) {
            return [];
        }
    }

    const labels = readData("labels");
    const data = readData("values");

    if (labels.length === 0) {
        return;
    }

    // Nama jurusan panjang dipecah ke beberapa baris
    // supaya label tidak miring / saling bertumpuk di layar kecil
    const isMobile = window.matchMedia("(max-width: 768px)").matches;
    const maxCharsPerLine = isMobile ? 10 : 16;

    function wrapLabel(label) {
        const lines = [];
        let currentLine = "";

        String(label)
            .split(" ")
            .forEach(function (word) {
                const testLine = currentLine ? currentLine + " " + word : word;

                if (testLine.length > maxCharsPerLine && currentLine) {
                    lines.push(currentLine);
                    currentLine = word;
                } else {
                    currentLine = testLine;
                }
            });

        if (currentLine) {
            lines.push(currentLine);
        }

        return lines;
    }

    new Chart(canvas, {
        type: "bar",

        data: {
            labels: labels,

            datasets: [
                {
                    label: "Jumlah Pesanan",

                    data: data,

                    backgroundColor: BAR_COLORS,

                    borderRadius: 6,
                    borderWidth: 0,
                },
            ],
        },

        options: {
            responsive: true,

            // Tinggi mengikuti kotak pembungkus (.chart-wrap), bukan rasio lebar
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false,
                },
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0,
                    },

                    grid: {
                        color: "rgba(0,0,0,0.05)",
                    },
                },

                x: {
                    grid: {
                        display: false,
                    },

                    ticks: {
                        autoSkip: false,
                        maxRotation: 0,

                        callback: function (value) {
                            return wrapLabel(this.getLabelForValue(value));
                        },
                    },
                },
            },
        },
    });
});
