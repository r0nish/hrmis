(function(){

    'use strict';
    angular
        .module('app.dashboard')
        .controller('DashboardController', DashboardController);


    function DashboardController($scope, $interval, DashboardService, CoverageReportService, $state, $filter){

        var vm = this;

        vm.name = 'dashboard';


        vm.totalData  = {
            dataDSE: 0,
            scheduleCall: 0,
            dataCallMade: 0,
            datasuccessCall: 0,
            dataUnsuccessCall: 0,
            dataCallNotPerformed: 0,
            dataProductivity: 0,
            dataOrderReceived: 0,
            dataOrderInvoiced: 0,
            dataOrderDispatched: 0,
            activeRoute: 0,
            totalCoverage: 0,
            activeCoverage: 0,
            allDse: 0
        };



        vm.getDashboardData = function(){

            // DashboardService.getDashboardData().then(function (response) {
            //
            //     if(response.status === 200){
            //         vm.totalData = response.data;
            //
            //         vm.salesRecord = {};
            //
            //         /**
            //          * Set the Values fort the Sales Record Dashboard Values.
            //          */
            //
            //         vm.salesRecord.receive = [{"npr_price": 0}];
            //         vm.salesRecord.invoice = [{"npr_price": 0}];
            //         vm.salesRecord.dispatch = [{"npr_price": 0}];
            //         vm.salesRecord.todayReceive  = [{"npr_price": 0}] ;
            //         vm.salesRecord.todayInvoice = [{"npr_price": 0}];
            //         vm.salesRecord.todayDispatch = [{"npr_price": 0}];
            //
            //
            //         var dataSet = vm.totalData.orderValueAll;
            //
            //         var orderStatus = ["1", "2", "3"];
            //
            //         if(dataSet.length > 0 && typeof dataSet[0].order_status_id === "number"){
            //             orderStatus[0] = +orderStatus[0];
            //             orderStatus[1] = +orderStatus[1];
            //             orderStatus[2] = +orderStatus[2];
            //         }
            //
            //         vm.salesRecord.receive = $filter('filter')(dataSet, {'order_status_id': orderStatus[0]},true);
            //         vm.salesRecord.invoice = $filter('filter')(dataSet, {'order_status_id': orderStatus[1]},true);
            //         vm.salesRecord.dispatch = $filter('filter')(dataSet, {'order_status_id': orderStatus[2]},true);
            //
            //         vm.salesRecord.receive = vm.salesRecord.receive.length > 0 ? vm.salesRecord.receive: [{"npr_price": 0}];
            //         vm.salesRecord.invoice = vm.salesRecord.invoice.length > 0 ? vm.salesRecord.invoice: [{"npr_price": 0}];
            //         vm.salesRecord.dispatch = vm.salesRecord.dispatch.length > 0 ? vm.salesRecord.dispatch: [{"npr_price": 0}];
            //
            //         dataSet = vm.totalData.orderValueToday;
            //
            //         if(dataSet.length > 0 && typeof dataSet[0].order_status_id === "number"){
            //             orderStatus[0] = +orderStatus[0];
            //             orderStatus[1] = +orderStatus[1];
            //             orderStatus[2] = +orderStatus[2];
            //         }
            //
            //         vm.salesRecord.todayReceive = $filter('filter')(dataSet, {'order_status_id': orderStatus[0]},true);
            //         vm.salesRecord.todayInvoice = $filter('filter')(dataSet, {'order_status_id': orderStatus[1]},true);
            //         vm.salesRecord.todayDispatch = $filter('filter')(dataSet, {'order_status_id': orderStatus[2]},true);
            //
            //
            //         vm.salesRecord.todayReceive = vm.salesRecord.todayReceive.length ? vm.salesRecord.todayReceive: [{"npr_price": 0}];
            //         vm.salesRecord.todayInvoice = vm.salesRecord.todayInvoice.length ? vm.salesRecord.todayInvoice: [{"npr_price": 0}];
            //         vm.salesRecord.todayDispatch = vm.salesRecord.todayDispatch.length ? vm.salesRecord.todayDispatch: [{"npr_price": 0}];
            //
            //
            //         // for coverage report
            //         CoverageReportService.getCoverageReport().then(function (response) {
            //             if (response.status === 200) {
            //                 vm.totalData.totalCoverage = response.data.total_coverage;
            //                 vm.totalData.activeCoverage = response.data.total_active;
            //             }
            //         });
            //     }
            // });
        };




        vm.commaSeparateProductivity = function(dse){
            var array = dse.split(',');
            dse.name = array[0];
            dse.productivity = array[1];
        };


        /*dropdown-button*/
        vm.initializeDropDown = function(dom){
            $('.' + dom).dropdown({
                    inDuration: 300,
                    outDuration: 225,
                    constrain_width: false, // Does not change width of dropdown to that of the activator
                    hover: false, // Activate on hover
                    gutter: 0, // Spacing from edge
                    belowOrigin: true, // Displays dropdown below the button
                    alignment: 'left' // Displays dropdown with edge aligned to the left of button
                }
            );
        }

        vm.getDashboardData();


        vm.exploreData = function(item){

            if(item == 'scheduledCalls' && vm.totalData.scheduleCall > 0){
                $state.go('app.scheduledCalls');
            }
            else if(item == 'callsMade' && vm.totalData.dataCallMade > 0){
                $state.go('app.callsMade');
            }
            else if(item == 'successfulCalls' && vm.totalData.datasuccessCall > 0){
                $state.go('app.successfulCalls');
            }
            else if(item == 'unsuccessfulCalls' && vm.totalData.dataUnsuccessCall > 0){
                $state.go('app.unsuccessfulCalls');
            }
            else if(item == 'callsNotPerformed' && vm.totalData.dataCallNotPerformed > 0){
                $state.go('app.callsNotPerformed');
            }
            else if(item == 'activeDse' && vm.totalData.dataDSE > 0){
                $state.go('app.activeDse');
            }
            else if(item == 'offlineCall' && vm.totalData.offlineCall > 0){
                $state.go('app.offlineCall');
            }
            else if(item == 'coverageReport'){
                $state.go('app.coverage-report');
            }
        }

    }
})();