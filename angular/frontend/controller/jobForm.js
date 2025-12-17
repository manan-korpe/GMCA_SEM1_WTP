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
    
    const today = new Date();
    $scope.currentDate = today.toISOString().split("T")[0];
    
    today.setFullYear(today.getFullYear()-18);
    $scope.maxAgeDate = today.toISOString().split("T")[0];;

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