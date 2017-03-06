(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('userAccountController', userAccountController);

    /* @ngInject */
    function userAccountController(BaseController, $scope, $state, ConfigShareService, $q, $filter,
                                   $timeout, $rootScope, API_CONFIG, userGroupService, businessUnitService, DistributorService, userAccountService) {

        /**
         * Declaration of the local scope variables.
         * These variables are dynamically bind to view data.
         */

        var vm = this;
        vm.objectList = [];

        vm.primaryId = 'id_user';
        vm.table = 'user';

        vm.lastPageNo = 1;

        vm.bu = [];

        vm.userGroup = [];

        vm.listHeader = [];


        vm.item = {

            first_name: '',
            last_name: '',
            email: '',
            IMEI_number: '',
            mobile_number: '',
            user_group_id: '',
            user_group_title: '',
            user_group_label: '',
            password: '',
            business_unit_id: '',
            distributor_id: '',
            userRole: ''

        };

        vm.showBU = true;

        /**
         * End of variables.
         */

        /**
         * Constructor userAccountController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function userAccountController() {
            BaseController.call(this, [vm.table, vm.primaryId]);
        }


        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userAccountController.prototype = Object.create(BaseController.prototype);


        /**Initialize dialog box**/
        $rootScope.$on('$includeContentLoaded', function () {

            $('.modal-trigger').leanModal({
                    dismissible: false, // Modal can be dismissed by clicking outside of the modal
                    opacity: .5, // Opacity of modal background
                    in_duration: 200, // Transition in duration
                    out_duration: 200, // Transition out duration
                    starting_top: '4%', // Starting top style attribute
                    ending_top: '10%', // Ending top style attribute
                    /*                    ready: function() {

                     }*/ // Callback for Modal open
                    //complete: function() { } // Callback for Modal close
                }
            );

        })


        vm.resetDialogData = resetDialogData;
        function resetDialogData() {

            vm.item.first_name = '';
            vm.item.last_name = '';
            vm.item.email = '';
            vm.item.IMEI_number = '';
            vm.item.mobile_number = '';
            vm.item.user_group_id = '';
            vm.item.user_group_title = '';
            vm.item.user_group_label = '';
            vm.item.password = '';
            vm.item.business_unit_id = '';
            vm.item.distributor_id = '';
            vm.item.userRole = '';


        }


        /**
         * Custom Function not listed in the parent.
         * override is similar in the condition.
         * get the list and set to the local variable.  VisitTypeController.
         *
         */

        /* userAccountController.prototype.openSidebar = function (id) {
         $mdSidenav(id).toggle();
         };*/


        userAccountController.prototype.setObjectList = function () {
            vm.controller.getList(vm.controller.query).then(function (response) {
                if(response){
                    vm.objectList = response.data;
                    vm.listHeader = response.permissions;
                    vm.controller.query.total = response.total;
                    vm.controller.query.lastPageNo = Math.ceil(vm.controller.query.total / vm.controller.query.limit);
                }
            })
        };


        vm.toggleUserGroup = toggleUserGroup;
        function toggleUserGroup() {

            var filteredUserObject = $filter('filter')(vm.userGroup, {id_user_group: vm.item.user_group_id})[0];
            vm.item.userRole = filteredUserObject.label;

            /*if (filteredUserObject.label == 'DSE') {
             vm.showBU = false;
             }
             else {
             vm.showBU = true;
             }*/

        }


        vm.getDistributorForDSE = getDistributorForDSE;
        function getDistributorForDSE() {
            vm.showBU = false;
            DistributorService.getActiveList().then(function (response) {
                vm.distributor = response.data.data;
            });
        }


        vm.getDistributorByBU = getDistributorByBU;
        function getDistributorByBU() {
            DistributorService.getDistributorsForBU(vm.item.business_unit_id).then(function (response) {
                vm.distributor = response.data.data;
            });

        }

        vm.assignUserRole = assignUserRole;
        function assignUserRole() {

            var filteredUserObject = $filter('filter')(vm.userGroup, {id_user_group: vm.item.user_group_id})[0];

            vm.item.user_group_title = filteredUserObject.group_name;

            vm.item.userRole = filteredUserObject.label;

            vm.item.user_group_label = filteredUserObject.label;

            /*console.log("the filterd user group label is ",filteredUserObject);

            if (filteredUserObject.label == 'BU') {
                vm.item.userRole = 'BU';
            }
            else if (filteredUserObject.label == 'DIS') {
                vm.item.userRole = 'DIS';
            }
            else if (filteredUserObject.label == 'STL') {
                vm.item.userRole = 'STL';
            }
            else if (filteredUserObject.label == 'DSE') {
                vm.item.userRole = 'DSE';
            }*/

        }


        userAccountController.prototype.edit = function (index) {

            assignUserRole();

            var id = vm.objectList[index].id_user;
            vm.controller.editObject(id, vm.item).then(function (response) {

                if (response) {

                    vm.objectList[index].first_name = vm.item.first_name;
                    vm.objectList[index].last_name = vm.item.last_name;
                    vm.objectList[index].email = vm.item.email;
                    vm.objectList[index].mobile_number = vm.item.mobile_number;
                    vm.objectList[index].user_group_id = vm.item.user_group_id;
                    vm.objectList[index].title = vm.item.first_name + " " + vm.item.last_name;
                    vm.objectList[index].userGrp = vm.item.user_group_title;
                    vm.objectList[index].password = vm.item.password;
                }

                resetDialogData();

            });
        }


        /*
         /!**
         * Dialog Box Display for creating user account.
         * @param index
         * @param event
         * @param $event
         *!/*/


        userAccountController.prototype.add = function () {

            //assignUserRole();

            vm.controller.postObject(vm.item).then(function (response) {
                if (response) {
                    //var id = response.id_user;

                    vm.objectList.push(response);
                    /*userAccountService.assignBuDistributor(id, vm.item.business_unit_id, vm.item.distributor_id, vm.item.user_group_label).then(function (response) {
                     return true;
                     });*/

                    resetDialogData();
                }
            });

        };

        /** set Business Unit List for dropdown */
        vm.setBusinessUnitList = function () {
            businessUnitService.getActiveList().then(function (response) {
                /** check the response over here */
                vm.bu = response.data.data;
            });
        };

        /** set the user Group List */
        vm.setUserGroupList = function () {
            userGroupService.getActiveList().then(function (response) {
                vm.userGroup = response.data.data;
            });
        };

        vm.dialogLogic = dialogLogic;
        function dialogLogic(dialogType, eventObject) {

            /** set business unit list if not fetched */
            if (!vm.bu.length) {
                vm.setBusinessUnitList();
            }
            /** set the user group if not set */
            if (!vm.userGroup.length) {
                vm.setUserGroupList();
            }

            if (dialogType == 'add') {
                //vm.assignUserRole();
            }
            else if (dialogType == 'edit') {

                vm.item.first_name = eventObject.first_name;
                vm.item.last_name = eventObject.last_name;
                vm.item.email = eventObject.email;
                vm.item.IMEI_number = eventObject.IMEI_number;
                vm.item.mobile_number = eventObject.mobile_number;
                vm.item.user_group_id = eventObject.user_group_id;
                vm.item.user_group_label = eventObject.user_group_label;
                vm.item.password = eventObject.password;
                vm.item.userRole = eventObject.user_group_label;
                //vm.assignUserRole();

                /** set the business Unit Id And Distributor Id for the given object */
                userAccountService.getBuDistributor(eventObject.id_user, vm.item.userRole).then(function (response) {

                    if (response) {
                        var buID = '';
                        var distributorID = '';

                        for (var i = 0; i < response.data.data.length; i++) {

                            if (response.data.data[i].hasOwnProperty('business_unit_id')) {
                                buID = response.data.data[i]['business_unit_id'];
                            }

                            if (response.data.data[i].hasOwnProperty('distributor_id')) {
                                distributorID = response.data.data[i]['distributor_id'];
                            }
                        }


                        if (vm.item.userRole == 'BU') {
                            vm.item.business_unit_id = parseInt(buID);

                        }
                        else {
                            vm.item.distributor_id = parseInt(distributorID);
                            if (vm.item.userRole == 'STL' || vm.item.userRole == 'DIS') {
                                vm.item.business_unit_id = parseInt(buID);
                            }
                        }


                        if (vm.item.userRole == 'DSE') {
                            /** get the distributor list for the DSE */
                            vm.showBU = false;
                            if (!vm.distributor.length) {
                                vm.getDistributorForDSE();
                            }
                        }
                        else {
                            /** get the distributor by BU */
                            vm.getDistributorByBU();
                        }
                    }

                    console.log("the user item to edit is ", vm.item);

                });

            }


        }


        /*For Assigning children users*/

        vm.users = [];

        vm.data = [];
        vm.childrenId = {};


        vm.assignChildrenUsersLogic = assignChildrenUsersLogic;
        function assignChildrenUsersLogic(eventObject) {

            userAccountService.getChildUserBUWise(eventObject.id_user, eventObject.geo_status).then(function (response) {

                if (response) {
                    vm.users = response.data.data;

                    for (var i = 0; i < vm.users.length; i++) {

                        var result = $.grep(eventObject.children, function (e) {
                            return e.id_user == vm.users[i].child_user_id;
                        });

                        if (result.length) {
                            vm.data.push(vm.users[i]);
                        }

                    }

                }
            });

        }


        vm.assignChildrenUsers = assignChildrenUsers;
        function assignChildrenUsers(index) {

            for (var i = 0; i < vm.users.length; i++) {

                var result = $.grep(vm.data, function (e) {
                    return e.child_user_id == vm.users[i].child_user_id;
                });

                if (result.length) {
                    vm.childrenId[vm.users[i].child_user_id] = vm.users[i].user;
                }
                else {
                    vm.childrenId[vm.users[i].child_user_id] = null;
                }

            }


            userAccountService.assignParentUser(vm.childrenId).then(function (response) {

                if (response) {

                    vm.objectList[index].children = [];

                    for (var i = 0; i < vm.data.length; i++) {

                        var tempObject = {
                            id_user: vm.data[i].child_user_id,
                            title: vm.data[i].title,
                            email: vm.data[i].child_email,
                            user_group_id: vm.data[i].id_user_group,
                            userGrp: vm.data[i].group_name
                        };

                        vm.objectList[index].children.push(tempObject);
                    }
                }

                vm.resetCheckedData();
            });
        }


        vm.selectedDistributor = [];
        vm.distributor = '';
        vm.userID = '';
        vm.distributorID = [];
        vm.assignedDistributor = '';
        vm.distributorID = [];

        vm.distributorAssignmentLogic = distributorAssignmentLogic;
        function distributorAssignmentLogic(eventObject) {

            userAccountService.getDistributorUnderUser(eventObject.id_user).then(function (response) {
                if (response) {
                    vm.distributor = response.data.data;

                    userAccountService.getAssignedDistributor(eventObject.id_user).then(function (response) {
                        if (response) {
                            vm.assignedDistributor = response.data.data;
                            for (var i = 0; i < vm.assignedDistributor.length; i++) {
                                var distributor = $filter('filter')(vm.distributor, {distributor_id: vm.assignedDistributor[i].distributor_id}, true)[0];
                                if (distributor) {
                                    vm.selectedDistributor.push(distributor);
                                }
                            }
                        }
                    });
                }
            });

        }


        vm.assignDistributor = assignDistributor;
        function assignDistributor(index) {

            vm.distributorID = [];
            for (var i = 0; i < vm.selectedDistributor.length; i++) {
                vm.distributorID.push(vm.selectedDistributor[i].distributor_id);
            }

            userAccountService.assignDistributor(vm.objectList[index].id_user, vm.distributorID).then(function (response) {
                if (response) {
                }

                vm.resetCheckedData();

            });

        }


        vm.toggleCheckbox = toggleCheckbox;
        function toggleCheckbox(item, list) {
            var idx = list.indexOf(item);
            if (idx > -1) {
                list.splice(idx, 1);
            }
            else {
                list.push(item);
            }

        }

        /** check if checkBox is included in the selected List */
        vm.isCheckboxChecked = isCheckboxChecked;
        function isCheckboxChecked(item, list) {
            return list.indexOf(item) > -1;
        }


        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {VisitTypeController}
         */
        vm.controller = new userAccountController();

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
            searchField: 'first_name',
            lastPageNo: ''
        };


        $scope.$on('addTodo', vm.controller.add);


        /**
         * Initialization Function that generate the List.
         * And any other initialization function in the list.
         *
         */

        function activate() {
            vm.controller.setObjectList();
        }


        function refreshData() {
            vm.query = ConfigShareService.getPaginatedList();
            activate();
        }

        $scope.$on('refreshData', refreshData);
        /** call the initial function. **/
        activate();


        /**
         *
         * @type {showToast}
         */
        /*vm.showToast = showToast;
         function showToast(content){
         $mdToast.show(
         $mdToast.simple()
         .content(content)
         .position('bottom right')
         .hideDelay(2000)
         );
         }*/

        vm.controller.searchShow = false;


        vm.detailView = function (user) {
            $state.go('app.user-detail', {
                userId: user.id_user
            });
        }

        vm.resetCheckedData = function resetCheckedData() {
            vm.data = []
            vm.selectedDistributor = [];
        }

        /*Sorting*/
        vm.reverse = true;
        vm.assignSortType = function (sortType) {
            vm.sortType = sortType;
            vm.reverse = (sortType !== null && vm.sortType === sortType) ? !vm.reverse : false;
            vm.objectList = $filter('orderBy')(vm.objectList, vm.sortType, vm.reverse);
        }


        vm.userGroup = '';
        vm.getFilterData = function(){
            userGroupService.getActiveList().then(function (response) {
                if(response){
                    vm.userGroup = response.data.data;
                }
            });
        }


        /*filter section*/
        vm.filterHeader = {

            table: 'user-account',

            data: [
                {
                    'title': 'User Group',
                    'label': '',
                    'field': 'group_name',
                    'type': 'checkbox',
                    'primaryId': 'id_user_group',
                    'foreignId': 'id_user_group',
                    'list': 'userGroup',
                    'filter': 'user_group_id',
                    'filterCriteria': 'user_group_id'
                }
            ]
        };

    }
})();
