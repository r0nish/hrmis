(function () {
    'use strict';

    angular
        .module('app.configurations')
        .controller('editRouteAssignmentDialogController', editRouteAssignmentDialogController);

    /* @ngInject */
    function editRouteAssignmentDialogController(BaseController, $mdDialog, event, dialogData, distributorId, userDetailService) {
        var vm = this;
        vm.cancel = cancel;
        vm.hide = hide;
        vm.dialogData = dialogData;

        /** sets the distributor Id*/
        vm.distributorId = distributorId;

        vm.item = {
            routeId: '',
            title: '',
            userId: '',
            userName: ''
        };

        /**
         * search Text for the Users
         * @type {string}
         */
        vm.userSearchText = '';

        /**
         * users array
         * @type {Array}
         */
        vm.users = [];

        if (event) {
            vm.item.title = event.title;
            vm.item.routeId = event.id_route;
            vm.userSearchText = event.user_name;
        }


        vm.setUserIdforGivenRoute = function (user) {
            if (user) {
                vm.item.userId = user.user_id;
                vm.item.userName = user.user_name;
            }
        };


        function hide() {
            $mdDialog.hide(vm.item);
        }

        function cancel() {
            $mdDialog.cancel();
        }


        /**
         * End of variables.
         */

        /**
         * Constructor userAccountController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function editRouteAssignmentDialogController() { }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        editRouteAssignmentDialogController.prototype = Object.create(BaseController.prototype);


        /**
         * obtain all the DSE(users associated to the given distributors)
         * @param distributorId
         */
        editRouteAssignmentDialogController.prototype.getUsersUnderDistributor = function (distributorId) {
            /**
             * calls the service to get all the DSE(users associated to given Distributor);
             */
            userDetailService.getUsersUnderDistributor(distributorId).then(function (response) {
                vm.users = response.data.data;
            });
        };

        vm.dialogController = new editRouteAssignmentDialogController();

        /** activate getting users account */
        vm.activate = function () {
            vm.dialogController.getUsersUnderDistributor(vm.distributorId);
        };

        vm.activate();
    }
})();
