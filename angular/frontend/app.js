let app = angular.module("myApp", ['ngRoute']);

app.run(function ($rootScope, $route, $location, AuthService) {
    let baseDir = "public/";
    $rootScope.college = baseDir + "college.jpg";
    $rootScope.gmca_photo = baseDir + "gmca_photo.jpg"; 
    $rootScope.users = [baseDir + "user1.jpeg", baseDir + "user2.jpg", baseDir + "user3.jpg"];

    $rootScope.pageCSS = [];
    $rootScope.isAuthorized = false;
    $rootScope.user = {};

    $rootScope.$on('$routeChangeSuccess', function () {
        $rootScope.pageCSS = $route.current.css || [];
    });

    $rootScope.$on('$routeChangeStart', function (event, next) {
        const publicRoutes = ['/','/login', '/register'];
        
        if(!$rootScope.isAuthorized){
            var user = JSON.parse(sessionStorage.getItem('user'));
            if(user?.email){
                $rootScope.isAuthorized = true;
                $rootScope.user = user ;
                return;
            }
        }
        if (publicRoutes.indexOf(next.originalPath) === -1 && !$rootScope.isAuthorized) {
            event.preventDefault();
            $location.path('/login');
        }
    });

    $rootScope.logout = function () {
        sessionStorage.removeItem("user");
        $rootScope.isAuthorized = false;
        $location.path("/login");
    }
});

app.config(function ($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "view/home.html",
            controller: "homeController",
            css: ["css/home.css"],
        })
        .when("/about", {
            templateUrl: "view/about.html",
            css: ["css/about.css"],
        })
        .when("/profile", {
            templateUrl: "view/profile.html",
            controller:"profileController",
            css: ["css/profile.css"],
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
