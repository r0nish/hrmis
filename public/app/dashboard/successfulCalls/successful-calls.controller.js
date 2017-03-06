(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('SuccessfulCallsController', SuccessfulCallsController);

    /* @ngInject */
    function SuccessfulCallsController(BaseController, $scope, $q, $timeout, $window, API_CONFIG, DashboardService, $filter, $rootScope) {

        /**
         * Declaration of the local scope variables.
         * These variables are dynamically bind to view data.
         */

        var vm = this;
        vm.objectList = [];
        vm.lastPageNo = 1;

        /**
         * End of variables.
         */

        /**
         * Constructor VisitTypeController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function SuccessfulCallsController() {
            BaseController.call(this, [vm.table, vm.primaryId]);

        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        SuccessfulCallsController.prototype = Object.create(BaseController.prototype);

        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {VisitTypeController}
         */
        vm.controller = new SuccessfulCallsController();


        /**
         * Pagination. ( Required for all )
         * @type {{filter: string, limit: string, order: string, page: number, total: string}}
         */
        vm.controller.query = {
            filter: '',
            limit: API_CONFIG.dbLimit,
            order: '-id',
            page: 1,
            total: '',
            lastPageNo: ''
        };


        /**
         * Custom Function not listed in the parent.
         * override is similar in the condition.
         * get the list and set to the local variable.  VisitTypeController.
         *
         */

        SuccessfulCallsController.prototype.setObjectList = function () {

            DashboardService.getSuccessfulCalls(vm.controller.query).then(function(response){
                if(response){
                    vm.objectList = response.data.data;
                    vm.listHeader = response.data.permissions;
                    vm.controller.query.total = response.data.total;
                    vm.controller.query.lastPageNo = Math.ceil(vm.controller.query.total / vm.controller.query.limit);

                }
            });
        };


        /*Sorting*/
        vm.reverse = true;
        vm.assignSortType = function (sortType) {
            vm.sortType = sortType;
            vm.reverse = (sortType !== null && vm.sortType === sortType) ? !vm.reverse : false;
            vm.objectList = $filter('orderBy')(vm.objectList, vm.sortType, vm.reverse);
        }


        var activate = function(){
            vm.controller.setObjectList();
        }

        activate();


        //Download report
        vm.downloadData = function(){
            DashboardService.downloadReport('success').then(function (response) {
                if (response) {
                    $window.open(window.location.origin + '/api/v2/download/report/?filename=' + response.data.filename);
                }
            });
        }


        // get sucessful route retail outlet
        vm.getSuccessfulRouteRetailOutlet = function(sucessfulCall){
            var routeId = sucessfulCall.id_route;

            if(!sucessfulCall.hasOwnProperty('children')){
                DashboardService.getSuccessfulRouteRetailOutlet(routeId).then(function(response){
                    if(response.status === 200){
                        sucessfulCall.children = response.data.data;
                    }
                })
            }

            vm.checkRouteID = routeId;
        }

    }
})();