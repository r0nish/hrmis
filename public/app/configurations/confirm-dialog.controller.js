(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('confirmDialogController', confirmDialogController);

    /* @ngInject */
    function confirmDialogController($scope, $mdDialog, dialogData) {

        var vm = this;

        vm.title = dialogData.title;

        vm.content = dialogData.content;


        $scope.hide = function () {
            $mdDialog.hide();
        };

        $scope.cancel = function () {
            $mdDialog.cancel();
        };

    }
})();

