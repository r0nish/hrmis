(function() {
    // 'use strict';

    angular
        .module('app.configurations')
        .directive('customTable', customTable);

    function customTable(){
        return{
            templateUrl: function(elem, attr){
                return attr.name;

            },
            // bindToController: true,
            scope:{

                data:'@'
            },
            controller : "@", // @ symbol
            name:"controllerName",
            data:"@", // controller names property points to controller.
            // bindToController: true
            // data:'='
            // alert(garbage);

        };
    }
})();