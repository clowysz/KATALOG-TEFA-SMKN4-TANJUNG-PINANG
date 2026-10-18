/* =========================================================
   DASHBOARD - ADMIN JURUSAN
   Grafik donat jumlah pesanan produk vs jasa.

   Data dibaca dari atribut pada <canvas id="chartJenisPesanan">:
   - data-produk : total pesanan produk
   - data-jasa   : total pesanan jasa

   Chart.js harus dimuat lebih dulu di blade.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const chartElement = document.getElementById("chartJenisPesanan");

  if (!chartElement || typeof Chart === "undefined") {
    return;
  }

  const totalProduk = Number(chartElement.dataset.produk) || 0;
  const totalJasa = Number(chartElement.dataset.jasa) || 0;

  new Chart(chartElement, {
    type: "doughnut",

    data: {
      labels: ["Produk", "Jasa"],

      datasets: [
        {
          data: [totalProduk, totalJasa],
          backgroundColor: ["#1E3A8A", "#573911"],
          borderWidth: 0,
        },
      ],
    },

    options: {
      cutout: "72%",
      responsive: true,
      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: true,
          position: "bottom",
        },

        tooltip: {
          callbacks: {
            label: function (context) {
              const value = context.raw || 0;
              const total = totalProduk + totalJasa;

              const percentage =
                total > 0 ? ((value / total) * 100).toFixed(1) : 0;

              return (
                context.label + ": " + value + " pesanan (" + percentage + "%)"
              );
            },
          },
        },
      },
    },
  });
});
