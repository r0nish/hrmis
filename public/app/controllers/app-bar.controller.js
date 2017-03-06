/**
 * Created by ruban on 7/29/16.
 */

(function() {
    'use strict';

    angular
        .module('app')
        .controller('AppBarController', AppBarController);

    /* @ngInject */
    function AppBarController($window, $http, API_CONFIG, $scope, AuthDataShareService) {

        var vm = this;

        vm.logoutClick = logoutClick;
        function logoutClick() {

            $window.sessionStorage["userInfo"]=null;

            vm.baseUrl = API_CONFIG.baseUrl;

            $http.get(vm.baseUrl + 'logout').
            then(function (response) {

                window.location.href ='#/login';
                // $urlRouterProvider.when('', '/login');
            });

        }

        vm.userInfo = AuthDataShareService.getUserInfo().user;

    }
})();

