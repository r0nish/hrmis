(function () {

    'use strict';

    angular
        .module('app.foundation.components')
        .component('filterCard', {

            bindings: {
                title: '@',
                header: '=',
                refcontroller: '='
            },
            controller: Controller,
            templateUrl: 'app/foundation/components/filter-card/new-widget.tmpl.html'
        });


    function Controller($filter) {

        var vm = this;

        //Loop the variable in this section
        vm.selected = {};


        // setting for url key for filter
        vm.filterKeyMap = {};

        angular.forEach(vm.header.data, function (value, key) {
            vm.selected[value.primaryId] = [];

            vm.filterKeyMap[value.primaryId] = value.filterCriteria;
            if (value.children != undefined) {
                vm.selected[value.children.primaryId] = [];
                vm.filterKeyMap[value.children.primaryId] = value.children.filterCriteria;
            }
        });


        /**
         *
         * @param item
         * @param idName
         * @returns {boolean}
         */
        vm.isCheckBoxSelected = function (item, idName) {
            return vm.selected[idName].indexOf(item[idName]) > -1;
        };


        /**
         * @description determine if an array contains all the element from another array.
         * @param {array} subarr the array to search.
         * @param {array} arr the array providing items to check for in the subarr.
         * @return {boolean} true|false if haystack contains all items from arr.
         */
        vm.checkSubArray = function (subarr, arr) {
            return subarr.every(function (v) {
                return arr.indexOf(v) >= 0;
            });
        };


        /**
         *
         * @param item
         * @param header
         * @param parent
         * @param parentHeader
         */
        vm.toggleCheckBox = function (item, header, parent, parentHeader) {


            var idName = header.primaryId;
            var idx = vm.selected[idName].indexOf(item[idName]);

            if (idx >= 0) {
                // splice parent id.
                vm.selected[idName].splice(idx, 1);

                //splice all its children id.
                if (header.children != undefined) {
                    if (item[header.children.list].length > 0) {

                        angular.forEach(item[header.children.list], function (value, key) {
                            var id = value[header.children.primaryId];
                            var index = vm.selected[header.children.primaryId].indexOf(id);
                            if (index >= 0) {
                                vm.selected[header.children.primaryId].splice(index, 1);
                            }
                        });
                    }
                }
            }
            else {
                //push parent id.
                vm.selected[idName].push(item[idName]);

                // push all its child.
                if (header.children != undefined) {
                    angular.forEach(item[header.children.list], function (value, key) {
                        var id = value[header.children.primaryId];
                        var index = vm.selected[header.children.primaryId].indexOf(id);
                        if (index < 0) {
                            vm.selected[header.children.primaryId].push(value[header.children.primaryId]);
                        }
                    });
                }
            }

            // toggle the parent when all child are select or push parent id when all child are pushed.
            //if child has parent defined.
            if(parent != undefined){

                var parentId = parent[parentHeader.primaryId];
                var index =  vm.selected[parentHeader.primaryId].indexOf(parentId);

                var parentContains = parent[header.list].map(function(a) {return a[header.primaryId];});

                //check if parent children and selected list matches completely.
                if(vm.checkSubArray(parentContains, vm.selected[header.primaryId])){
                    if(index < 0){
                        vm.selected[parentHeader.primaryId].push(parentId);
                    }
                }
                else{
                    if(index >= 0){
                        vm.selected[parentHeader.primaryId].splice(index, 1);
                    }
                }
            }


            /** select single checkbox from complete list (eg.sbd-distribution-report - select single town) **/
            if(vm.header.table === 'sbd-distribution-report'){

                var length = vm.selected[header.primaryId].length;

                if(length > 1){
                    vm.selected[header.primaryId][0] = vm.selected[header.primaryId][length - 1];

                    vm.selected[header.primaryId].splice(0, length-1);
                }
            }


            // for post method.
            if (header.foreignId != '') {
                vm.submitFilterForm();
            }
            else {
                var filterUrl = this.refcontroller.controller.model.url + '/' + header.filter;
                vm.submitFilterFormWithoutForeignID(filterUrl, vm.selected);
            }
        };


        /**
         *
         * @type {submitFilterForm}
         * // generally for the post method. this method changes the 'filter' of query by joining 'filterCriteria'
         * sent in filter header and selected header.
         */
        vm.submitFilterForm = submitFilterForm;
        function submitFilterForm() {

            if (vm.refcontroller.controller.query) {
                vm.refcontroller.controller.query.filter = '';
                if (vm.selected) {
                    angular.forEach(vm.selected, function (value, key) {
                        if (value != "" && vm.filterKeyMap[key] != '') {
                            for (var i = 0; i < value.length; i++) {
                                vm.refcontroller.controller.query.filter += '&' + vm.filterKeyMap[key] + '=';
                                vm.refcontroller.controller.query.filter += value[i];
                            }
                        }
                    });
                }
            }

            vm.refcontroller.controller.setObjectList();
        }


        /**
         *
         * @type {submitFilterFormWithoutForeignID}
         * generally apply for the GET method filter. Filter the list by url.
         */
        vm.submitFilterFormWithoutForeignID = submitFilterFormWithoutForeignID;
        function submitFilterFormWithoutForeignID(url, selected) {

            // for order processing.
            vm.refcontroller.applyFilter(url, selected);
        }


        /**
         * reset the filter
         */
        vm.resetFilterForm = resetFilterForm;
        function resetFilterForm() {

            if (this.header.table == 'route') {
                vm.refcontroller.resetAllCheckBox();
            }

            for (var key in vm.selected) {
                vm.selected[key] = [];
            }

            //implement get method or post method
            if (vm.header.data[0].foreignId == '') {
                vm.submitFilterFormWithoutForeignID((vm.refcontroller.controller.model.url + '/' +
                vm.header.data[0].filter), vm.selected);
            }
            else {
                vm.submitFilterForm();
            }
        }


       /** data -> Parent which holds children in multiple level*/
        var towns = [];
        vm.findAllTown = function (data) {

            if (data.children != undefined) {
                if (data.children.length > 0) {
                    for (var i = 0; i < data.children.length; i++) {
                        data.children[i].checkBoxStatus = data.checkBoxStatus;
                        vm.findAllTown(data.children[i]);
                    }
                }
            }

            if (data.towns != undefined) {
                if (data.towns.length > 0) {
                    for (var i = 0; i < data.towns.length; i++) {
                        data.towns[i].checkBoxStatus = data.checkBoxStatus;
                        towns.push(data.towns[i]);
                    }
                }
            }

            return towns;
        };


        vm.setCheckBoxStatus = function (data) {
            data.checkBoxStatus = false;
        };


        /** Geogrpahic locaiton */
        vm.towns = '';
        vm.toggleGeographicCheckBox = function (data) {

            data.checkBoxStatus = !data.checkBoxStatus;
            vm.towns = vm.findAllTown(data);

            var idName = 'id_town';

            /* resetting the towns*/
            towns = [];
            vm.selected[idName] = [];

            if (data.checkBoxStatus) {
                for (var i = 0; i < vm.towns.length; i++) {
                    vm.selected[idName].push(vm.towns[i].id_town);
                }
            }
            else {
                for (var i = 0; i < vm.towns.length; i++) {
                    var index = vm.selected[idName].indexOf(vm.towns[i].id_town);
                    if (index >= 0) {
                        vm.selected[idName].splice(index, 1);
                    }
                }
            }

            var filterUrl = this.refcontroller.controller.model.url + '/' + 'filter-route';

            vm.submitFilterFormWithoutForeignID(filterUrl, vm.selected);
        };


        /**
         *
         * @param -> special case for town
         */
        vm.toggleTownBox = function (town) {

            town.checkBoxStatus = !town.checkBoxStatus;

            var idName = 'id_town';
            var idx = vm.selected[idName].indexOf(town[idName]);

            if (idx >= 0) {
                vm.selected[idName].splice(idx, 1);
            }
            else {
                vm.selected[idName].push(town[idName]);
            }

            var filterUrl = this.refcontroller.controller.model.url + '/' + 'filter-route';
            vm.submitFilterFormWithoutForeignID(filterUrl, vm.selected);
        };


        /**
         *
         * @param location
         * @returns {boolean|*}
         */
        vm.getStatus = function (location) {
            return location.checkBoxStatus;
        };


        vm.filterByDate = function () {

            if (this.header.table == 'stock-ledger') {
                vm.refcontroller.controller.setObjectList();
            }

            if (this.header.table == 'sales-order') {
                vm.refcontroller.filterSalesOrder(vm.refcontroller.dateFilter);
            }

            if (this.header.table == 'sales-return') {
                vm.refcontroller.controller.setObjectList();
            }

            if (this.header.table == 'primary-inward') {
                vm.refcontroller.controller.setObjectList();
            }

            if (this.header.table == 'sbd-distribution') {
                vm.refcontroller.controller.setObjectList();
            }

            if (this.header.table == 'sbd-distribution-report') {
                vm.refcontroller.getAllCategories();
                vm.refcontroller.getBrandList();
            }

            if(this.header.table == 'dse-productivity'){
                vm.refcontroller.controller.setObjectList(vm.header.dailyStatus);
            }

            if(this.header.table === 'channel-category-report'){
                vm.refcontroller.controller.setObjectList();
            }
        };


        vm.monthWiseFilter = function(){
            if(this.header.table == 'sbd-distribution-report'){
                this.refcontroller.periodWiseMonth.selectedPeriod.changeDate();
                vm.refcontroller.getAllCategories();
                vm.refcontroller.getBrandList();
            }

            if(this.header.table == 'sbd-distribution'){
                this.refcontroller.periodWiseMonth.selectedPeriod.changeDate();
                vm.refcontroller.controller.setObjectList();
            }
        };


        vm.search = {
            selection: ''
        }
    }
})();