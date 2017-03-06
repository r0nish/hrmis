(function () {
    'use strict';

    angular
        .module('app.foundation')
        .run(["$rootScope", "$location", "$state", function ($rootScope, $location, $state) {

/*            $rootScope.$on("$routeChangeSuccess", function (userInfo) {
                console.log(userInfo);
            });*/
            $rootScope.$on("$stateChangeError", function (event, current, previous, eventObj, fromState) {
                if (eventObj && !eventObj.authenticated) {

                    $rootScope.returnToState = current.name;
                    /*                console.log(current
                     );*/
                    //   $rootScope.returnToState = fromState;
                   // $state.go('authentication.login');
                }
            });

            $rootScope.$on('unauthorized', function() {

                console.log("Logout Sections");

               // $state.go('authentication.login');
            });
        }]);
})();
