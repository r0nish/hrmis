(function () {
    'use strict';

    angular
        .module('app.configurations')
        .factory('userDetailService', function (BaseServerService, $http, API_CONFIG) {
            var apiUrl = API_CONFIG.baseUrl;
            var userDetailService = function () {
                BaseServerService.constructor.call(this);
            };

            userDetailService.prototype = new BaseServerService('user');
            /**
             * Obtain the Details Of the Users, that typically contains name, password, email
             * @param userGroup
             * @param town
             * @param geoLocation
             * @returns {*}
             */
            userDetailService.prototype.getUserDetail = function (idUser) {
                return $http({
                    method: "GET",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user-detail/' + idUser
                });
            };

            /**
             * in case of Distributor fetch all the Routes associated to given distributor.
             * Receives the DSE Assigned under each Routes
             * @param distributorId
             * @returns {*}
             */
            userDetailService.prototype.getRoutesOfDistributor = function (distributorId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/distributor/route-list',
                    data: $.param({distributor: distributorId})
                });
            };

            /** Receives all DSE(users) under distributors) */
            userDetailService.prototype.getUsersUnderDistributor = function (distributorId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/dse-list',
                    data: $.param({user_id: distributorId})
                });
            };

            /**
             * delete DSE under Distributor Route
             * @param routeId
             * @returns {*}
             */
            userDetailService.prototype.deleteDSEUnderDistributorRoute = function (userId, routeId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/route/remove-assign-route',
                    data: $.param({detail: userId, id_route: routeId})
                });
            };

            /**
             * updates the password for given user
             * @param user
             */
            userDetailService.prototype.updatePassword = function (user) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/update-password',
                    data: $.param({detail: user})
                });
            };

            /**
             * get the user hierarchy List (users under the given user)
             * @param userId
             * @returns {*}
             */
            userDetailService.prototype.getUserHierarchy = function (userId) {
                return $http({
                    method: "GET",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user-hierarchy/' + userId
                });
            };

            return new userDetailService();
        });
})();
