(function () {
  "use strict";

  function init() {
    var search = document.getElementById("searchKatalogProduser");
    var items = document.querySelectorAll(".katalog-item");
    var noResult = document.getElementById("katalogNoResult");

    if (!search) {
      return;
    }

    search.addEventListener("input", function () {
      var keyword = this.value.toLowerCase().trim();
      var visible = 0;

      items.forEach(function (item) {
        var match = item.textContent.toLowerCase().indexOf(keyword) !== -1;

        item.hidden = !match;

        if (match) {
          visible++;
        }
      });

      if (noResult) {
        noResult.hidden = !(items.length > 0 && visible === 0);
      }
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
