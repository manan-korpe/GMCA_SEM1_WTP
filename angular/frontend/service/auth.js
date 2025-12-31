app.service('AuthService', function($http, $q) {
    this.isLoggedIn = function () {
        let deferred = $q.defer();
        if(false)
            deferred.resolve(true);
        else
            deferred.reject(false);

        return deferred.promise;
    };
});
