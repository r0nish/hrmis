(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('userGroupController', userGroupController);

    /* @ngInject */
    function userGroupController(BaseController, $scope, $q, $timeout, API_CONFIG, userGroupService, $filter, $rootScope) {

        /**
         * Declaration of the local scope variables.
         * These variables are dynamically bind to view data.
         */

        var vm = this;
        vm.objectList = [];
        vm.primaryId = 'id_user_group';
        vm.table = 'user-group';
        vm.lastPageNo = 1;

        vm.listHeader = [];


        /**
         * End of variables.
         */

        /**
         * Constructor VisitTypeController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function userGroupController() {
            BaseController.call(this, [vm.table, vm.primaryId]);

        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userGroupController.prototype = Object.create(BaseController.prototype);

        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {VisitTypeController}
         */
        vm.controller = new userGroupController();


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
            lastPageNo: ''
        };

        /**Initialize dialog box**/
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


        vm.resetDialogData = resetDialogData;
        function resetDialogData(){

            vm.item.group_name = '';
            vm.item.parent_group_id = '';
            vm.item.parent_group_title = '';

        }


        /**
         * Custom Function not listed in the parent.
         * override is similar in the condition.
         * get the list and set to the local variable.  VisitTypeController.
         *
         */

        userGroupController.prototype.setObjectList = function () {
            vm.controller.getList(vm.controller.query).then(function (response) {
                if(response){
                    vm.objectList = response.data;
                    vm.listHeader = response.permissions;
                    vm.controller.query.total = response.total;
                    vm.controller.query.lastPageNo = Math.ceil(vm.controller.query.total / vm.controller.query.limit);

                }
            })
        };


        vm.item = {
            group_name: '',
            parent_group_id: '',
            parent_group_title: ''
        };

        vm.usersGroupParent = [];
        var actionType = '';

        vm.dialogLogic = dialogLogic;
        function dialogLogic(dialogType, eventObject) {

            actionType = dialogType;

            userGroupService.getActiveList().then(function (user) {
                vm.usersGroupParent = user.data.data;
                console.log(vm.usersGroupParent)
            });


            if (dialogType == 'edit') {

                vm.item.group_name = eventObject.group_name;
                vm.item.parent_group_id = eventObject.parent_group_id;

            }

        }

        userGroupController.prototype.addOrEdit = function (index) {

            if(vm.item.parent_group_id != null){
                var parent_group =   $filter('filter')(vm.usersGroupParent,{id_user_group:vm.item.parent_group_id})[0];
                vm.item.parent_group_title = parent_group.group_name;
                console.log("Parent Group Title: ", vm.item.parent_group_title);
            }

            if(actionType == 'edit'){
                vm.controller.edit(index);
            }
            else if(actionType == 'add'){
                vm.controller.add();
            }

        }


        /*
         /!**
         * Dialog Box Display for editing Business Unit.
         * @param index
         * @param event
         * @param $event
         *!/*/

        userGroupController.prototype.edit = function (index) {

            var id = vm.objectList[index].id_user_group;
            vm.controller.editObject(id, vm.item).then(function (response) {

                if (response) {

                    vm.objectList[index].group_name = vm.item.group_name;
                    vm.objectList[index].parent_group_id = vm.item.parent_group_id;
                    vm.objectList[index].parent_group_title = vm.item.parent_group_title;

                }

                resetDialogData();

            });

        }


        /*
         /!**
         * Dialog Box Display for editing Business Unit.
         * @param index
         * @param event
         * @param $event
         *!/*/


        userGroupController.prototype.add = function () {

            vm.controller.postObject(vm.item).then(function (response) {
                if (response) {

                    vm.objectList.push(response);
                }

                resetDialogData();
            });

        }


        $scope.$on('addTodo', vm.controller.add);

        vm.controller.setObjectList();

        var toggleSwitch = function ($event, childObject) {
            vm.controller.activateDeactivate($event, childObject);
        };



        vm.changeStatus = changeStatus;
        function changeStatus(id){
            $('#'+id).prop('checked');
        }

        /*Sorting*/
        vm.reverse = true;
        vm.assignSortType = function (sortType) {
            vm.sortType = sortType;
            vm.reverse = (sortType !== null && vm.sortType === sortType) ? !vm.reverse : false;
            vm.objectList = $filter('orderBy')(vm.objectList, vm.sortType, vm.reverse);
        }

    }
})();
