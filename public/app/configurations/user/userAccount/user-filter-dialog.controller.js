(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('UserFilterController',UserFilterController);

    /* @ngInject */
    function UserFilterController($scope,BaseController,businessUnitService,TownService,VisitTypeService,VisitFrequencyService,VisitCategoryService,DeliveryTypeService, RouteDataShareService, $mdSidenav) {
        var vm = $scope;
        vm.data = [];
        vm.checked = true;
        vm.routes = [];
        vm.title = "Filter for Routes";
        vm.visitType = [];
        vm.visitFrequency=[];
        vm.visitCategory = [];
        vm.visitDelivery =  [];
        vm.town = [];
        vm.businessUnit = [];
        vm.selected = {
            id_route_visit_category: [],
            id_route_visit_frequency: [],
            id_route_delivery_type:[],
            id_route_visit_type: [],
            id_town:[],
            id_business_unit:[]
        }
        vm.domElement = 'categoryFilter';

        businessUnitService.getActiveList().then(function(response){
            vm.businessUnit = response.data.data;
        });

        TownService.getActiveList().then(function(response){
            vm.town = response.data.data;
        });

        VisitTypeService.getActiveList().then(function(response){
            vm.visitType = response.data.data;
        });

        VisitFrequencyService.getActiveList().then(function(response){
            vm.visitFrequency = response.data.data;

        });

        VisitCategoryService.getActiveList().then(function(response){
            vm.visitCategory = response.data.data;


        });
        DeliveryTypeService.getActiveList().then(function(response){
            vm.visitDelivery = response.data.data;

        });


        vm.filterCancelClick = filterCancelClick;
        function filterCancelClick(id){
            //reset the selected value
            $mdSidenav(id).close();
            //make vm.selected empty
            vm.selected = {
                id_route_visit_category: [],
                id_route_visit_frequency: [],
                id_route_delivery_type:[],
                id_route_visit_type: [],
                id_town:[],
                id_business_unit:[],
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
        //idName specifies visitType , visitFrequency or visitCategory
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
            RouteDataShareService.getRouteFilterData(vm.selected).then(function(response){
                RouteDataShareService.setFilterRouteList(response.data.data);
                RouteDataShareService.prepareBroadCast();

            })
        }
    }
})();