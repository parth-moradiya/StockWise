// StockWise Retail Solutions - shared client-side form validation
// ------------------------------------------------------------------
// This runs BEFORE a form is submitted so users get instant feedback,
// but it is only a convenience layer. Every form is re-validated in
// PHP on the server, which is the real source of truth for security.

document.addEventListener("DOMContentLoaded", () => {
  const forms = document.querySelectorAll("form[novalidate]");

  forms.forEach((form) => {
    const fields = Array.from(form.querySelectorAll("input, select, textarea")).filter(
      (el) => el.willValidate
    );

    const messageFor = (input) => {
      if (input.validity.valueMissing) return "This field is required.";
      if (input.validity.typeMismatch && input.type === "email") return "Enter a valid email address.";
      if (input.validity.tooShort) return `Please enter at least ${input.minLength} characters.`;
      if (input.validity.patternMismatch) return "Please match the requested format.";
      if (input.validity.rangeUnderflow) return `Value must be ${input.min} or more.`;
      return "Please check this field.";
    };

    const fieldWrapper = (input) => input.closest(".form-group");

    const showError = (input) => {
      const wrapper = fieldWrapper(input);
      if (!wrapper) return;
      wrapper.classList.add("invalid");
      let msg = wrapper.querySelector(".js-field-error");
      if (!msg) {
        msg = document.createElement("p");
        msg.className = "field-error js-field-error";
        msg.style.display = "block";
        wrapper.appendChild(msg);
      }
      msg.textContent = messageFor(input);
    };

    const clearError = (input) => {
      const wrapper = fieldWrapper(input);
      if (!wrapper) return;
      wrapper.classList.remove("invalid");
      const msg = wrapper.querySelector(".js-field-error");
      if (msg) msg.remove();
    };

    fields.forEach((input) => {
      input.addEventListener("input", () => {
        if (input.checkValidity()) clearError(input);
      });
      input.addEventListener("blur", () => {
        if (!input.checkValidity()) showError(input);
      });
    });

    form.addEventListener("submit", (event) => {
      // Extra check: password confirmation fields, if present on this form.
      const password = form.querySelector('input[name="password"]');
      const confirm = form.querySelector('input[name="confirm_password"]');
      if (password && confirm && confirm.value !== "" && password.value !== confirm.value) {
        confirm.setCustomValidity("Passwords do not match.");
      } else if (confirm) {
        confirm.setCustomValidity("");
      }

      let firstInvalid = null;
      fields.forEach((input) => {
        if (!input.checkValidity()) {
          showError(input);
          if (!firstInvalid) firstInvalid = input;
        } else {
          clearError(input);
        }
      });

      if (firstInvalid) {
        event.preventDefault();
        firstInvalid.focus();
      }
      // If everything is valid, the form submits normally to PHP.
    });
  });
});
