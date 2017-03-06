(function () {
    'use strict';

    angular
        .module('app.configurations')
        .controller('userAccountDialogController', userAccountDialogController);

    /* @ngInject */
    function userAccountDialogController(BaseController, $scope,$state, businessUnitService, DistributorService ,userGroupService ,$mdDialog, event,dialogData, edit, userAccountService,$filter) {
        var vm = this;
        vm.cancel = cancel;
        vm.hide = hide;
        vm.dialogData = dialogData;
        vm.userGroup = [];
        vm.bu = [];
        vm.distributor = [];

        vm.data={
            business_unit_id: '',
            distributor_id: ''
        };

        vm.displayPasswordField = !edit;

        vm.item = {
            first_name: '',
            last_name: '',
            email: '',
            IMEI_number : '',
            mobile_number: '',
            user_group_id: '',
            user_group_title:'',
            user_group_label: '',
            password:''
        };

        var userRole = '';

        vm.showBU = true;

        vm.getUserGroup = getUserGroup;
        function getUserGroup(){
            userGroupService.getActiveList().then(function(response){
                vm.userGroup = response.data.data;

            });
        }

        vm.getBusinessUnit = getBusinessUnit;
        function getBusinessUnit(){
            businessUnitService.getActiveList().then(function(response) {

                vm.bu = response.data.data;

            });
        }

        vm.getDistributorForDSE = getDistributorForDSE;
        function getDistributorForDSE(){

            vm.showBU = false;
            DistributorService.getActiveList().then(function(response) {

                vm.distributor = response.data.data;

            });

        }


        vm.getDistributorByBU = getDistributorByBU;
        function getDistributorByBU(){

            DistributorService.getDistributorsForBU(vm.data.business_unit_id).then(function(response) {
                vm.distributor = response.data.data;
            });

        }


        vm.toggleBuVisibility = toggleBuVisibility;
        function toggleBuVisibility(){

            var filteredUserObject = $filter('filter')(vm.userGroup,{id_user_group: vm.item.user_group_id})[0];

            if(filteredUserObject.label == 'DSE'){
                vm.showBU = false;
            }
            else{
                vm.showBU = true;
            }

        }

        vm.activate = function(){
            vm.getBusinessUnit();
            //vm.getDistributor();
            vm.getUserGroup();
        };

        vm.activate();


        if (edit) {

            vm.item.first_name = event.first_name;
            vm.item.last_name = event.last_name;
            vm.item.email = event.email;
            vm.item.IMEI_number = event.IMEI_number;
            vm.item.mobile_number = event.mobile_number;
            vm.item.user_group_id = event.user_group_id;
            vm.item.user_group_label = event.user_group_label;
            vm.item.password = event.password;

            if(vm.item.user_group_label == 'BU'){
                userRole = 'BU';
            }
            else if(vm.item.user_group_label == 'DIS'){
                userRole = 'DIS';
            }
            else if(vm.item.user_group_label == 'STL'){
                userRole = 'STL';
            }
            else if(vm.item.user_group_label == 'DSE'){
                userRole = 'DSE';
            }

            userAccountService.getBuDistributor(event.id_user, userRole).then(function (response) {

                if(response){

                    var buID = '';
                    var distributorID = '';

                    for(var i =0; i<response.data.data.length; i++){
                        if(response.data.data[i].hasOwnProperty('business_unit_id')){
                            buID = response.data.data[i]['business_unit_id'];
                        }

                        if(response.data.data[i].hasOwnProperty('distributor_id')){
                            distributorID = response.data.data[i]['distributor_id'];
                        }
                    }

                    if(vm.item.user_group_label == 'BU'){
                        vm.data.business_unit_id = buID;

                    }
                    else{
                        vm.data.distributor_id = distributorID;

                        if(vm.item.user_group_label == 'STL' || vm.item.user_group_label == 'DIS'){
                            vm.data.business_unit_id = buID;
                        }
                    }

                    if(vm.item.user_group_label == 'DSE'){
                        vm.getDistributorForDSE();
                    }
                    else{
                        vm.getDistributorByBU();
                    }

                }

            });
        }


        function hide() {

            var filteredUserObject = $filter('filter')(vm.userGroup,{id_user_group: vm.item.user_group_id})[0];
            vm.item.user_group_title = filteredUserObject.group_name;

            if(filteredUserObject.label == 'BU'){
                userRole = 'BU';
            }
            else if(filteredUserObject.label == 'DIS'){
                userRole = 'DIS';
            }
            else if(filteredUserObject.label == 'STL'){
                userRole = 'STL';
            }
            else if(filteredUserObject.label == 'DSE'){
                userRole = 'DSE';
            }

            $mdDialog.hide({
                user: vm.item,
                bu_id: vm.data.business_unit_id,
                distributor_id: vm.data.distributor_id,
                user_role: userRole
            });
        }

        function cancel() {
            $mdDialog.cancel();
        }

        /**
         * End of variables.
         */

        /**
         * Constructor userAccountController.
         * Inherits the parent controller BaseController.
         * Reverse order at Call .. BaseController.call(vm.primaryId, vm.table ); (to defination)
         * @constructor
         */

        function userAccountDialogController() {
            BaseController.call(this,[vm.table,vm.primaryId]);
        }

        /**
         * Instance of the base controller pulled to the Child Class
         * @type {BaseController}
         */
        userAccountDialogController.prototype = Object.create(BaseController.prototype);

        vm.dialogController = new userAccountDialogController();

    }
})();
