app.service('AuthService', function($http, $q) {
    this.isLoggedIn = function () {
        let deferred = $q.defer();

        // $http.get('../backend/util/auth.php')
        //     .then(function(res){
        //         if(res.data.loggedIn){
        //             deferred.resolve(true);
        //         } else {
        //             deferred.reject(false);
        //         }
        //     });

        if(false)
            deferred.resolve(true);
        else
            deferred.reject(false);

        return deferred.promise;
    };
});
