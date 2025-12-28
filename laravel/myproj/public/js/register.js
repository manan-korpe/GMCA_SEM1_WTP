function emptyCheck(input, errorDiv, message) {
    if (input.value.trim() === "") {
        errorDiv.innerText = message;
        errorDiv.classList.add("active");
        return false;
    } else {
        errorDiv.innerText = "";
        errorDiv.classList.remove("active");
        return true;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerform");

    const firstname = document.getElementById("firstname");
    const lastname = document.getElementById("lastname");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmpassword = document.getElementById("confirmpassword");

    const firstnameError = document.getElementById("firstname-error");
    const lastnameError = document.getElementById("lastname-error");
    const emailError = document.getElementById("email-error");
    const passwordError = document.getElementById("password-error");
    const confirmpasswordError = document.getElementById("confirmpassword-error");

    // Prevent numbers in firstname
    firstname.addEventListener("input", (e) => {
        e.target.value = e.target.value.replace(/[^A-Za-z\s]/g, '');
    });

    // Blur validation
    firstname.addEventListener("blur", () => emptyCheck(firstname, firstnameError, "First Name required"));
    lastname.addEventListener("blur", () => emptyCheck(lastname, lastnameError, "Last Name required"));
    email.addEventListener("blur", () => emptyCheck(email, emailError, "Email required"));
    password.addEventListener("blur", () => emptyCheck(password, passwordError, "Password required"));
    confirmpassword.addEventListener("blur", () => emptyCheck(confirmpassword, confirmpasswordError, "Confirm Password required"));

    // Form submission validation
    form.addEventListener("submit", (e) => {
        let ok = true;

        if (!emptyCheck(firstname, firstnameError, "First Name required")) ok = false;
        if (!emptyCheck(lastname, lastnameError, "Last Name required")) ok = false;
        if (!emptyCheck(email, emailError, "Email required")) ok = false;
        if (!emptyCheck(password, passwordError, "Password required")) ok = false;
        if (!emptyCheck(confirmpassword, confirmpasswordError, "Confirm Password required")) ok = false;

        if (password.value !== confirmpassword.value) {
            confirmpasswordError.innerText = "Passwords do not match";
            confirmpasswordError.classList.add("active");
            ok = false;
        }

        if (!ok) {
            e.preventDefault();  // stop form from submitting
        }
    });
});
