/* =========================================================
   DAFTAR PESANAN PRODUSER
   Tugas file ini: filter baris pesanan berdasarkan kata kunci.
========================================================= */
(function () {
    "use strict";

    function init() {
        var search = document.getElementById("searchPesanan");
        var rows = document.querySelectorAll(".order-row");
        var noResult = document.getElementById("noResultRow");

        if (!search) {
            return;
        }

        search.addEventListener("input", function () {
            var keyword = this.value.toLowerCase().trim();
            var visible = 0;

            rows.forEach(function (row) {
                var match =
                    row.textContent.toLowerCase().indexOf(keyword) !== -1;

                row.hidden = !match;

                if (match) {
                    visible++;
                }
            });

            /* Tampilkan pesan hanya jika memang ada pesanan tetapi tidak ada yang cocok */
            if (noResult) {
                noResult.hidden = !(rows.length > 0 && visible === 0);
            }
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
