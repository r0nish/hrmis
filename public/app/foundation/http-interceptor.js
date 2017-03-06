(function () {
    'use strict';

    angular
        .module('app.foundation')
        .config(function ($provide, $httpProvider) {
            // Intercept http calls.
            $provide.factory('MyHttpInterceptor', function ($q, $window,$rootScope) {

                $rootScope.loader ="";
                $rootScope.ActiveAjaxConectionsWithouthNotifications = 0;

                return {
                    // On request success
                    request: function (config) {

                        $rootScope.ActiveAjaxConectionsWithouthNotifications+=1;

                        if($rootScope.ActiveAjaxConectionsWithouthNotifications==1){
                           // console.log('notification:'+$rootScope.ActiveAjaxConectionsWithouthNotifications);

                            $rootScope.$broadcast('loader',true);

                        }

                       // $rootScope.$broadcast('loader',true);
                      //  $('#loading_view').show();




                      // console.log("request -> before http request success ",config);
                        // console.log(config); // Contains the data about the request before it is sent.

                        // Return the config or wrap it in a promise if blank.
                        return config || $q.when(config);
                    },

                    // On request failure
                    requestError: function (rejection) {
                       // console.log("requestError -> before http request failure",rejection);
                        // console.log(rejection); // Contains the data about the error on the request.

                        // Return the promise rejection.
                        return $q.reject(rejection);
                    },

                    // On response success
                    response: function (response) {
                      //  $rootScope.loader = false;

                        $rootScope.ActiveAjaxConectionsWithouthNotifications-=1;

                        if($rootScope.ActiveAjaxConectionsWithouthNotifications==0){

                            $rootScope.$broadcast('loader',false);

                          //  console.log('notification:'+$rootScope.ActiveAjaxConectionsWithouthNotifications);
                        }
                       // $rootScope.$broadcast('loader',false);
                      //  $('#loading_view').hide();
                      //  console.log("response from inspector response success",response);
                        // console.log(response); // Contains the data from the response.

                        // Return the response or promise.
                        return response || $q.when(response);

                    },

                    // On response failture
                    responseError: function (rejection) {
                     //   console.log("rejection after response failure",rejection);
                        // console.log(rejection); // Contains the data about the error.

                        // Return the promise rejection.
                        return $q.reject(rejection);
                    }
                };
            });

            // Add the interceptor to the $httpProvider.
            $httpProvider.interceptors.push('MyHttpInterceptor');



        });

})();
