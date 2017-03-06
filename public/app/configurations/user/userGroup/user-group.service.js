
(function () {
    'use strict';

    angular
        .module('app.configurations')
        .factory('userGroupService', function (BaseServerService,$http,API_CONFIG) {
            var vm = this;
            vm.baseUrl = API_CONFIG.baseUrl;

            var userGroupService = function () {
                BaseServerService.constructor.call(this);
            };

            userGroupService.prototype = new BaseServerService('user-group');


            userGroupService.prototype.getUserGroupListToAssignTerritory = function(){
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    //route/ro-assign-to-current
                    url: vm.baseUrl + 'user-group/assign-user-territory',

                });
            };


            //user-group/assign-territory

            return new userGroupService();
        });
})();
