(function () {
    'use strict';

    angular
        .module('app.print')
        .controller('PrintController', PrintController);

    /* @ngInject */
    //function PrintController(BaseController,$stateParams, VisitTypeService, businessUnitService, VisitFrequencyService, VisitCategoryService, DeliveryTypeService, $scope, RouteDataShareService, $state, $filter, $mdDialog, event, dialogData, TownService, RouteService, uiGmapGoogleMapApi) {

    function PrintController(BaseController, NgMap,PrintService,$timeout,$filter,$rootScope) {

        var vm = this;


        vm.map = '';
        /** initialise map after outlets is received */
        vm.initMap = function () {
            vm.map = NgMap.initMap('print-map');
        };

        $timeout(function () {
            vm.initMap();
        }, 1000);


        vm.data = [];


        vm.getDataList = function(){
            vm.data = PrintService.getOutletData();
            for(var count = 0 ; count < vm.data.length ; count ++){
                vm.data[count]["reference_id"] = count+1;
                console.log("the data is",vm.data);
            }
            /** sort in ascending order */
            vm.data = $filter('orderBy')(vm.data, 'reference_id', false);
        };


        vm.getDataList();


        /** trigger all the function after map has been initialised */
        vm.mapCallBack = function () {
            if(!vm.data.length){
                vm.map.setCenter({lat: 27.7172, lng: 85.3240});
                vm.map.setZoom(7);
            }

        };


        vm.chunk = function(arr, size) {
            var newArr = [];
            for (var i=0; i<arr.length; i+=size) {
                newArr.push(arr.slice(i, i+size));
            }
            return newArr;
        };

        vm.chunkData  = vm.chunk(vm.data, 4);

        vm.headerTitle = '';

        vm.setHeaderTitle = function(){
            vm.headerTitle = PrintService.returnHeaderTitle();
          //console.log("the header title is ",title);
        };

        vm.setHeaderTitle();


        vm.printDiv = function(){
            /** print the div with the class print-content*/
            window.print();

        };

        /** on cross click hide the map data broadcast
         *received by the controller of respective place
         */
        vm.hidePrintView = function(){
            $rootScope.$broadcast('hidePrintView');
        };

    }
})
();


