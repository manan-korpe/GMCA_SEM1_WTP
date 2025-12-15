app.controller("homeController", function ($scope, $http, $rootScope, $location, ToastService) {
    const baseDir = "public/";

    $scope.college = baseDir + "college.jpg";
    $scope.users = [baseDir + "user1.jpeg", baseDir + "user2.jpg", baseDir + "user3.jpg"];
});
