/**
 * Created by udnbikesh on 7/21/16.
 */
(function(){

    angular
        .module('app.navigation')
        .controller('NavigationController', NavigationController);


    function NavigationController(NavigationService, BaseController,$scope) {
        var vm = this;

        vm.primaryId = '';

        vm.table = '';

        vm.menuItems = [];


        function NavigationController() {
            BaseController.call(this, [vm.table, vm.primaryId]);
        }

        NavigationController.prototype = Object.create(BaseController.prototype);

        /** Fetch the active order status (like invoiced, dispatched , received). */
        NavigationController.prototype.getMenuList = function () {

            NavigationService.getMenuList().then(function (response) {

                vm.menuItems = response.data.data;

            });
        };

        vm.controller = new NavigationController();



        function activate()
        {
            (vm.controller.getMenuList());

        }

        activate();

        var headerHeight = $('.top-nav').css('height');

        vm.rosiaSidebarStyle = {
            "height": "calc(100% - " + headerHeight + ")",
            "top": headerHeight
        };

    };

})();

