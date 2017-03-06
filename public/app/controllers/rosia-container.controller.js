/**
 * Created by udnbikesh on 7/21/16.
 */
(function(){

    angular
        .module('app')
        .controller('RosiaContainerController', RosiaContainerController);


    function RosiaContainerController($scope) {

        var vm = this;

        var footerheight = $('#rosia-page-footer').css('height');

        vm.rosiaContainerStyle = {
            "height": "calc(100% - " + footerheight + ")"
        };

    };

})();