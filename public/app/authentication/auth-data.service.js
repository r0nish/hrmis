(function () {
    'use strict';

    angular
        .module('app.authentication')
        .service('AuthDataShareService', AuthDataShareService);

    /* @ngInject */
    function AuthDataShareService($window, $cookies) {
        var vm = this;

        vm.userInfo;



        vm.getUserInfo = getUserInfo;

        function getUserInfo() {

            if(vm.userInfo==null){

                // check if I have a session or the cookie.
                if($cookies.get('userInfo')){
                    var userInfo = $cookies.get('userInfo');

                    if(userInfo != null){

                        vm.userInfo = angular.fromJson(userInfo)
                        return vm.userInfo;
                    }
                }

                window.location.href ='#/login';
               // $state.go('/login')
               // $urlRouterProvider.when('', '/login');
            }
            return vm.userInfo;
        }




        vm.setUserInfo = function (userInfo) {


            vm.userInfo = userInfo;

            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate() + 1);

            $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);


            $cookies.put('userInfo', JSON.stringify(userInfo),{'expires': expireDate});


            /*if(userInfo)
            {
                $cookies.remove('userInfo');
            }*/

        };

        vm.getSession = getSession();
        function getSession() {
           // alert("Session Check");
            if ($window.sessionStorage["userInfo"]) {
                vm.userInfo = JSON.parse($window.sessionStorage["userInfo"]);
            }
        }

    }
})();
