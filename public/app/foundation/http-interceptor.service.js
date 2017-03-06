
(function() {
    'use strict';

    angular
        .module('app.foundation')
        .service('APIInterceptor',APIInterceptor);

    /* @ngInject */

    function APIInterceptor($rootScope, AuthDataShareService, $q) {
        var service = this;

        service.request = function(config) {
            var currentUser = AuthDataShareService.getUserInfo();
            var access_token = currentUser ? currentUser.accessToken : null;

            if (access_token) {
                config.headers.authorization = 'Bearer '+access_token;
            }

            return config;
        };

        service.responseError = function(response) {
            if(response.status === 401)
            {
              //  console.log('Authorized');
                $rootScope.$broadcast('unauthorized');
            }
            return response;
        };

    }


})();