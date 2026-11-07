window.FormValidasi = {
  pasang: function (form, aturan) {
    if (!form || !aturan || aturan.length === 0) return;

    function jalankan(item) {
      const pesan = item.cek();
      item.input.setCustomValidity(pesan);
      return pesan === "";
    }

    function cariAturan(input) {
      return aturan.find(function (item) {
        return item.input === input;
      });
    }

    aturan.forEach(function (item) {
      item.input.addEventListener("input", function () {
        jalankan(item);

        (item.ulangi || []).forEach(function (inputLain) {
          const aturanLain = cariAturan(inputLain);

          if (aturanLain && inputLain.value !== "") {
            jalankan(aturanLain);
          }
        });
      });

      jalankan(item);
    });

    form.addEventListener("submit", function (event) {
      let inputPertamaSalah = null;

      aturan.forEach(function (item) {
        if (!jalankan(item) && !inputPertamaSalah) {
          inputPertamaSalah = item.input;
        }
      });

      if (inputPertamaSalah) {
        event.preventDefault();
        inputPertamaSalah.reportValidity();
      }
    });
  },
};
