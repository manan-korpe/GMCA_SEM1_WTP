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
app.directive('matchPassword', function () {
    return {
        require: 'ngModel',
        scope: {
            matchPassword: '='
        },
        link: function (scope, element, attrs, ngModel) {

            ngModel.$validators.matchPassword = function (modelValue) {
                return modelValue === scope.matchPassword;
            };

            scope.$watch('matchPassword', function () {
                ngModel.$validate();
            });
        }
    };
});

app.controller("loginController", function ($scope, $rootScope, $http, $location, $timeout, ToastService) {
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
        const users = JSON.parse(localStorage.getItem("users")) || [];

        if (form.$invalid) {
            ToastService.show("error", "Please fix validation errors.");
            return;
        } else {
            let user = users.find((val)=>val.email==$scope.user.email && val.password == $scope.user.password); 
            if (user) {
                sessionStorage.setItem('user', JSON.stringify(user)); //session storage
                $rootScope.isAuthorized =true;
                $rootScope.user = user;
                ToastService.show("success", "login successful");
                $scope.user = {};
                form.$setPristine();
                form.$setUntouched();
                $timeout(() => {
                    $location.path("/");
                }, 1000);
                return;
            }
            ToastService.show("error", "Enter Valid email or password");
        }

        // $http({
        //     method: 'POST',
        //     url: '../backend/login.php',
        //     data: $scope.user,
        //     headers: {
        //         'Content-Type': 'application/json'
        //     }
        // }).then(function (response) {
        //     if (response.data.success) {
        //         ToastService.show("success", response.data.message);
        //         $scope.user = {};
        //         form.$setPristine();
        //         form.$setUntouched();

        //     } else {
        //         ToastService.show("error", response.data.message);
        //     }
        // }, function (error) {
        //     ToastService.show("error", "Server error.");
        // });
    };
});

app.controller("registerController", function ($scope, $http, $location, $timeout, ToastService) {

    $scope.user = {};

    $scope.submitRegister = function (form) {
        if (form.$invalid) {
            ToastService.show("error", "Please fix validation errors.");
            return;
        }
        let users = JSON.parse(localStorage.getItem("users")) || [];
        users = [...users,$scope.user];
        localStorage.setItem("users",JSON.stringify(users));
        ToastService.show("success", "registraion successfll");
        $scope.user = {};
        $timeout(() => {
            $location.path("/login");
        }, 2000);

        // $http({
        //     method: 'POST',
        //     url: '../backend/register.php',
        //     data: $scope.user,
        //     headers: {
        //         'Content-Type': 'application/json'
        //     }
        // }).then(function (response) {
        //     if (response.data.success) {
        //         ToastService.show("success", response.data.message);
        //         $scope.user = {}; // clear form
        //         form.$setPristine();
        //         form.$setUntouched();
        //         $timeout(() => {
        //             $location.path("/login");
        //         }, 3000);
        //     } else {
        //         ToastService.show("error", response.data.message);
        //     }
        // }, function (error) {
        //     ToastService.show("error", "Server error.");
        // });
    };
});
