let app = angular.module("myApp", ['ngRoute']);

app.run(function ($rootScope, $route, $location, AuthService) {
    $rootScope.pageCSS = [];
    $rootScope.isAuthorized = false;
    $rootScope.$on('$routeChangeSuccess', function () {
        $rootScope.pageCSS = $route.current.css || [];
    });

    $rootScope.$on('$routeChangeStart', function (event, next, current) {
        const publicRoutes = ['/login', '/register'];

        if (publicRoutes.indexOf(next.originalPath) === -1) {

            AuthService.isLoggedIn().then(function () {
                $rootScope.isAuthorized = true;
            }).catch(function () {
                event.preventDefault();
                $location.path('/login');
            });
        }
    });

});

app.config(function ($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "view/home.html",
            controller: "homeController",
            css: ["css/index.css"],
        })
        .when("/login", {
            templateUrl: "view/login.html",
            controller: "loginController",
            css: ["css/loginAndRegister.css"]
        })
        .when("/register", {
            templateUrl: "view/register.html",
            controller: "registerController",
            css: ["css/loginAndRegister.css"]
        })
        .when("/jobApplication", {
            templateUrl: "view/jobForm.html",
            controller: "jobFormController",
            css: ["css/form.css", "css/responsiveForm.css"]
        })
        .when("/calculator", {
            templateUrl: "view/calculator.html",
            controller: "calculatorController",
            css: ["css/calculator.css"]
        })
        .otherwise({
            redirectTo: "/login"
        });
});
