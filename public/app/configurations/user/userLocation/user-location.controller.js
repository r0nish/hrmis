(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('userLocationController', userLocationController);

    /* @ngInject */
    function userLocationController(BaseController, $scope, $q, $timeout, API_CONFIG, userLocationService, $rootScope, $filter) {
        /**
         * Declaration of the local scope variables.
         * These variables are dynamically bind to view data.
         */

        var vm = this;
        vm.objectList = [];
        vm.primaryId = 'id';
        vm.table = 'user-geographic-location';

        vm.dseGroupId = 7;

        vm.listHeader = [];

        /**
         * Constructor VisitTypeController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function userLocationController() {
            BaseController.call(this, [vm.table, vm.primaryId]);

        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userLocationController.prototype = Object.create(BaseController.prototype);


        /**Initialize dialog box**/
        $rootScope.$on('$includeContentLoaded', function () {

            $('.modal-trigger').leanModal({
                    dismissible: false, // Modal can be dismissed by clicking outside of the modal
                    opacity: .5, // Opacity of modal background
                    in_duration: 200, // Transition in duration
                    out_duration: 200, // Transition out duration
                    starting_top: '4%', // Starting top style attribute
                    ending_top: '10%', // Ending top style attribute
                    ready: function () {
                    }, // Callback for Modal open
                    complete: function () {

                    } // Callback for Modal close
                }
            );

        })


        /**
         * Custom Function not listed in the parent.
         * override is similar in the condition.
         * get the list and set to the local variable.  VisitTypeController.
         *
         */

        userLocationController.prototype.setObjectList = function () {
            userLocationService.getGeoLocationUserList(vm.controller.query).then(function (response) {
                if (response.status == 200 && response.data && !response.data.error) {
                    vm.objectList = response.data.data;
                    vm.controller.query.total = response.data.data.total;
                    vm.controller.query.lastPageNo = Math.ceil(vm.controller.query.total / vm.controller.query.limit);
                    vm.listHeader = response.data.permissions;
                }
            });
        };


        userLocationController.prototype.activateDataToCreateRoute = function (event, $event) {

        };

        $rootScope.$on('assignGeoLocation', function (event, user) {

            var object = {
                'id': user.user_id,
                'userGroupId': user.id_user_group,
                'routeFlag': user.routeFlag,
                'locationId': user.id_geographic_location
            };

            userLocationService.assignGeoLocation(object).then(function (response) {

                if (response.status == 200 && response.data && !response.data.error) {

                    vm.controller.showToast('User Location Updated');


                    /** if the route has been already assigned to previous dse, delete it */
                    if (object.routeFlag) {

                        var objectArray = $filter('filter')(vm.objectList, {geo_location_id: object.locationId});

                        if (objectArray.length > 0) {
                            var indexToRemoveDse = vm.objectList.indexOf(objectArray[0]);
                            vm.objectList.splice(indexToRemoveDse, 1);
                        }

                    }
                    /** receive the response and push to the object to the front end */
                    /*var userObject = {
                     id_user: user.user_id,
                     geo_location:user.geoLocationTitle,
                     user_group_name:user.userGroupTitle,
                     user_name:user.userTitle
                     };
                     vm.objectList.push(userObject);*/

                }
            });
        });


        /*        userLocationController.prototype.add = function (event, $event) {
         $mdDialog.show({
         templateUrl: 'app/configurations/user/userLocation/create-user-location-form.tmpl.html',
         targetEvent: $event,
         controller: 'userLocationDialogController',
         controllerAs: 'vm',
         locals: {
         dialogData: {
         title: 'Create New User Location',
         confirmButtonText: 'OK'
         },
         event: {
         title: '',
         status: false
         },
         edit: false

         }
         })
         .then(function (answer) {
         var object = {
         'id': answer.user_id,
         'userGroupId': answer.id_user_group,
         'routeFlag': answer.routeFlag,
         'locationId': answer.id_geographic_location
         };
         userLocationService.assignGeoLocation(object).then(function (response) {


         //console.log("the index value is",index);

         if (response.status == 200 && response.data && !response.data.error) {
         vm.controller.showToast("Successfully Updated");
         /!**
         * TODO
         * reflect changes to the view if it should
         *!/
         var index = vm.returnIndexFromList(answer.user_id, vm.objectList, 'id_user');


         console.log("the sample objcet fetched is ",vm.objectList[0]);


         console.log("the index value is ",index);

         console.log("the object list is ",object);

         console.log("the title is ",answer.geoAssociationText);

         if (index >= 0 ) {
         console.log("the title is ",answer.geoAssociationText);
         vm.objectList[index].geo_location = answer.geoAssociationText;
         //requires if edit/Add to be used
         //vm.objectList[index].geographic_location_id = answer.id_geographic_location
         }

         }
         });
         /!**
         * push it to the front end if the user_id is present
         *!/
         });
         };*/

        /**
         * gets the index value of object from the list
         * @type {returnIndexFromList}
         */
        vm.returnIndexFromList = returnIndexFromList;
        function returnIndexFromList(value, list, fieldName) {

            for (var count = 0; count < list.length; count++) {
                if (list[count][fieldName] == value) {
                    return count;
                }
            }
            return -1;
        }

        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {userLocationController}
         */
        vm.controller = new userLocationController();


        /**
         * Pagination. ( Required for all )
         * @type {{filter: string, limit: string, order: string, page: number, total: string}}
         */
        vm.controller.query = {
            filter: '',
            limit: API_CONFIG.dbLimit,
            order: '-id',
            page: 1,
            total: '',
            data: '',
            lastPageNo: ''
        };


        /** set the object list */
        vm.activate = function () {
            vm.controller.setObjectList();
        };

        vm.activate();


        vm.reverse = true;
        vm.assignSortType = function (sortType) {
            vm.sortType = sortType;
            vm.reverse = (sortType !== null && vm.sortType === sortType) ? !vm.reverse : false;
            vm.objectList = $filter('orderBy')(vm.objectList, vm.sortType, vm.reverse);
        }

    }
})();

