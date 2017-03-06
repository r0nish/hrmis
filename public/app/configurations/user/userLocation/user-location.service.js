(function () {
    'use strict';

    angular
        .module('app.configurations')
        .factory('userLocationService', function (BaseServerService, $http, API_CONFIG) {
            var apiUrl = API_CONFIG.baseUrl;
            var userLocationService = function () {
                BaseServerService.constructor.call(this);
            };

            userLocationService.prototype = new BaseServerService('user');


            userLocationService.prototype.getRouteList = function () {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'route/user/list'
                    //data: $.param({detail: data.user_id,id_route:data.id_route})
                });
            };

            /** get Route List Under Distributor */
            userLocationService.prototype.getRouteListUnderDistributor = function (distributorId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'distributor/route-list',
                    data: $.param({distributor: distributorId})
                });
            };

            userLocationService.prototype.getTownList = function () {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'town/user/list'
                    //data: $.param({detail: data.user_id,id_route:data.id_route})
                });
            };

            userLocationService.prototype.getGeoLocationList = function () {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'geographic-location/user/list'
                    //data: $.param({detail: data.user_id,id_route:data.id_route})
                });
            };

            /** receives the user location list */
            userLocationService.prototype.getGeoLocationUserList = function (query) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user-location/location-list?pagelimit=' + query['limit'] + '&page=' + query['page'] + '&order' + query['order'] + '&total' + query['total']
                });
            };


            /** receive geo Location under zone manager
             * if parentGeoLoctionId = 0, fetch zone(that has country as parent).
             * else fetches all the locaiton under that id
             */
            userLocationService.prototype.getGeoLocationUnderZoneManager = function (parentGeoLoctionId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'geographic-location/user/list/geolocation',
                    data: $.param({parent_id: parentGeoLoctionId})});
            };


            /** get the user list which is under given user */
            userLocationService.prototype.getUserListUnderUser = function(user_id){
                return $http({
                    method: "GET",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user-hierarchy/'+user_id
                });
            };


            userLocationService.prototype.assignRoute = function (data) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'route/assignUser',
                    data: $.param({detail: data.user_id, id_route: data.id_route})
                });
            };

            userLocationService.prototype.getDSEListInTown = function (townId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/route-dse-list',
                    data: $.param({town_id:townId})
                });
            };

            userLocationService.prototype.assignTown = function (data) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/assignTown',
                    data: $.param({detail: data.user_id, id_town: data.id_town})
                });
            };
            userLocationService.prototype.assignGeoLocation = function (data) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/attach-geo-location',
                    data: $.param({detail: data.id, location_id: data.locationId, route: data.routeFlag})
                });
            };

            return new userLocationService();
        });
})();
