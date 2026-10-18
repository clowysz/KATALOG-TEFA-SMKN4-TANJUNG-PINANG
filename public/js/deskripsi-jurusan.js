/* =========================================================
   DESKRIPSI JURUSAN - ADMIN JURUSAN

   Textarea berstatus readonly di luar mode edit, jadi
   validasi hanya berjalan saat mode edit aktif.
========================================================= */

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

    // ------------------------------------------------------
    // Tampilan: mode lihat / mode edit
    // ------------------------------------------------------
    function setEditMode(isEditing) {
        descText.readOnly = !isEditing;
        descText.classList.toggle("is-editing", isEditing);

        actionButtons.hidden = isEditing;
        saveButtons.hidden = !isEditing;
    }

    // ------------------------------------------------------
    // Validasi - bahasa Indonesia
    // Form memakai novalidate, jadi dicek manual saat submit:
    // menangkap kosong DAN hanya berisi spasi / enter.
    // ------------------------------------------------------
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

            // Rapikan spasi di awal & akhir sebelum dikirim
            descText.value = descText.value.trim();
            descText.setCustomValidity("");
        });
    }

    // ------------------------------------------------------
    // Edit
    // ------------------------------------------------------
    btnEdit.addEventListener("click", function () {
        tempDesc = descText.value;

        setEditMode(true);
        descText.focus();
    });

    // ------------------------------------------------------
    // Batal edit
    // ------------------------------------------------------
    btnCancel.addEventListener("click", function () {
        descText.value = tempDesc;
        descText.setCustomValidity("");

        setEditMode(false);
    });
});
