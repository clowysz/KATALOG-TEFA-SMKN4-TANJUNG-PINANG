/*
|--------------------------------------------------------------------------
| Halaman checkout pembeli
|--------------------------------------------------------------------------
| Harga satuan dibaca dari atribut data-harga pada #formCheckout.
*/
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formCheckout");

    if (!form) return;

    const btnMinus = document.getElementById("btnMinus");
    const btnPlus = document.getElementById("btnPlus");
    const jumlahInput = document.getElementById("jumlah");

    const summaryJumlah = document.getElementById("summaryJumlah");
    const summaryTotal = document.getElementById("summaryTotal");
    const bottomTotal = document.getElementById("bottomTotal");
    const totalItemText = document.getElementById("totalItemText");

    const hargaSatuan = parseFloat(form.dataset.harga) || 0;

    function formatRupiah(angka) {
        return "Rp" + new Intl.NumberFormat("id-ID").format(angka);
    }

    function updateTotal() {
        const jumlah = parseInt(jumlahInput.value) || 1;
        const total = hargaSatuan * jumlah;

        summaryJumlah.textContent = jumlah;
        summaryTotal.textContent = formatRupiah(total);
        bottomTotal.textContent = formatRupiah(total);
        totalItemText.textContent = "Total (" + jumlah + " item)";
    }

    btnMinus.addEventListener("click", function () {
        let jumlah = parseInt(jumlahInput.value) || 1;

        if (jumlah > 1) {
            jumlah--;
            jumlahInput.value = jumlah;
            updateTotal();
        }
    });

    btnPlus.addEventListener("click", function () {
        let jumlah = parseInt(jumlahInput.value) || 1;

        jumlah++;
        jumlahInput.value = jumlah;

        updateTotal();
    });

    updateTotal();
});
