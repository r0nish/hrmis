(function () {
    'use strict'
    angular
        .module('app.configurations')
        .controller('userLocationDialogController', userLocationDialogController);

    /* @ngInject */
    function userLocationDialogController(userLocationService, userGroupService, BaseController, userAccountService, DistributorService, $rootScope, $filter) {

        var vm = this;

        /** distributor list when SE/DSE is selected */
        vm.distributorList = [];

        /** core list from where user is selected to assign geolocation */
        vm.users = [];

        /** list for the geoAssociation (Route in case of DSE) */
        vm.geoAssociationList = [];

        /** Place Holder in the input field */
        vm.geoAssociationPlaceHolder = 'Geographic Association';

        /** selected parent user  in drop down */
        vm.selectedParentUser = '';

        /** selected distributor on drop down  */
        vm.selectedDistributor = '';

        /** selected user in drop down */
        vm.selectedUser = '';

        /** selected geoAssociation in drop down */
        vm.selectedGeoAssociation = '';

        /** display distributor list */
        vm.showDistributorList = false;

        /** display parent user list */
        vm.showParentUserList = false;

        vm.item = {

            id_user_group: '',

            user_id: '',

            id_geographic_location: '',

            geoLocationTitle: '',

            userTitle: '',

            userGroupTitle: '',

            /** indication to represent if route or geoGraphic location is loaded*/
            'routeFlag': false,

            /** Geo Association Represents [route , town or geographic location which is contextual,
             * need to be represented in view, so passed as parameter */
            geoAssociationText: ''

        };

        /** fetch the existing user Groups for drop down */
        vm.getUserGroups = getUserGroups;
        function getUserGroups() {
            userGroupService.getUserGroupListToAssignTerritory().then(function (response) {
                vm.userGroups = response.data.data;
            });
        }

        vm.setUserGroupId = function (groupId) {
            vm.item.id_user_group = groupId;
        };

        /** check if group id exist in user group list */
        vm.checkIfGroupIdExistInUserGroupList = function (groupId) {
            console.log("the group id is ", groupId);
            for (var count = 0; count < vm.userGroups.length; count++) {
                console.log(vm.userGroups[count].id_user_group);
                if (vm.userGroups[count].id_user_group == groupId) {
                    return true;
                }
            }
            return false;

        };

        /** get parent User group of userGroup */
        vm.getParentGroupId = function (userGroupId) {
            for (var count = 0; count < vm.userGroups.length; count++) {
                if (vm.userGroups[count].id_user_group == userGroupId) {
                    return vm.userGroups[count].parent_group_id;
                }
            }
            return false;
        };

        /** get the user Group Details */
        vm.getUserGroupDetails = function (userGroupId) {
            for (var count = 0; count < vm.userGroups.length; count++) {
                if (vm.userGroups[count].id_user_group == userGroupId) {
                    return vm.userGroups[count];
                }
            }
        };

        /** fetch the distributor list for drop down*/
        vm.fetchDistributorList = function () {
            if (vm.distributorList.length <= 0) {
                DistributorService.getActiveList().then(function (response) {
                    vm.distributorList = response.data.data;
                });
            }
        };

        /** fetch the parent user Group List for the given children userGroupList */
        vm.fetchParentUserList = function (childUserGroupId) {
            userAccountService.getParentUsersWithLocation(childUserGroupId).then(function (response) {
                vm.parentUserList = response.data.data;
            });

        };

        /** fetch all the users(DSE) under distributor */
        vm.getUserUnderDistributor = getUserUnderDistributor;
        function getUserUnderDistributor(distributor) {
            if (distributor) {
                //var distributor = JSON.parse(distributor);
                var distributorId = distributor.id_distributor;
                userAccountService.getUserUnderDistributor(distributorId).then(function (response) {
                    vm.users = response.data.data;
                })
            }
        }


        /**
         * fetch the user groups under user group
         * if(DSE -> fetch the distributors)
         * if(STL -> fetch the zone managers)
         * else(fetch users under userGroup and geoLocation)
         * @type {getHierarchyListUnderUserGroup}
         */


        vm.getHierarchyListUnderUserGroup = getHierarchyListUnderUserGroup;
        function getHierarchyListUnderUserGroup(groupId) {

            vm.users = [];

            vm.geoAssociationList = [];

            vm.distributorList = [];

            vm.parentUserList = [];

            vm.showDistributorList = false;

            vm.showParentUserList = false;

            vm.item.routeFlag = false;

            /** check if parent group id exists in user group */

            /** if parent group id exists -> fetch the parent user list */


            var userGroup = vm.getUserGroupDetails(groupId);


            /** if user group is dse fetch the distributor list */
            if (userGroup.geo_status == 1 && userGroup.label == 'DSE') {
                vm.fetchDistributorList();
                vm.showDistributorList = true;
            }

            var parentUserGroupId = vm.getParentGroupId(groupId);


            var parentGroupExistInList = vm.checkIfGroupIdExistInUserGroupList(parentUserGroupId);


            console.log("parent list exist ", parentGroupExistInList);

            /** if exist fetch all the parent Group */
            if (parentGroupExistInList) {

                var childUserGroupList = groupId;

                vm.showParentUserList = true;

                vm.fetchParentUserList(childUserGroupList);

            }

            /** fetch all the user list and user location */
            else {

                userAccountService.getUserGroupWise(groupId).then(function (response) {
                    vm.users = response.data.data;
                });

                vm.getGeoAssociationList(groupId);
            }

            vm.item.userGroupTitle = $filter('filter')(vm.userGroups, {id_user_group: groupId})[0].group_name;
        }


        /** get all the routes under distributor */
        vm.getRoutesUnderDistributor = getRoutesUnderDistributor;
        function getRoutesUnderDistributor(distributor) {
            if (distributor) {
                //var distributor = JSON.parse(distributor);
                var distributorId = distributor.id_distributor;
                userLocationService.getRouteListUnderDistributor(distributorId).then(function (response) {
                    vm.geoAssociationPlaceHolder = 'Route';
                    vm.item.routeFlag = true;
                    vm.geoAssociationList = response.data.data;
                });
            }
        }

        /** get all the geographic association under zone Manager */
        vm.getGeoGraphicAssociationUnderUser = getGeoGraphicAssociationUnderUser;
        function getGeoGraphicAssociationUnderUser(user) {
            //var zm = JSON.parse(zm);
            var parentGeoLocationId = user.geographic_location_id;
            userLocationService.getGeoLocationUnderZoneManager(parentGeoLocationId).then(function (response) {
                vm.geoAssociationList = response.data.data;
            })
        }

        /** get users Under given user manager*/
        vm.getUserListUnderUser = getUserListUnderUser;
        function getUserListUnderUser(user) {
            console.log("the user is ",user);
            /** TODO -> create backend service, find all the user list whose parent is given user*/
            //var userObject = JSON.parse(user);
            /** create the service and get user list under the user */
            //vm.getUsers(userObject.id);
            userLocationService.getUserListUnderUser(user.id).then(function(response){
                /** check the response */
                vm.users = response.data.data;
            });
        }

        /**
         * fetch general  geo association list for the user.;
         * @type {getGeoAssociationList}
         */
        vm.getGeoAssociationList = getGeoAssociationList;
        function getGeoAssociationList() {
            /** Load the geoGraphic Location */
            userLocationService.getGeoLocationList().then(function (response) {
                //vm.geoAssociationPlaceHolder = response.data.field;
                vm.geoAssociationPlaceHolder = 'Geographic Location';
                vm.item.routeFlag = false;
                vm.geoAssociationList = response.data.data;
            });

        }

        /**
         * @type {getUsers}
         * get all the users associated with user group
         */

        vm.getUsers = getUsers;
        function getUsers(groupId) {
            userAccountService.getUserGroupWise(groupId).then(function (response) {
                vm.users = response.data.data;
            });
        }

        /** set the user id to which geo location is to be assigned */
        vm.setUserId = setUserId;
        function setUserId(user) {
            if (user) {
                //user = JSON.parse(user);
                vm.item.user_id = user.id_user;
                vm.item.userTitle = $filter('filter')(vm.users, {id_user: vm.item.user_id})[0].title;
            }
        }

        /** set GeoAssociation id */
        vm.setGeoAssociationId = setGeoAssociationId;
        function setGeoAssociationId(object) {
            //var object = JSON.parse(object);

            if (object) {
                if (object.id_geographic_location) {
                    /** if object has attribute id_geographic_location */
                    vm.item.id_geographic_location = object.id_geographic_location;
                    /** filter to get the title */
                    vm.item.geoLocationTitle = $filter('filter')(vm.geoAssociationList, {id_geographic_location: vm.item.id_geographic_location})[0].title;

                }
                else {
                    vm.item.id_geographic_location = object.id;
                    vm.item.geoLocationTitle = $filter('filter')(vm.geoAssociationList, {id: vm.item.id_geographic_location})[0].title;

                }
            }
        }

        vm.resetDialogData = resetDialogData;
        function resetDialogData() {

            vm.item.id_user_group = '';
            vm.item.user_id = '';
            vm.item.id_geographic_location = '';
            vm.item.geoLocationTitle = '';
            vm.item.userTitle = '';
            vm.item.userGroupTitle = '';
            vm.item.routeFlag = false;
            vm.item.geoAssociationText = '';
            vm.selectedUser = '';
            vm.selectedDistributor = '';
            vm.selectedGeoAssociation = '';
            vm.selectedParentUser = '';
            vm.showDistributorList = false;
            vm.showParentUserList = false;

        }

        vm.hide = function () {
            $rootScope.$broadcast('assignGeoLocation', vm.item);
            vm.resetDialogData();
        };

        function userLocationDialogController() {
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userLocationDialogController.prototype = Object.create(BaseController.prototype);

        vm.dialogController = new userLocationDialogController();


        vm.activate = activate;
        function activate() {
            vm.getUserGroups();
        }

        vm.activate();

    }
})();
