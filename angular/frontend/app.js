let app = angular.module("myApp", ['ngRoute']);

app.run(function ($rootScope, $route, $location, AuthService, ToastService) {
    let baseDir = "public/";
    $rootScope.college = baseDir + "college.jpg";
    $rootScope.gmca_photo = baseDir + "gmca_photo.jpg";
    $rootScope.pageCSS = [];
    $rootScope.isAuthorized = false;
    $rootScope.user = {};
    $rootScope.users = [{
        img: baseDir + "user1.jpeg",
        firstname: "Manan",
        lastname: "korpe",
        email: "manan@gmail.com",
        password: "123456"
    }, {
        img: baseDir + "user2.jpg",
        firstname: "Rahul",
        lastname: "pala",
        email: "rahul@gmail.com",
        password: "123456"
    },
    {
        img: baseDir + "user3.jpg",
        firstname: "Arun",
        lastname: "suthar",
        email: "arun@gmail.com",
        password: "123456"
    }
    ];

    $rootScope.$on('$routeChangeSuccess', function () {
        $rootScope.pageCSS = $route.current.css || [];
    });

    $rootScope.$on('$routeChangeStart', function (event, next) {
        const publicRoutes = ['/','/about', '/login', '/register'];

        if (!$rootScope.isAuthorized) {
            var user = JSON.parse(sessionStorage.getItem('user'));
            if (user?.email) {
                $rootScope.isAuthorized = true;
                $rootScope.user = user;
                return;
            }
        }
        if (publicRoutes.indexOf(next.originalPath) === -1 && !$rootScope.isAuthorized) {
            event.preventDefault();
            $location.path('/');
        }
    });

    //header login
    $rootScope.submitLogin = function (user) {
        console.log($rootScope.user.email)
        if ($rootScope.user?.email) {
            ToastService.show("error", "Please logout first");
            return;
        }
        if (user) {
            sessionStorage.setItem('user', JSON.stringify(user)); //session storage
            $rootScope.isAuthorized = true;
            $rootScope.user = user;
            ToastService.show("success", user.firstname + " Login successful");
            return;
        }
        ToastService.show("error", "Enter Valid email or password");
    }

    //nav logout
    $rootScope.logout = function () {
        $rootScope.user = {};
        sessionStorage.removeItem("user");
        $rootScope.isAuthorized = false;
        ToastService.show("success", "Logout successful");
        $location.path("/");
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
            controller: "profileController",
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
