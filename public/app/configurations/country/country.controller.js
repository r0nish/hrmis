(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('CountryController', CountryController);

    /* @ngInject */
    function CountryController(BaseController, CountryService, $filter, $rootScope, API_CONFIG) {

        var vm = this;
        vm.objectList = [];
        vm.primaryId = '';
        vm.table = 'country';

        /**
         * End of variables.
         */

        /**
         * Constructor countryController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function CountryController(){
            BaseController.call(this, [vm.table, vm.primaryId]);
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        CountryController.prototype = Object.create(BaseController.prototype);
        /**
         * Initialize the controller.
         *
         * to Use. Can be seperated.
         * @type {countryController}
         */
        vm.controller = new CountryController();
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


        /** get the data of country **/
        vm.controller.setObjectList = function(){
            vm.controller.getList(vm.controller.query).then(function(response){
                if(response.status === 200 || response.status === 'success'){
                    vm.objectList = response.data;
                    vm.controller.query.total = response.total;
                    vm.controller.query.lastPageNo = Math.ceil(vm.controller.query.total / vm.controller.query.limit);
                }
            })
        };
        vm.controller.setObjectList();


        vm.addItem = {
            'type': 'Create country',
            'countryId': '',
            'countryTitle': ''
        };


        vm.resetAddItem = function(){
            vm.addItem = {
                'type': 'Create country',
                'countryId': '',
                 'countryTitle': ''
            };
        };

        vm.countryAddItem = function(){
            var obj = {
                            'desc': vm.addItem.countryTitle,
                        };
            if(vm.addItem.type === 'Create country'){
                CountryService.postObject(obj).then(function(response){
                    if(response.status === 200){
                        vm.objectList.push(response.data.data);
                    }
                    else{
                        Materialize.toast("Error", 2000);
                    }
                    // reset add items.
                    vm.resetAddItem();
                });
            }
            else if(vm.addItem.type === 'Edit country'){
                var obj = {
                    'id_country' : vm.addItem.countryId,
                    'desc': vm.addItem.countryTitle,
                };
                CountryService.editObject(obj.id_country,obj).then(function(response){

                    if(response.data.data){
                        //editing in view
                        var country = $filter('filter')(vm.objectList, {id_country: vm.addItem.countryId}, true)[0];
                        country.desc = vm.addItem.countryTitle;
                    }

                    vm.resetAddItem();
                })
            }
        };


        /**
         *
         * @param country
         */
        vm.setEditData = function(country){
            vm.addItem.type = 'Edit country';
            vm.addItem.countryId = country.id_country;
            vm.addItem.countryTitle = country.desc;
        };


        /**Initialize dialog box**/
        $rootScope.$on('$includeContentLoaded', function () {

            $('.modal-trigger').leanModal({
                    dismissible: true, // Modal can be dismissed by clicking outside of the modal
                    opacity: 0.5, // Opacity of modal background
                    in_duration: 200, // Transition in duration
                    out_duration: 200, // Transition out duration
                    starting_top: '4%', // Starting top style attribute
                    ending_top: '10%', // Ending top style attribute
                    ready: function () {
                    }, // Callback for Modal open
                    complete: function () {
                    } // Callback for Modal close
                }
            );
        });
    }
})();