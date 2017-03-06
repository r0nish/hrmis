(function() {
    'use strict';

    angular
        .module('app.authentication')
        .service('AuthService', AuthService);

    /* @ngInject */


    function AuthService($http,$q,API_CONFIG, $window , AuthDataShareService) {
        var vm = this;
        vm.baseUrl = API_CONFIG.baseUrl;
        var userInfo;


        function login(userName, password,loginTypeLocal) {

            var deferred = $q.defer();

            $http({
                method:"POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl+'login',
                data: $.param({
                    grant_type: 'password',
                    username: userName,
                    password: password,
                    login_type_local: loginTypeLocal,
                    client_id: 'client',
                    client_secret: 'secret'})
            }).then(function (result) {

                /**
                 * checking 3 condition : promise fulfilled(success and failure) and promise not fulfilled,
                 */

                if (result.data.error){
                    deferred.resolve(result.data);
                }
                else{

                    userInfo = {
                       // accessToken: result.data.data.access_token,
                        accessToken:'12312safsdgsdg',
                       // user: result.data.data.userInfo
                        user: result.data.data



                    };

                    AuthDataShareService.setUserInfo(userInfo);

                    deferred.resolve(userInfo);
                }

            },function(result){
                deferred.reject(result.data);
            });
            return deferred.promise;

        }
         return {
            login: login
        };
    }

})();