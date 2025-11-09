function createValidator() {
    return {
        value: "",
        isValid: true,
        message: "",
        errorDiv: null,

        setValue(val, errorDiv) {
            this.value = String(val).trim();
            this.isValid = true;
            this.message = "";
            this.errorDiv = errorDiv || null;
            return this;
        },

        isEmpty(message = "This field is required") {
            if (!this.isValid) return this;
            if (this.value === "") {
                this.isValid = false;
                this.message = message;
            }
            return this;
        },

        isCharacter(message = "Letters only") {
            if (!this.isValid) return this;
            const regex = /^[A-Za-z\s]+$/;
            if (!regex.test(this.value)) {
                this.isValid = false;
                this.message = message;
            }
            return this;
        },

        isNumber(message = "Enter a valid number") {
            if (!this.isValid) return this;
            const regex = /^\d+$/;
            if (!regex.test(this.value)) {
                this.isValid = false;
                this.message = message;
            }
            return this;
        },

        isPhoneNumber(message = "Enter a valid phone number") {
            if (!this.isValid) return this;
            const regex = /^\+?[1-9]\d{1,14}$/;
            if (!regex.test(this.value)) {
                this.isValid = false;
                this.message = message;
            }
            return this;
        },

        isEmail(message = "Enter a valid email address") {
            if (!this.isValid) return this;
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(this.value)) {
                this.isValid = false;
                this.message = message;
            }
            return this;
        },
        result() {
            const div = document.getElementById(this.errorDiv);

            if (!this.isValid) {
                if (div) div.classList.add("active");
                if (div) div.innerText = this.message;
            } else {
                if (div) div.classList.remove("active");
                if (div) div.innerText = "";
            }
            return this.isValid;
        }
    };
}

// form submit event and validation
function handleForm(e) {
    const form = e;
    e.preventDefault();

    // define validation rules
    const fields = [
        { name: "fname", rules: ["isEmpty", "isCharacter"] },
        { name: "lname", rules: ["isEmpty", "isCharacter"] },
        { name: "dob", rules: ["isEmpty"] },
        { name: "gender", rules: ["isEmpty"] },
        { name: "marital", rules: ["isEmpty"] },
        { name: "nationality", rules: ["isEmpty", "isCharacter"] },
        { name: "mobile", rules: ["isEmpty", "isPhoneNumber"] },
        { name: "email", rules: ["isEmpty", "isEmail"] },
        { name: "address", rules: ["isEmpty"] },
        { name: "qualification", rules: ["isEmpty"] },
        { name: "fieldofstudy", rules: ["isEmpty"] },
        { name: "universityinstitutionname", rules: ["isEmpty"] },
        { name: "experienceyear", rules: ["isEmpty", "isNumber"] },
        { name: "previousjob", rules: ["isEmpty"] },
        { name: "company", rules: ["isEmpty"] },
        { name: "previoussalary", rules: ["isEmpty", "isNumber"] },
        { name: "skill", rules: ["isEmpty"] },
        { name: "jobposition", rules: ["isEmpty", "isCharacter"] },
        { name: "joblocation", rules: ["isEmpty"] },
        { name: "startdate", rules: ["isEmpty"] },
        { name: "jobexpectedsalary", rules: ["isEmpty", "isNumber"] },
    ];

    let allValid = true;

    fields.forEach(f => {
        const val = form[f.name]?.value ?? "";
        const validator = createValidator().setValue(val, `${f.name}-error`);
        f.rules.forEach(rule => validator[rule]());
        if (!validator.result()) allValid = false;
    });

    if (allValid) {
        console.log("Form is valid. Submitting...");
        // form.submit();
    }
}
