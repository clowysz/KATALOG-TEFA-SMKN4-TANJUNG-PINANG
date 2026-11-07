window.FormValidasi = {
  pasang: function (form, aturan) {
    if (!form || !aturan || aturan.length === 0) return;

    // Jalankan satu aturan, simpan pesannya ke input
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
      // Saat mengetik: cek input ini + input terkait
      item.input.addEventListener("input", function () {
        jalankan(item);

        (item.ulangi || []).forEach(function (inputLain) {
          const aturanLain = cariAturan(inputLain);

          // Hanya cek ulang jika sudah pernah diisi
          if (aturanLain && inputLain.value !== "") {
            jalankan(aturanLain);
          }
        });
      });

      // Pasang pesan sejak halaman dimuat, supaya saat tombol
      // submit diklik browser sudah memakai pesan Indonesia
      jalankan(item);
    });

    // Saat submit: cek semua, tampilkan pesan kolom pertama yang salah
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
