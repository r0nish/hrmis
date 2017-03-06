/** Controller for the Login section
 *  Uses the Base Foundation for the Login Detail Executions. *
 *
 *  BaseController from the Foundation
 */
(function() {
    'use strict';

    angular
        .module('app.authentication')
        .controller('LoginController', LoginController);

    /* @ngInject */

    /**
     *
     * BaseController from the Foundation Module.
     *
     * @param BaseController
     * @param $state
     * @constructor
     */

    function LoginController(BaseController,$state, AuthService, $rootScope, $window, AuthDataShareService,API_CONFIG,$location) {

        var vm = this;
        vm.table = '';
        vm.primaryId = '';

        var vm = this;
      //  vm.loginClick = loginClick;
        vm.loginFailed = false;
        vm.errorMessage = '';
        // create blank user variable for login form
        vm.user = {
            email: '',
            password: ''

        };

        vm.userInfo;

        /**
         * Constructor for the LoginController
         * Inherits the parent BaseController.
         *
         * @constructor
         */

        function LoginController()
        {
            BaseController.call(this, [vm.table, vm.primaryId]);
        };


        /**
         * Instance to the base Controller set to LoginController
         *
         * Change . Please refer to the website for the cause.
         * http://blog.revolunet.com/blog/2014/02/14/angularjs-services-inheritance/
         * @type {BaseController}
         */

        LoginController.prototype = Object.create(BaseController.prototype);
        //LoginController.prototype.constructor = BaseController;

        LoginController.prototype.logoutClick = function() {



            AuthDataShareService.setUserInfo(userInfo);

            AuthService.logout()
                .then(function(response){

                    if(response.error){
                        vm.loginFailed = true;

                        vm.errorMessage = response.error.message[0];

                    }
                    else if(!response.error){
                        if($rootScope.returnToState){
                            $state.go($rootScope.returnToState);
                        }
                        $state.go('app.dashboard');
                    }


                    else{}
                },function(error){
                });
        };

        /** login through the enter key press */
        LoginController.prototype.loginThroughEnterKey = function(keyEvent){
          if(keyEvent.keyCode == 13){
             vm.controller.loginClick();
          }
        };


        /** Login Click Section Prototyping **/


        LoginController.prototype.loginClick = function() {
           // $state.go('app.dashboard');

            /**
                 * checking if username-password match, mismatch ;
                 * also checking if the promise not fulfilled;
                 */
                  AuthService.login(vm.user.email, vm.user.password)
                    .then(function(response){

                        console.log(response);
                        //if(response.status != 'success'){
                            if(response.accessToken === undefined){

                                vm.loginFailed = true;
/*                            vm.user.email = '';
                            vm.user.password = '';*/
                            vm.errorMessage = '* Login credential error';

                            /** TODO  Make the alert to fit in the form  to show the error**/

                           // alert(vm.errorMessage);
                            return false;

                        }
                        else{
                            if($rootScope.returnToState){
                                $state.go($rootScope.returnToState);
                            }

                           // $window.open('http://rosiav2.local/download');
                           // window.location = window.location.origin+'/download;
                                $state.go('app.dashboard');

                        }
                    },function(error){
                        console.log(" network error occur here ",error);
                    });

        };

        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {LoginController}
         */

        vm.controller = new LoginController();
        vm.controller.const = BaseController.const;

    }
})();