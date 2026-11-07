document.addEventListener("DOMContentLoaded", function () {
  const formDeskripsi = document.getElementById("formDeskripsi");
  const descText = document.getElementById("descText");
  const btnEdit = document.getElementById("btnEditDesc");
  const btnCancel = document.getElementById("btnCancelDesc");
  const actionButtons = document.getElementById("actionButtons");
  const saveButtons = document.getElementById("saveButtons");

  if (!descText || !btnEdit || !btnCancel) {
    return;
  }

  let tempDesc = descText.value;

  function setEditMode(isEditing) {
    descText.readOnly = !isEditing;
    descText.classList.toggle("is-editing", isEditing);

    actionButtons.hidden = isEditing;
    saveButtons.hidden = !isEditing;
  }

  descText.addEventListener("input", function () {
    this.setCustomValidity("");
  });

  if (formDeskripsi) {
    formDeskripsi.addEventListener("submit", function (event) {
      if (descText.value.trim() === "") {
        event.preventDefault();

        descText.setCustomValidity("Deskripsi jurusan wajib diisi.");
        descText.reportValidity();
        return;
      }

      descText.value = descText.value.trim();
      descText.setCustomValidity("");
    });
  }

  btnEdit.addEventListener("click", function () {
    tempDesc = descText.value;

    setEditMode(true);
    descText.focus();
  });

  btnCancel.addEventListener("click", function () {
    descText.value = tempDesc;
    descText.setCustomValidity("");

    setEditMode(false);
  });
});
