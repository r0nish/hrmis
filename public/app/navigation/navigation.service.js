(function () {
    'use strict';

    angular
        .module('app.navigation')
        .factory('NavigationService', function (BaseServerService, $http, API_CONFIG, AuthDataShareService) {


            var apiUrl = API_CONFIG.baseUrl;
            var NavigationService = function () {
                BaseServerService.constructor.call(this);
            };

            NavigationService.prototype = new BaseServerService('sales-order');

            NavigationService.prototype.getMenuList = function () {

               // var userInfo = AuthDataShareService.getUserInfo();
                var userInfo = 1;

                if(userInfo != null)
                {
                    var userGroup = userInfo.user.user_group_id;

                    return $http({
                        method: "GET",
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        url: apiUrl + 'generate-menu/'+userGroup+'/1/1',
                    });
                }
            };

            return new NavigationService();

        });
})();

