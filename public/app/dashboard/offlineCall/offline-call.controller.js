(function(){

    'use strict';

    angular
        .module('app.configurations')
        .controller('OfflineController', OfflineController);


    function OfflineController(DashboardService, BaseController, $filter, API_CONFIG){

        /**
         * Declaration of the local scope variables.
         * These variables are dynamically bind to view data.
         */

        var vm = this;
        vm.objectList = [];

        /**
         * End of variables.
         */

        /**
         * Constructor OfflineController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function OfflineController() {
            BaseController.call(this, [vm.table, vm.primaryId]);
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        OfflineController.prototype = Object.create(BaseController.prototype);

        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {OfflineController}
         */
        vm.controller = new OfflineController();


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

        OfflineController.prototype.setObjectList = function () {

            DashboardService.getDetailOfflineRouteRetailOutlet(vm.controller.query).then(function(response){
                if(response.status === 200){
                    vm.objectList = response.data.data;
                    vm.listHeader = response.data.permissions;
                    vm.controller.query.total = response.data.total;
                    vm.controller.query.lastPageNo = Math.ceil(vm.controller.query.total / vm.controller.query.limit);
                }
            });
        };


        /*Sorting*/
        vm.reverse = false;
        vm.assignSortType = function (sortType) {
            vm.sortType = sortType;
            vm.reverse = (sortType !== null && vm.sortType === sortType) ? !vm.reverse : false;
            vm.objectList = $filter('orderBy')(vm.objectList, vm.sortType, vm.reverse);
        }


        var activate = function(){
            vm.controller.setObjectList();
        };

        activate();

    }
})();