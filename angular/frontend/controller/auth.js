app.directive("noNumbers", function () {
    return {
        require: "ngModel",
        link: function (scope, element, attrs, ngModel) {

            ngModel.$parsers.push(function (value) {
                if (!value) return value;

                var clean = value.replace(/[^a-zA-Z]/g, '');

                if (clean !== value) {
                    ngModel.$setViewValue(clean);
                    ngModel.$render();
                }

                return clean;
            });
        }
    };
});
app.controller("loginController", function ($scope, $http, $location, $timeout, ToastService) {
    $scope.user = {};

    $scope.getEmailError = function () {
        const f = $scope.loginForm.email;
        if (f.$error.required) {
            return "Email is required";
        } else if (f.$error.email) {
            return "Enter a valid email";
        } else {
            return "";
        }
    }

    $scope.getPasswordError = function () {
        const f = $scope.loginForm.password;
        if (f.$error.required) {
            return "Password is required";
        } else {
            return "";
        }
    }

    $scope.submitLogin = function (form) {
        if (form.$invalid) {
            ToastService.show("error", "Please fix validation errors.");
            return;
        }

        $http({
            method: 'POST',
            url: '../backend/login.php',
            data: $scope.user,
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function (response) {
            if (response.data.success) {
                ToastService.show("success", response.data.message);
                $scope.user = {};
                form.$setPristine();
                form.$setUntouched();
                $timeout(() => {
                    $location.path("/");
                }, 2000);
            } else {
                ToastService.show("error", response.data.message);
            }
        }, function (error) {
            ToastService.show("error", "Server error.");
        });
    };
});

app.controller("registerController", function ($scope, $http, $location, $timeout, ToastService) {

    $scope.user = {};  // binds form

    $scope.getFirstNameError = function () {
        const f = $scope.registerform.firstname;
        if (f.$error.required) {
            return "First name is required";
        } else if (f.$error.minlength) {
            return "Minimum 3 characters required";
        } else {
            return "";
        }
    }

    $scope.getLastNameError = function () {
        const f = $scope.registerform.lastname;
        if (f.$error.required) {
            return "Last name is required";
        } else if (f.$error.minlength) {
            return "Minimum 3 characters required";
        } else {
            return "";
        }
    }

    $scope.getEmailError = function () {
        const f = $scope.registerform.email;
        if (f.$error.required) {
            return "Email is required";
        } else if (f.$error.email) {
            return "Enter a valid email";
        } else {
            return "";
        }
    }

    $scope.getPasswordError = function () {
        const f = $scope.registerform.password;
        if (f.$error.required) {
            return "Password is required";
        } else {
            return "";
        }
    }

    $scope.getConfirmPasswordError = function () {
        const password = $scope.user.password;
        const confirmPassword = $scope.user.confirmpassword;
        const f = $scope.registerform.confirmpassword;

        if (f.$error.required) {
            return "Confirm Password is required";
        } else if (confirmPassword && confirmPassword !== password) {
            return "Password and Confirm Password must be the same";
        } else {
            return "";
        }
    };

    $scope.submitRegister = function (form) {
        if (form.$invalid) {
            ToastService.show("error", "Please fix validation errors.");
            return;
        }

        $http({
            method: 'POST',
            url: '../backend/register.php',
            data: $scope.user,
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function (response) {
            if (response.data.success) {
                ToastService.show("success", response.data.message);
                $scope.user = {}; // clear form
                form.$setPristine();
                form.$setUntouched();
                $timeout(() => {
                    $location.path("/login");
                }, 3000);
            } else {
                ToastService.show("error", response.data.message);
            }
        }, function (error) {
            ToastService.show("error", "Server error.");
        });
    };
});
