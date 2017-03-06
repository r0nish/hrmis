(function () {
    'use strict';
    angular
        .module('app.foundation')
        .provider('CustomDialogController', CustomDialogController);

    /* @ngInject */
    function CustomDialogController($scope, $mdDialog) {
        $scope.hide = function() {
            $mdDialog.hide();
        };

        $scope.cancel = function() {
            $mdDialog.cancel();
        };
    }
});