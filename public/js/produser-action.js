document.addEventListener("DOMContentLoaded", function () {
    /*
     * HELPER UMUM
     * (aman dipakai halaman lain, tidak bergantung pada elemen tertentu)
     */

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');

        if (meta) {
            return meta.getAttribute("content");
        }

        return null;
    }

    function submitForm(action, method, fields = {}) {
        const form = document.createElement("form");

        form.method = "POST";
        form.action = action;
        form.style.display = "none";

        const token = getCsrfToken();

        if (token) {
            const csrf = document.createElement("input");
            csrf.type = "hidden";
            csrf.name = "_token";
            csrf.value = token;
            form.appendChild(csrf);
        }

        if (method !== "POST") {
            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = method;
            form.appendChild(methodInput);
        }

        Object.keys(fields).forEach(function (key) {
            const value = fields[key];

            // Dukung array, misalnya urutan[]
            if (Array.isArray(value)) {
                value.forEach(function (item) {
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = key + "[]";
                    input.value = item ?? "";
                    form.appendChild(input);
                });

                return;
            }

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = value ?? "";
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }

    function showToast(message, success = true) {
        const toast = document.getElementById("toastUpdate");

        if (!toast) {
            return;
        }

        toast.textContent = message;
        toast.style.backgroundColor = success ? "#16A34A" : "#DC2626";

        toast.classList.add("show");

        setTimeout(function () {
            toast.classList.remove("show");
        }, 3000);
    }

    function formatRupiah(number) {
        return "Rp" + new Intl.NumberFormat("id-ID").format(number);
    }

    function formatTanggal(tanggal) {
        if (!tanggal) {
            return "-";
        }

        const date = new Date(tanggal);

        if (Number.isNaN(date.getTime())) {
            return tanggal;
        }

        return date.toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    }

    function getStatusClass(status) {
        if (status === "Selesai") {
            return "badge-soft-green";
        }

        if (
            status === "Sedang Dikerjakan" ||
            status === "Diproses" ||
            status === "konfirmasi"
        ) {
            return "badge-soft-blue";
        }

        if (status === "Dalam Revisi" || status === "Revisi") {
            return "badge-soft-yellow";
        }

        return "badge-soft-gray";
    }

    /*
     * KATALOG PRODUSER
     *
     * Data katalog diberikan langsung oleh Laravel.
     */

    const katalogContainer = document.getElementById("katalogContainer");

    if (katalogContainer) {
        const searchInput = document.getElementById("searchKatalogProduser");

        const cards = katalogContainer.querySelectorAll("[data-katalog-name]");

        function filterKatalog() {
            const keyword = searchInput
                ? searchInput.value.toLowerCase().trim()
                : "";

            cards.forEach(function (card) {
                const name = (card.dataset.katalogName || "").toLowerCase();

                card.style.display = name.includes(keyword) ? "" : "none";
            });
        }

        if (searchInput) {
            searchInput.addEventListener("input", filterKatalog);
        }
    }
});
