app.directive('focusInvalid', function ($timeout) {
    return {
        restrict: 'A',
        require: '^form',
        link: function (scope, element, attrs, formCtrl) {
            scope.$on('focusFirstInvalid', function () {
                $timeout(function () {
                    var firstInvalid = element[0].querySelector(
                        '.ng-invalid:not(form)'
                    );

                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                });
            });
        }
    };
});

app.directive('fileModel', function ($parse) {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {

            element.on('change', function () {
                scope.$apply(function () {
                    var file = element[0].files[0];

                    ngModel.$setViewValue(file);
                    ngModel.$setValidity('required', !!file);
                });
            });
        }
    };
});


app.controller("jobFormController", function ($scope, ToastService) {
    $scope.jobApplication = {
        "experience": "fresher"
    };
    console.log($scope.jobApplication)
    // function createValidator(f) {
    //     return {
    //         f: f,
    //         isValid: true,
    //         message: "",
    //         isEmpty(msg = "This field is required") {
    //             if (this.f.$error.required) {
    //                 this.isValid = false;
    //                 this.message = msg;
    //             }
    //             return this;
    //         },
    //         minLength(msg = "Minimum 3 characters required") {
    //             if (this.f.$error.minlength) {
    //                 this.isValid = false;
    //                 this.message = msg;
    //             }
    //             return this;
    //         },
    //         isPhoneNumber(msg = "Enter a valid phone number") {
    //             if (this.isValid && !/^\+?[1-9]\d{1,14}$/.test(this.value)) {
    //                 this.isValid = false;
    //                 this.message = msg;
    //             }
    //             return this;
    //         },
    //         isEmail(msg = "Enter a valid email") {
    //             if (this.isValid && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
    //                 this.isValid = false;
    //                 this.message = msg;
    //             }
    //             return this;
    //         },
    //         isNotEmptyFile(msg = "File is required") {
    //             if (this.isValid && this.value == 0) {
    //                 this.isValid = false;
    //                 this.message = msg
    //             }
    //         },
    //         getMessage() {
    //             return this.message;
    //         }
    //     };
    // }

    // $scope.getError = function (f, rules) {
    //     const validator = createValidator(f);
    //     console.log(validator);
    //      rules.forEach(rule => {
    //         if (rule.name === "isEmpty") validator.isEmpty(rule.msg);
    //         if (rule.name === "minLength") validator.minLength(rule.msg);
    //         if (rule.name === "isEmail") validator.isEmail(rule.msg);
    //         if (rule.name === "isPhoneNumber") validator.isPhoneNumber(rule.msg);
    //     });
    //     return validator.getMessage();
    // };

    // // $scope.getCheckError = function (f) {
    // //     const validator = $scope.jobApplication[f];

    // //     console.log(validator);
    // //     // return validator.getMessage();
    // // };

    $scope.submitApplication = function (form) {
        if (form.$invalid) {
            form.$setSubmitted();
            $scope.$broadcast('focusFirstInvalid');
            ToastService.show("error", "All field required");
            return;
        }
        console.log("Form submitted", $scope.jobApplication);
        ToastService.show("success", "Form submited successflly");
        form.$setPristine();
        form.$setUntouched();
    }

    $scope.resetForm = function (form) {
        $scope.jobApplication = {
            "experience": "fresher"
        };
        form.$setPristine();
        form.$setUntouched();
    };
});