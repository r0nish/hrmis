
(function(){

    angular
        .module('app')
        .controller('RosiaController', RosiaController);


    function RosiaController($scope) {

        var vm = this;

        /** loader section */
        $scope.$on('loader', function(obj, status){
            vm.loader = false;

            if(typeof status != undefined) {
                vm.loader = status;

            }

        });

    };

})();