document.addEventListener("DOMContentLoaded", function () {
  const REQUIRED_MESSAGES = {
    pertanyaan: "Silakan isi pertanyaan.",
    jawaban: "Silakan isi jawaban.",
  };

  Object.keys(REQUIRED_MESSAGES).forEach(function (fieldId) {
    const field = document.getElementById(fieldId);

    if (!field) {
      return;
    }

    field.addEventListener("invalid", function () {
      this.setCustomValidity(REQUIRED_MESSAGES[fieldId]);
    });

    field.addEventListener("input", function () {
      this.setCustomValidity("");
    });
  });
});
