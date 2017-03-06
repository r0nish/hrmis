(function () {
    'use strict';

    angular
        .module('app.dashboard')
        .service('DashboardService', DashboardService);

    function DashboardService($http,$q,API_CONFIG) {
        var vm = this;

        vm.baseUrl = API_CONFIG.baseUrl;

        /** get the Route Details */
        this.getDashboardData = getDashboardData;
        function getDashboardData(){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/report',
                data: $.param({})

            });
        }

        /** get the Route Details */
        this.getScheduledCalls = getScheduledCalls;
        function getScheduledCalls(query){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/scheduled-call/report',
                data: $.param(query)

            });
        }

        /** get the Route Details */
        this.getCallsMade = getCallsMade;
        function getCallsMade(query){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/call-made/report',
                data: $.param(query)

            });
        }

        /** get the Route Details */
        this.getSuccessfulCalls = getSuccessfulCalls;
        function getSuccessfulCalls(query){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/success-call/report',
                data: $.param(query)

            });
        }

        /** get the Route Details */
        this.getUnsuccessfulCalls = getUnsuccessfulCalls;
        function getUnsuccessfulCalls(query){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/unsuccess-call/report',
                data: $.param(query)

            });
        }

        /** get the Route Details */
        this.getCallsNotPerformed = getCallsNotPerformed;
        function getCallsNotPerformed(query){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/call-not-made/report',
                data: $.param(query)

            });
        }

        /** get the Route Details */
        this.getActiveDse = getActiveDse;
        function getActiveDse(query){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/active-dse-info/report',
                data: $.param(query)

            });
        }


        /** get the Route Details */
        this.downloadReport = downloadReport;
        function downloadReport(item){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'download/report',
                data: $.param({dashboard:item})

            });
        }

        /**get the detail of retail outlet under route when clicked in schedule calls
         *
         */
        this.getScheduleRouteRetailOutlet = getScheduleRouteRetailOutlet;
        function getScheduleRouteRetailOutlet(routeID){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/scheduled/ro-call',
                data: $.param({route_id:routeID})
            });
        }


        /**
         *
         * get the details of the calls made
         */
        this.getDetailOfCallMadeRouteRetailOutlet = getDetailOfCallMadeRouteRetailOutlet;
        function getDetailOfCallMadeRouteRetailOutlet(routeID){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/call-made/ro-call',
                data: $.param({route_id:routeID})
            });
        }

        /**
         *
         * get the details of the calls made
         */
        this.getSuccessfulRouteRetailOutlet = getSuccessfulRouteRetailOutlet;
        function getSuccessfulRouteRetailOutlet(routeID){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/success/ro-call',
                data: $.param({route_id:routeID})
            });
        }


        /**
         *
         * get the detail of unsuccessful calls
         */
        this.getUnSuccessfulRouteRetailOutlet = getUnSuccessfulRouteRetailOutlet;
        function getUnSuccessfulRouteRetailOutlet(routeID){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/unsuccess/ro-call',
                data: $.param({route_id:routeID})
            });
        }


        /**
         *
         * get the detail of unsuccessful calls
         */
        this.getCallNotPerformedRouteRetailOutlet = getCallNotPerformedRouteRetailOutlet;
        function getCallNotPerformedRouteRetailOutlet(routeID){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/call-not-made/ro-call',
                data: $.param({route_id:routeID})
            });
        }

        /**
         *
         * get the detail of unsuccessful calls
         */
        this.getSuccessfulDSEVisit = getSuccessfulDSEVisit;
        function getSuccessfulDSEVisit(userID, routeID){
            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/active/ro-call',
                data: $.param({user_id:userID, route_id: routeID})
            });
        }


        /** get the details of offline calls
         *
         */
        this.getDetailOfflineRouteRetailOutlet = getDetailOfflineRouteRetailOutlet;
        function getDetailOfflineRouteRetailOutlet(query){

            return $http({
                method: "POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: vm.baseUrl + 'dash-board/offline/ro-call',
                data: $.param(query)
            });

        }


    }
})();