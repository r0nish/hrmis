(function () {
    'use strict';

    angular
        .module('app.print')
        .service('PrintService', PrintService);

    // PrintService.$inject = ['$http', '$q'];

    /* @ngInject */
    function PrintService($http,$q,API_CONFIG) {
        var vm = this;

        vm.baseUrl = API_CONFIG.baseUrl;

        vm.outletMapVisibitly = false;

        /** set the map visibility to true or false */
        vm.assignOutletMapVisibility = function(flag){
            vm.outletMapVisibitly = flag;
        };

        /** get outlet map visibility */
        vm.getOutletMapVisibility = function(){
            return vm.outletMapVisibitly;
        };

        vm.outletData = [];
        /** set the outlet data */
        vm.setOutletData = function(data){
            //console.log('setting ',vm.outletData);
            vm.outletData = data;
        };

        vm.headerTitle = '';
        vm.setHeaderTitle = function(title){
            //console.log('setting ',vm.outletData);
            vm.headerTitle = title;
            console.log("the header title is ",vm.headerTitle);
            //console.log("the header title is",vm.headerTitle);
        };

        vm.returnHeaderTitle = function(){
            return vm.headerTitle;
        };

        vm.resetHeaderTitle = function(){
            vm.headerTitle = '';
        };


        /** getter for outlet data */
        vm.getOutletData = function(){
            console.log("returning outlet data ",vm.outletData);
            return vm.outletData;
        };


    }
})();
