(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('userDetailController', userDetailController);

    /* @ngInject */
    function userDetailController(BaseController, $stateParams, userDetailService, API_CONFIG, userLocationService, $rootScope) {

        /**
         * Declaration of the local scope variables.
         * These variables are dynamically bind to view data.
         */
        var vm = this;
        vm.objectList = [];
        vm.primaryId = 'id_user';
        vm.table = 'user';


        /** user information are stored */
        vm.user = {};


        /** obtain User Id from the State Parameters */
        vm.userId = $stateParams.userId;

        /** obtain the hierarchy List for the user */
        vm.hierarchyList = [];


        /** id to enable route Assignment {Distributor which has id value 6} */
        vm.distributorGroupId = 6;


        /** search field for the Route */
        vm.routeSearchText = '';


        /** fetch route List Under Distributor*/
        vm.routeList = [];


        /**
         * Constructor userDetailController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */



        function userDetailController() {
            BaseController.call(this, [vm.table, vm.primaryId]);
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userDetailController.prototype = Object.create(BaseController.prototype);


        /*Initialize dialog box*/
        $rootScope.$on('$includeContentLoaded', function () {

            $('.modal-trigger').leanModal({
                    dismissible: false, // Modal can be dismissed by clicking outside of the modal
                    opacity: .5, // Opacity of modal background
                    in_duration: 200, // Transition in duration
                    out_duration: 200, // Transition out duration
                    starting_top: '4%', // Starting top style attribute
                    ending_top: '10%', // Ending top style attribute
                    ready: function() {
                    } // Callback for Modal open
                    //complete: function() { } // Callback for Modal close
                }
            );

        })


        /** get the User Details
         * if user is distributor fetch all the route of town, where distributor is located
         */
        userDetailController.prototype.getUserDetail = function (userId) {
            userDetailService.getUserDetail(userId).then(function (response) {
                if (response.status == 200 && response.data && !response.data.error) {
                    vm.user = response.data.data;
                    if (vm.user.user_group_label ==  'DIS'){
                        vm.controller.fetchRoutesUnderDistributor(vm.userId);
                    }
                }
            });
        };

        /** user password */
        vm.userPassword = '';

        /** password section  */
        userDetailController.prototype.changePassword = function (password) {
            var user = {
                id: vm.userId,
                password: vm.userPassword

            };
            userDetailService.updatePassword(user).then(function (response) {
                if (response.status == 200 && response.data && !response.data.error) {
                    vm.userPassword = '';
                    vm.controller.showToast('Password Updated');
                }
            });
        };


        /*        vm.searchFlag = false;

         userDetailController.prototype.toggleSearchBar = function(){
         vm.searchFlag = !vm.searchFlag;
         };*/
        /**
         * edit the user Detail
         * @param index
         * @param event
         * @param $event
         */

        /*userDetailController.prototype.changePassword = function (user, $event) {
         $mdDialog.show({
         templateUrl: 'app/configurations/user/userAccount/userDetail/user-detail-configuration-password.tmpl.html',
         //targetEvent: $event,
         controller: 'userDetailDialogController',
         controllerAs: 'vm',
         locals: {
         dialogData: {
         title: 'Change Password',
         confirmButtonText: 'SAVE'
         },
         event: user
         }
         })
         .then(function (answer) {

         /!** set the Id to the answer *!/
         answer.id = user.id_user;

         userDetailService.updatePassword(answer).then(function (response) {
         if (response.status == 200 && response.data && !response.data.error) {
         vm.controller.showToast('Password Updated');
         }
         });
         });
         };*/

        /**
         * get user Hierarchy [all the users associated below that user]
         * @param userId
         */
        userDetailController.prototype.getUserHierarchy = function (userId) {
            userDetailService.getUserHierarchy(userId).then(function (response) {
                vm.hierarchyList = response.data.data;
            });
        };


        /** Beginning of function that is used only by distributor */

        /** dse list for given distributor */
        vm.dseList = [];

        /** DSE to be assigned to Route */
        vm.newDSEForRoute = '';

        /** route whose dse is to be changed */
        vm.routeToChangeDSE = '';

        /**
         * change the DSE for the given Route
         * @param route
         * @param $event
         */
        userDetailController.prototype.setDialogDataToChangeRoute = function (route, $event) {

            vm.newDSEForRoute = '';

            console.log("the new dse for route ");

            vm.routeToChangeDSE = route;
            if (vm.dseList.length == 0) {
                userDetailService.getUsersUnderDistributor(vm.userId).then(function (response) {
                    vm.dseList = response.data.data;
                });
            }
        };

        /** assignDSE for route */
        userDetailController.prototype.changeDSEforRoute = function (dse, route) {

            /** safely create dse object which is received as string */
            var dse = JSON.parse(dse);
            var object = {
                'id': dse.user_id,
                'locationId': route.id_route,
                'routeFlag': true
            };

            userLocationService.assignGeoLocation(object).then(function (response) {
                if (response.status == 200 && response.data && !response.data.error) {
                    vm.controller.showToast('DSE changed');
/*
                    /!** get the index of route where this particular dse has been assigned*!/
                    var indexToRemoveDSE = vm.controller.returnDSEAssignedIndex(dse.user_id);
                    if (indexToRemoveDSE >= 0) {
                        vm.routeList[indexToRemoveDSE].user_name = null;
                        vm.routeList[indexToRemoveDSE].user_id = null;
                    }*/
                    /** change to the view */
                    var indexToAssignDSE = vm.routeList.indexOf(route);
                    vm.routeList[indexToAssignDSE].user_name = dse.user_name;
                    vm.routeList[indexToAssignDSE].user_id = dse.user_id;
                }
                /** if dse is assigned to route id , set this new DSE */

            });
        };

        //assignDse


        /*userDetailController.prototype.changeDSEforRoute = function (route, $event) {
         $mdDialog.show({
         templateUrl: 'app/configurations/user/userAccount/userDetail/edit-user-route-assignment.tmpl.html',
         //targetEvent: $event,
         controller: 'editRouteAssignmentDialogController',
         controllerAs: 'vm',
         locals: {
         dialogData: {
         title: 'Edit DSE',
         confirmButtonText: 'SAVE'
         },
         event: route,
         distributorId: vm.userId
         }
         })
         .then(function (answer) {
         /!** received answer contains DSE id and Route ID, assign the DSE to that route *!/
         var object = {
         'id': answer.userId,
         'locationId': answer.routeId,
         'routeFlag': true
         };

         userLocationService.assignGeoLocation(object).then(function (response) {
         if (response.status == 200 && response.data && !response.data.error) {
         /!**
         * check the route(index in which the present DSE is assigned, delete from that route)
         *!/
         var dseRemovingIndex = vm.controller.returnDSEAssignedIndex(answer.userId);

         if (dseRemovingIndex) {
         vm.routeList[dseRemovingIndex-1].user_id = null;
         vm.routeList[dseRemovingIndex-1].user_name = null;
         }

         route.user_id = answer.userId;
         route.user_name = answer.userName;
         vm.controller.showToast('DSE Assigned');
         }

         });

         });
         };*/


        /**
         * reutns the (index+1) from where DSE is to be deleted , becaust that DSE is assigned to new Route
         * @param DSEId
         * @returns {*}
         * in order to address zero index, the value is added with 1
         */
/*        userDetailController.prototype.returnDSEAssignedIndex = function (DSEId) {

            for (var index = 0; index < vm.routeList.length; index++) {
                if (vm.routeList[index].user_id == DSEId) {
                    return index;
                }
            }
            return -1;
        };*/


        /**
         * Delete the DSE for the Given Route
         * @param route
         */

        userDetailController.prototype.deleteDSEforRoute = function (route) {

            userDetailService.deleteDSEUnderDistributorRoute(route.user_id, route.id_route).then(function (response) {

                if (response.status == 200 && response.data && !response.data.error) {
                    route.user_name = null;
                    route.user_id = null;
                    vm.controller.showToast('DSE Deleted');
                }
            });

        };


        /*userDetailController.prototype.deleteDSEforRoute = function (route, $event) {
         $mdDialog.show({
         templateUrl: 'app/configurations/confirm-dialog.tmpl.html',
         //targetEvent: $event,
         controller: 'confirmDialogController',
         controllerAs: 'vm',
         locals: {
         dialogData: {
         title: 'Delete DSE',
         content: 'Are you sure you want to delete the DSE?'
         }
         }
         })
         .then(function () {
         userDetailService.deleteDSEUnderDistributorRoute(route.user_id , route.id_route).then(function (response) {
         if (response.status == 200 && response.data && !response.data.error) {
         vm.controller.showToast('DSE Deleted');
         route.user_id = null;
         route.user_name = null;
         }
         });
         });
         };*/


        /**
         * fetch all the routes under the distributor
         * @param distributorId
         */
        userDetailController.prototype.fetchRoutesUnderDistributor = function (distributorId) {
            userDetailService.getRoutesOfDistributor(distributorId).then(function (response) {
                vm.routeList = response.data.data;
            });
        };

        /** End of function that is used only by distributor */


        vm.controller = new userDetailController();

        vm.controller.query = {
            filter: '',
            limit: API_CONFIG.dbLimit,
            order: '-id',
            page: 1,
            total: ''
        };


        /** initialise controller obtaining user Details and user Hierarchy */
        function activate() {
            vm.controller.getUserDetail(vm.userId);
            //vm.controller.getUserHierarchy(vm.userId);
        }

        activate();

    }
})();

