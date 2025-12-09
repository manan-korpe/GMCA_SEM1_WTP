app.controller("homeController", function ($scope, $http, $rootScope, $location, ToastService) {
    const baseDir = "public/";

    $scope.college = baseDir + "college.jpg";
    $scope.users = [baseDir+"user1.jpeg", baseDir + "user2.jpg", baseDir + "user3.jpg"];

    $scope.logout = function () {
        $http({
            method: 'get',
            url: '../backend/logout.php',
        }).then(function (response) {
            if (response.data.success) {
                $rootScope.isAuthorized = false;
                $location.path("/login");
            } else {
                ToastService.show("error", "logout Unsuccessful");
            }
        }).catch(function (error) {
            ToastService.show("error", "Server error.");
        });
    }
});
