(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('ActiveDseController', ActiveDseController);

    /* @ngInject */
    function ActiveDseController(BaseController, $state, $q, $timeout, $window, API_CONFIG, DashboardService, $filter, $rootScope) {

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

        function ActiveDseController() {
            BaseController.call(this, [vm.table, vm.primaryId]);

        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        ActiveDseController.prototype = Object.create(BaseController.prototype);

        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {ActiveDseController}
         */
        vm.controller = new ActiveDseController();


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

        ActiveDseController.prototype.setObjectList = function () {
            DashboardService.getActiveDse(vm.controller.query).then(function(response){
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
        };


        var activate = function(){
            vm.controller.setObjectList();
        };

        activate();


        //Download report
        vm.downloadData = function(){
            DashboardService.downloadReport('activeDse').then(function (response) {
                if (response) {
                    $window.open(window.location.origin + '/api/v2/download/report/?filename=' + response.data.filename);
                }
            });
        };




        // get successful route retail outlet
        vm.getSuccessfulDSEVisit = function(activeDSE){

            var userId = activeDSE.id_user;
            var routeId = activeDSE.id_route;


            if(!activeDSE.hasOwnProperty('children')){
                DashboardService.getSuccessfulDSEVisit(userId, routeId).then(function(response){
                    if(response.status === 200){
                        activeDSE.children = response.data.data;
                    }
                })
            }

        };



        /*/!**
         * redirect to the detail page when clicked to retail outlet.
         * @param retailoutlet
         *!/
        vm.detailView = function detailView(retailOutlet) {

            retailOutlet.id_retail_outlet = 938;

            $state.go('app.sales-route-outlet-detail', {
                retailOutletID: retailOutlet.id_retail_outlet
            });
        }*/


    }
})();