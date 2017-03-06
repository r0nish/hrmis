(function () {
    'use strict'
    angular
        .module('app.configurations')
        .controller('userGroupDialogController', userGroupDialogController);

    /* @ngInject */
    function userGroupDialogController(BaseController, $scope,$state, $mdDialog, event,dialogData, userGroupService,$filter){
        var vm = this;
        vm.cancel = cancel;
        vm.hide = hide;
        vm.dialogData = dialogData;
        vm.usersGroupParent = getUserGroup();

        function getUserGroup(){
            userGroupService.getActiveList().then(function (user) {
                vm.usersGroupParent = user.data.data;
            });
        }

        vm.item = {
            group_name: '',
            parent_group_id: ''
        };


        if (event) {
            vm.item.group_name = event.group_name;
            vm.item.parent_group_id = event.parent_group_id;
            vm.item.parent_group_title = event.parent_group_title;
        }

        /////////////////////////

        function hide() {
            console.log(vm.item.parent_group_id);
            if(vm.item.parent_group_id != null){
                var parent_group_title =   $filter('filter')(vm.usersGroupParent,{id_user_group:vm.item.parent_group_id},true)[0];
                vm.item.parent_group_title = parent_group_title.group_name;
            }

            $mdDialog.hide(vm.item);
        }

        function cancel() {
            $mdDialog.cancel();
        }

        /**
         * End of variables.
         */

        /**
         * Constructor userGroupController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function userGroupDialogController() {
            BaseController.call(this,[vm.table,vm.primaryId]);
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userGroupDialogController.prototype = Object.create(BaseController.prototype);

        vm.dialogController = new userGroupDialogController();


    }
})();
