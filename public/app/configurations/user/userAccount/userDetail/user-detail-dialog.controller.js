(function () {
    'use strict';

    angular
        .module('app.configurations')
        .controller('userDetailDialogController', userDetailDialogController);

    /* @ngInject */
    function userDetailDialogController(BaseController,$mdDialog, event, dialogData) {
        var vm = this;
        vm.cancel = cancel;
        vm.hide = hide;
        vm.dialogData = dialogData;

        vm.item = {
            email:'',
            password:'',
            confirmPassword:''
        };

        if (event) {
            vm.item.email = event.email;
        }


        function hide() {
            /** check If password and confirm password Mismatch */
            if(vm.item.password != vm.item.confirmPassword){
                vm.dialogController.showToast('Password Mismatch');
            }
            else{
                $mdDialog.hide(vm.item);
            }
        }

        function cancel() {
            $mdDialog.cancel();
        }

        vm.activate = function () {

        };

        vm.activate();

        /**
         * End of variables.
         */

        /**
         * Constructor userAccountController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function userDetailDialogController() { }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userDetailDialogController.prototype = Object.create(BaseController.prototype);

        vm.dialogController = new userDetailDialogController();

    }
})();
