window.addEventListener("DOMContentLoaded", () => {
    let experience = document.getElementById("experienced");
    let fresher = document.getElementById("fresher");
    let hiddenExperience = document.getElementById("hidden-experience");

    // hide and show experience menu
    experience.addEventListener("change", (e) => {
        console.log(experience.checked)
        if (experience.checked) {
            hiddenExperience.style.display = "block";
        }
    });

    fresher.addEventListener("change", (e) => {
        console.log(fresher.checked)
        if (fresher.checked) {
            hiddenExperience.style.display = "none";
        }
    });

    // date validation
    let todayDate = new Date().toISOString().split("T")[0];
    document.getElementById("start-date").min = todayDate;
    document.getElementById("dob").max = todayDate;

    let form = document.getElementById("applicationForm");

    //null and only char value valid 
    const fieldSet1 = [
        { name: "fname", isTouched: false },
        { name: "lname", isTouched: false },
        { name: "address", isTouched: false },
        { name: "universityinstitutionname", isTouched: false },
        { name: "previousjob", isTouched: false },
        { name: "company", isTouched: false },
    ];
    fieldSet1.forEach(({ name, rules, isTouched }) => {
        const input = form[name];
        const errorDiv = document.getElementById(`${name}-error`);

        input.addEventListener("input", isValidInputChar);

        input.addEventListener("focus", () => {
            if (!isTouched) return;
            errorDiv.innerText = "";
            errorDiv.classList.remove("active")
        });

        input.addEventListener("blur", (e) => {
            isTouched = true;
            const ErrorDiv = document.getElementById(`${name}-error`);
            console.log(input.value.trim());
            if (!input.value.trim()) {
                console.log(ErrorDiv);
                ErrorDiv.classList.add("active");
                ErrorDiv.innerText = "This field is required";
            }
        });

    });

    // null validation
    const fieldSet2 = [
        { name: "dob", isTouched: false },
        { name: "startdate", isTouched: false },
        { name: "experienceyear", isTouched: false },
        { name: "nationality", isTouched: false },
        { name: "qualification", isTouched: false },
        { name: "jobposition", isTouched: false },
        { name: "joblocation", isTouched: false }
    ];
    fieldSet2.forEach(({ name, isTouched }) => {
        const input = form[name];
        const errorDiv = document.getElementById(`${name}-error`);

        input.addEventListener("focus", () => {
            if (!isTouched) return;
            errorDiv.innerText = "";
            errorDiv.classList.remove("active")
        });

        input.addEventListener("blur", (e) => {
            isTouched = true;
            const ErrorDiv = document.getElementById(`${name}-error`);
            console.log(input.value.trim());
            if (!input.value.trim()) {
                console.log(ErrorDiv);
                ErrorDiv.classList.add("active");
                ErrorDiv.innerText = "This field is required";
            }
        });
    });

    // null and number validation
    const fieldSet3 = [
        { name: "mobile", isTouched: false },
        { name: "jobexpectedsalary", isTouched: false },
        { name: "previoussalary", isTouched: false }
    ];
    fieldSet3.forEach(({ name, isTouched }) => {
        const input = form[name];
        const errorDiv = document.getElementById(`${name}-error`);

        input.addEventListener("input", isValidInputNumber);

        input.addEventListener("focus", () => {
            if (!isTouched) return;
            errorDiv.innerText = "";
            errorDiv.classList.remove("active")
        });

        input.addEventListener("blur", (e) => {
            isTouched = true;
            const ErrorDiv = document.getElementById(`${name}-error`);
            console.log(input.value.trim());
            if (!input.value.trim()) {
                console.log(ErrorDiv);
                ErrorDiv.classList.add("active");
                ErrorDiv.innerText = "This field is required";
            }
        });
    });

    // radio and check box null validation
    const fieldSet4 = [
        { name: "gender", isTouched: false, isSelected: false },
        { name: "marital", isTouched: false, isSelected: false },
        { name: "joblocation", isTouched: false, isSelected: false },
        { name: "fieldofstudy", isTouched: false, isSelected: false },
        { name: "experience", isTouched: false, isSelected: false },
    ];
    fieldSet4.forEach(({ name, isTouched, isSelected }) => {
        const input = document.getElementsByName(name);
        const errorDiv = document.getElementById(`${name}-error`);

        input.forEach((filed) => {
            filed.addEventListener("focus",()=>{
                if (!isSelected) {
                    errorDiv.innerText = "";
                    errorDiv.classList.remove("active")
                }
            });

            filed.addEventListener("blur", () => {
                if (filed.checked) isSelected = true;
                if (isSelected) {
                    errorDiv.innerText = "";
                    errorDiv.classList.remove("active")
                } else {
                    errorDiv.classList.add("active");
                    errorDiv.innerText = "This field is required";
                }
            })
        });
        // const errorDiv = document.getElementById(`${name}-error`);

        // input.addEventListener("focus", () => {
        //     if (!isTouched) return;
        //     errorDiv.innerText = "";
        //     errorDiv.classList.remove("active")
        // });

        // input.addEventListener("blur", (e) => {
        //     isTouched = true;
        //     const ErrorDiv = document.getElementById(`${name}-error`);
        //     console.log(input.value.trim());
        //     if (!input.value.trim()) {
        //         console.log(ErrorDiv);
        //         ErrorDiv.classList.add("active");
        //         ErrorDiv.innerText = "This field is required";
        //     }
        // });
    });
});

function isValidInputChar(e) {
    e.target.value = e.target.value.replace(/[^A-Za-z\s]/g, '');
}

function isValidInputNumber(e) {
    let cleanedVal = e.target.value.replace(/[^0-9]+/g, '');
    if (cleanedVal.length > 10) {
        cleanedVal = cleanedVal.substring(0, 10);
    }
    e.target.value = cleanedVal;
}

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
        setTimeout(() => {
            console.log("Form is valid. Submitting...");
        }, 3000);
    }
}
