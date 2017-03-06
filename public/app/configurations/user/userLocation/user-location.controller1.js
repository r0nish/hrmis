/*
(function () {
    'use strict';
    angular
        .module('app.configurations')
        .controller('userLocationController1', userLocationController1);

    /!* @ngInject *!/
    function userLocationController1($filter,$mdToast,TownService,userLocationService,GeographicLocationService,BaseController, $scope, $q, $timeout, $mdDialog,API_CONFIG,userAccountService,businessUnitService) {

        function add(event, $event) {
            vm.data = {};
            $mdDialog.show({
                    templateUrl: 'app/configurations/user/userLocation/create-user-location-form.tmpl.html',
                    targetEvent: $event,
                    controller: 'userLocationDialogController',
                    controllerAs: 'vm',
                    locals: {
                        dialogData: {
                            title: 'Create New',
                            confirmButtonText: 'OK'
                        },
                        event: {
                            title: '',
                            description: '',
                            status: false
                        },
                        edit: false
                    }
                })
                .then(function (answer) {
                    vm.data['user_id'] = answer.user_id;
                    if(answer.id_route){
                        vm.data['id_route'] = answer.id_route;
                        userLocationService.assignRoute(vm.data).then(function (response){
                            $mdToast.show(
                                $mdToast.simple()
                                    .content('Successfully Assign')
                                    .position('bottom right')
                                    .hideDelay(2000)
                            );

                        });
                    }
                    else if(answer.id_geographic_location){
                        vm.data['id_geographic_location'] = answer.id_geographic_location;

                        userLocationService.assignGeoLocation(vm.data).then(function(response){
                            $mdToast.show(
                                $mdToast.simple()
                                    .content('Successfully Assign')
                                    .position('bottom right')
                                    .hideDelay(2000)
                            );
                            return true;
                        });
                    }
                    else{
                        vm.data['id_town'] = answer.id_town;
                        userLocationService.assignTown(vm.data).then(function(response){
                            $mdToast.show(
                                $mdToast.simple()
                                    .content('Successfully Assign')
                                    .position('bottom right')
                                    .hideDelay(2000)
                            );
                            return true;
                        });
                    }
                });
        }
        $scope.$on('addTodo', add);

        var vm = this;
        vm.item = {
            title: '',
            id_town:'',
            id_route:'',
            id_geographic_location : ''

        };
        vm.item.id_town = true;
        vm.item.id_route = true;
        vm.item.id_geographic_location = true;

        userAccountService.getActiveList().then(function(response){
            vm.users = response.data.data;
        });

        $scope.changeItem = function(iem){
            vm.item.id_town = true;
            vm.item.id_route = true;
            vm.item.id_geographic_location = true;
            var userGroup = $filter('filter')(vm.users, {id_user:iem}, true)[0];
             var str = userGroup.user_group_title.toString().trim();

            var dseSearch = str.search(/DSE/i);
            var  salesSearch = str.search(/SALES REPRESENTATIVE/i);
            var  distributor  = str.search(/DISTRIBUTOR/i);

            if(dseSearch != -1 || salesSearch != -1){
              vm.item.id_route = 0;
                userLocationService.getRouteList().then(function (response){
                    vm.route = response.data.data;
                });
            }
            else if(distributor != -1)
            {
                vm.item.id_town = 0;
                TownService.getActiveList().then(function(response){
                    vm.town = response.data.data;
                });
            }
            else
            {
                vm.item.id_geographic_location = 0;
                GeographicLocationService.getActiveList().then(function(response){
                    vm.geoLocation = response.data.data;
                });
            }


        }
        vm.saveData = saveData;
        function saveData() {
            vm.route = parseInt(vm.item.id_route);
            vm.town = parseInt(vm.item.id_town);
            vm.geoLoc = parseInt(vm.item.id_geographic_location);
            vm.user = vm.item.id_user;
        }

        vm.cancel = cancel;
        function cancel(){
            vm.item.id_town = true;
            vm.item.id_route = true;
            vm.item.id_geographic_location = true;
            vm.item.id_user = null;
        }

    }
})();

*/
