(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('UserFilterController',UserFilterController);

    /* @ngInject */
    function UserFilterController($scope,$http,ConfigShareService,BaseController,RouteDataShareService,userAccountService,userGroupService,businessUnitService, $mdSidenav, API_CONFIG) {
        var vm = this;
        vm.data = [];
        vm.checked = true;
        vm.routes = [];
        vm.title = "Filter Criteria";
        vm.objectList = [];
        vm.userGroupLength = [];
        vm.primaryId = 'id_user';
        vm.table = 'user';
        vm.userGroup = [];
        vm.selected = {
            id_user_group:[]
        }
        vm.query = {
            filter: '',
            limit: API_CONFIG.dbLimit,
            order: '-id',
            page: 1,
            total : ''
        };

        function UserFilterController() {
            BaseController.call(this, [vm.table, vm.primaryId]);
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        UserFilterController.prototype = Object.create(BaseController.prototype);


        vm.controller = new UserFilterController();

        vm.baseUrl = API_CONFIG.baseUrl;
        vm.domElement = 'categoryFilter';

       userGroupService.getActiveList().then(function (response) {
                vm.userGroup = response.data.data;
                vm.userGroupLength = response.data.data.length;
            });


        vm.filterCancelClick = filterCancelClick;
        function filterCancelClick(id){
            //reset the selected value
            $mdSidenav(id).close();
            //make vm.selected empty
            vm.selected = {
                id_user_group: []
            }
            $('.inner-table').css('display', 'none');
            //close all dom element

        }
        /** #### END OF  DATA VARIABLES FUNCTION ####### ***/

        vm.toggleInnerTableOutlet = toggleInnerTableOutlet;
        function toggleInnerTableOutlet(domElement, selectedTitle, $event) {
            $('#' + domElement).slideToggle("slow"); // toggleClass('hide');
            vm.selected[selectedTitle] = [];
        }

        vm.toggle = toggle;
        function toggle(item,idName) {
            var idx = vm.selected[idName].indexOf(item[idName]);
            if (idx >= 0) {
                vm.selected[idName].splice(idx, 1);
            }
            else {
                vm.selected[idName].push(item[idName]);
            }
        }
        vm.exists = exists;
        vm.exists = exists;
        function exists(item,idName) {
            return vm.selected[idName].indexOf(item[idName]) > -1;
        }
        vm.filterClick = filterClick;
        function filterClick(){
            if(vm.selected.id_user_group.length>0){
                vm.query.filter = '&user_group_id=';
                vm.query.filter += vm.selected.id_user_group;
            }
            ConfigShareService.setPaginatedList(vm.query);
            ConfigShareService.prepareBroadCast();
        };
    }
})();