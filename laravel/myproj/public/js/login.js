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
    const form = document.getElementById("loginForm");
    console.log(form);

    //input fields
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    //error fields
    const usernameError = document.getElementById("username-error");
    const passwordError = document.getElementById("password-error");

    username.addEventListener("input", (e) => {
        e.target.value = e.target.value.replace(/[^A-Za-z0-9@\._-\s]/g, '');
    });

    username.addEventListener("blur", () => {
        emptyCheck(username, usernameError, "Username or Email required");
    });

    password.addEventListener("blur", () => {
        emptyCheck(password, passwordError, "Password required");
    });

    form.addEventListener("submit", (e) => {
        let ok = true;

        if (!emptyCheck(username, usernameError, "Username or Email required")) ok = false;
        if (!emptyCheck(password, passwordError, "Password required")) ok = false;

        if (!ok) {
            e.preventDefault(); // Block only if validation fails
            console.log("Form blocked by validation");
        } else {
            console.log("Form is valid, submitting...");
            // DO NOT prevent default — browser will submit to login.php
        }
    });
});
