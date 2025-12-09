app.controller("jobFormController", function ($scope) {
    $scope.jobApplication = {
        fname: ""
    };

    function createValidator(f) {
        return {
            f: f,
            isValid: true,
            message: "",
            isEmpty(msg = "This field is required") {
                if (this.f.$error.required) {
                    this.isValid = false;
                    this.message = msg;
                }
                return this;
            },
            minLength(msg = "Minimum 3 characters required") {
                if (this.f.$error.minlength) {
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
            getMessage() {
                return this.message;
            }
        };
    }

    $scope.getError = function (f, rules) {
        const validator = createValidator(f);

         rules.forEach(rule => {
            if (rule.name === "isEmpty") validator.isEmpty(rule.msg);
            if (rule.name === "minLength") validator.minLength(rule.msg);
            if (rule.name === "isEmail") validator.isEmail(rule.msg);
            if (rule.name === "isPhoneNumber") validator.isPhoneNumber(rule.msg);
        });
        return validator.getMessage();
    };

     $scope.getCheckError = function (f) {
        const validator = $scope.jobApplication[f];

        console.log(validator  )
        // return validator.getMessage();
    };

    $scope.submitApplication = function(){
        console.log("submited");
    }
});