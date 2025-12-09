window.addEventListener("DOMContentLoaded", () => {
    // experience toggle 
    const experience = document.getElementById("experienced");
    const fresher = document.getElementById("fresher");
    const hiddenExperience = document.getElementById("hidden-experience");
    const isExperienceOpen = document.getElementById("ExperienceOpen");

    const toggleExperience = () => {
        hiddenExperience.style.display = experience.checked ? "block" : "none";
        if (fresher.checked) {
            isExperienceOpen.value = "false";
        } else if (experience.checked) {
            isExperienceOpen.value = "true";
        }
    };

    experience.addEventListener("change", toggleExperience);
    fresher.addEventListener("change", toggleExperience);

    // Date limit
    const todayDate = new Date().toISOString().split("T")[0];
    document.getElementById("start-date").min = todayDate;
    document.getElementById("dob").max = todayDate;

    // helper function 1 for validation 
    function attachCommonListeners(input, errorDiv, isTouchedObj, extraValidation = null) {
        input.addEventListener("input", (e) => {
            errorDiv.innerText = "";
            errorDiv.classList.remove("active");
            if (extraValidation) extraValidation(e);
        });

        input.addEventListener("focus", () => {
            if (!isTouchedObj.touched) return;
            errorDiv.innerText = "";
            errorDiv.classList.remove("active");
        });

        input.addEventListener("blur", () => {
            isTouchedObj.touched = true;

            if (!input.value.trim()) {
                errorDiv.classList.add("active");
                errorDiv.innerText = "This field is required";
            }
        });
    }

    const form = document.getElementById("applicationForm");
    // null and char validation
    const fieldSet1 = [
        "fname",
        "lname",
        "address",
        "universityinstitutionname",
        "previousjob",
        "company"
    ];

    fieldSet1.forEach((name) => {
        const input = form[name];
        const errorDiv = document.getElementById(`${name}-error`);
        const isTouchedObj = { touched: false };

        attachCommonListeners(input, errorDiv, isTouchedObj, isValidInputChar);
    });

    // only null validaiton
    const fieldSet2 = [
        "dob",
        "startdate",
        "experienceyear",
        "nationality",
        "qualification",
        "jobposition",
        "joblocation"
    ];

    fieldSet2.forEach((name) => {
        const input = form[name];
        const errorDiv = document.getElementById(`${name}-error`);
        const isTouchedObj = { touched: false };

        attachCommonListeners(input, errorDiv, isTouchedObj);
    });


    // null and number validation
    const fieldSet3 = [
        "mobile",
        "jobexpectedsalary",
        "previoussalary",
        "pincode"
    ];
    fieldSet3.forEach((name) => {
        const input = form[name];
        const errorDiv = document.getElementById(`${name}-error`);
        const isTouchedObj = { touched: false };

        attachCommonListeners(input, errorDiv, isTouchedObj, isValidInputNumber);
    });

    // radio button and check box validation
    const fieldSet4 = [
        "gender",
        "marital",
        "fieldofstudy",
        "experience"
    ];

    fieldSet4.forEach((name) => {
        const inputs = document.getElementsByName(name);
        const errorDiv = document.getElementById(`${name}-error`);
        let touched = false;

        inputs.forEach((item) => {
            item.addEventListener("focus", () => {
                if (touched) {
                    errorDiv.innerText = "";
                    errorDiv.classList.remove("active");
                }
            });

            item.addEventListener("blur", () => {
                touched = true;

                const selected = [...inputs].some((i) => i.checked);
                console.log(item);
                if (!selected) {
                    errorDiv.classList.add("active");
                    errorDiv.innerText = "This field is required";
                } else {
                    errorDiv.innerText = "";
                    errorDiv.classList.remove("active");
                }
            });
        });
    });

});

// helper function for run time validation 
function isValidInputChar(e) {
    e.target.value = e.target.value.replace(/[^A-Za-z\s]/g, '');
}

function isValidInputNumber(e) {
    let cleaned = e.target.value.replace(/[^0-9]/g, '');
    e.target.value = cleaned.substring(0, 10);
}

// helper function and object for submit form
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
            this.errorDiv = errorDiv;
            return this;
        },
        isEmpty(msg = "This field is required") {
            if (this.isValid && this.value === "") {
                this.isValid = false;
                this.message = msg;
            }
            return this;
        },
        isPhoneNumber(msg = "Enter a valid phone number") {
            if (this.isValid && !/^\+?[1-9]\d{1,14}$/.test(this.value)) {
                this.isValid = false;
                this.message = msg;
            }
            return this;
        },
        isEmail(msg = "Enter a valid email") {
            if (this.isValid && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                this.isValid = false;
                this.message = msg;
            }
            return this;
        },
        isNotEmptyFile(msg = "File is required") {
            if (this.isValid && this.value == 0) {
                this.isValid = false;
                this.message = msg
            }
        },
        result() {
            const div = document.getElementById(this.errorDiv);
            console.log(this.errorDiv)
            if (!this.isValid) {
                div?.classList.add("active");
                div.innerText = this.message;
            } else {
                div?.classList.remove("active");
                div.innerText = "";
            }

            return this.isValid;
        }
    };
}

//form submit handler
function handleForm(e) {
    e.preventDefault();
    const toast = document.getElementById("toast");
    const isExperienceOpen = document.getElementById("ExperienceOpen");
    const form = e.target;

    const fields = [
        { name: "fname", rules: ["isEmpty"] },
        { name: "lname", rules: ["isEmpty"] },
        { name: "dob", rules: ["isEmpty"] },
        { name: "gender", rules: ["isEmpty"] },
        { name: "marital", rules: ["isEmpty"] },
        { name: "nationality", rules: ["isEmpty"] },
        { name: "mobile", rules: ["isEmpty", "isPhoneNumber"] },
        { name: "email", rules: ["isEmpty", "isEmail"] },
        { name: "address", rules: ["isEmpty"] },
        { name: "pincode", rules: ["isEmpty"] },
        { name: "qualification", rules: ["isEmpty"] },
        { name: "fieldofstudy", rules: ["isEmpty"] },
        { name: "universityinstitutionname", rules: ["isEmpty"] },
        { name: "jobposition", rules: ["isEmpty"] },
        { name: "joblocation", rules: ["isEmpty"] },
        { name: "startdate", rules: ["isEmpty"] },
        { name: "jobexpectedsalary", rules: ["isEmpty"] },
    ];

    let allValid = true;

    fields.forEach(f => {
        let val;
        if (f.rules.includes("isNotEmptyFile")) {
            val = document.getElementById(f.name)?.files.length || 0;
        } else {
            val = form[f.name]?.value || "";
        }
        const validator = createValidator().setValue(val, `${f.name}-error`);

        f.rules.forEach(r => validator[r]());

        if (!validator.result()) allValid = false;
    });

    const field2 = [
        { name: "experienceyear", rules: ["isEmpty"] },
        { name: "previousjob", rules: ["isEmpty"] },
        { name: "company", rules: ["isEmpty"] },
        { name: "previoussalary", rules: ["isEmpty"] },
    ];

    if (isExperienceOpen.value == "true") {
        field2.forEach(f => {
            let val;
            if (f.rules.includes("isNotEmptyFile")) {
                val = document.getElementById(f.name)?.files.length || 0;
            } else {
                val = form[f.name]?.value || "";
            }
            const validator = createValidator().setValue(val, `${f.name}-error`);

            f.rules.forEach(r => validator[r]());

            if (!validator.result()) allValid = false;
        }); 
    }

    if(!document.getElementsByName("old_resume")){
        let val = document.getElementById("resume")?.files.length || 0

        const validator = createValidator().setValue(val, `resune-error`).isNotEmptyFile();
        if (!validator.result()) allValid = false;
    }

    if(!document.getElementsByName("old_photo")){
        let val = document.getElementById("photo")?.files.length || 0

        const validator = createValidator().setValue(val, `photo-error`).isNotEmptyFile();
        if (!validator.result()) allValid = false;
    }

    if (allValid) {
        form.submit();
    }
}

function removeError() {
    const errorDivs = document.querySelectorAll(".error");
    errorDivs.forEach(div => {
        div.classList.remove("active");
        div.innerText = "";
    });

}