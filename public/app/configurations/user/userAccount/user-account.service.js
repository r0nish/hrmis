(function () {
    'use strict';

    angular
        .module('app.configurations')
        .factory('userAccountService', function (BaseServerService, $http, API_CONFIG) {
            var apiUrl = API_CONFIG.baseUrl;
            var userAccountService = function () {
                BaseServerService.constructor.call(this);
            };

            userAccountService.prototype = new BaseServerService('user');
            /**
             * Generate the list of the user on the basis of the town,geographic location and the userGroup
             * inorder to assgined user
             * @param userGroup
             * @param town
             * @param geoLocation
             * @returns {*}
             */

            userAccountService.prototype.getUserGroupWise = function (userGroup) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/group/listUsers',
                    data: $.param({user_group_id: userGroup})
                });
            };

            /** receives the parent user with associated Location*/
            userAccountService.prototype.getParentUsersWithLocation = function (childUserGroup) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/user-group-location',
                    data: $.param({id_user_group: childUserGroup})
                });
            };


            userAccountService.prototype.getUserList = function (user, userGroup, town, geoLocation) {

                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/listUsers',
                    data: $.param({
                        user_id: user,
                        user_group_id: userGroup,
                        town_id: town,
                        geographic_location_id: geoLocation
                    })
                });
            };

            /**
             * Select that principal that are not assign in that Business Unit
             * @param businessUnit
             * @returns {*}
             */
            userAccountService.prototype.assignBuDistributor = function (userId, buId, distributorId, userRole) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/assignBU',
                    data: $.param({
                        user_id: userId,
                        business_id: buId,
                        distributor_id: distributorId,
                        userRole: userRole
                    })

                });
            };

            userAccountService.prototype.editBuDistributor = function (userId, buDistributorId, userRole) {

                return $http({
                    method: "PUT",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + '/' + userId,
                    data: $.param({user_id: userId, assign_id: buDistributorId, userRole: userRole})
                });
            };

            userAccountService.prototype.getBuDistributor = function (userId, userRole) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/edit-pivot',
                    data: $.param({user_id: userId, userRole: userRole})
                });
            };

            userAccountService.prototype.assignParentUser = function (childArray) {

                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/assignParentUser',
                    data: $.param({child: childArray})

                });
            };

            userAccountService.prototype.getChildUserBUWise = function (idUser, status) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/assign-child',
                    data: $.param({id_user: idUser, status: status})

                });
            };

            userAccountService.prototype.getFilterUser = function (data) {

                var url = apiUrl + 'user/paginated-list?1=1';
                if (data.id_user_group.length > 0)
                    url += '&user_group_id=' + data.id_user_group;
                return $http.get(url);
                // });
            };

            /** get user(DSE) list under distributor */
            userAccountService.prototype.getUserUnderDistributor = function (distributorId) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'user/distributor-dse',
                    data: $.param({data: distributorId})

                });
            };

            /**get distributor list*/
            userAccountService.prototype.getDistributorUnderUser = function (userID) {
                /*var url = apiUrl+'user-distributor-sfh/' + userID;
                 return $http.get(url);*/

                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'distributor/user-business-unit',
                    data: $.param({'user_id[]': userID})
                });
            };


            /** get hte assigned distributors */
            userAccountService.prototype.getAssignedDistributor = function (userID) {
                var url = apiUrl + 'user-distributor-sfh/' + userID;
                return $http.get(url);
            };


            /** assign distributor to STL **/
            userAccountService.prototype.assignDistributor = function (userID, distributorID) {
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'assign-user-distributor-sfh',
                    data: $.param({'detail[user_id]': userID, 'detail[distributor_id][]': distributorID})
                });
            };

            return new userAccountService();
        });
})();
