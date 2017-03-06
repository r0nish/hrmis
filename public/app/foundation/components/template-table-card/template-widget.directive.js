(function () {
    'use strict';

    angular
        .module('app.foundation.components')
        .directive('templateTableCard', widget);

    /* @ngInject */
    function widget($mdTheming) {
        // Usage:
        //
        // ```html
        // <widget title="'Nice Title'" subtitle="'Subtitle'" avatar="http://myavatar.jpg" title-position="top|bottom|left|right" content-padding overlay-title>content here</widget>
        // ```

        // Creates:
        //
        // Widget for use in dashboards

        var directive = {
            restrict: 'E',
            templateUrl: 'app/foundation/components/template-table-card/template-widget.tmpl.html',
            transclude: true,
            replace: true,
            scope: {
                title: '@',
                subtitle: '@',
                avatar: '@',
                header: '=',
                refmenu: '=',
                list: '=',
                refcontroller: '=',
            },
            bindToController: true,
            controller: Controller,
            controllerAs: 'vm',

            link: link
        };
        return directive;

        function link($scope, $element, attrs) {
            /*     console.log($scope.vm.list);
             return false;*/


            $scope.vm.setMenu($scope.vm.refmenu);
            // console.log($scope.vm.refcontroller);
            // $scope.vm.detailView($event);

            /*            console.log($scope.vm);
             return false;*/


            // set the value of the widget layout attribute
            $scope.vm.widgetLayout = attrs.titlePosition === 'left' || attrs.titlePosition === 'right' ? 'row' : 'column';
            // set the layout attribute for the widget content
            $scope.vm.contentLayout = angular.isUndefined(attrs.contentLayout) ? 'column' : attrs.contentLayout;
            // set if the layout-padding attribute will be added
            $scope.vm.contentPadding = angular.isDefined(attrs.contentPadding);
            // set the content align
            $scope.vm.contentLayoutAlign = angular.isUndefined(attrs.contentLayoutAlign) ? '' : attrs.contentLayoutAlign;
            // set the order of the title and content based on title position
            $scope.vm.titleOrder = attrs.titlePosition === 'right' || attrs.titlePosition === 'bottom' ? 2 : 1;
            $scope.vm.contentOrder = attrs.titlePosition === 'right' || attrs.titlePosition === 'bottom' ? 1 : 2;
            // set if we overlay the title on top of the widget content
            $scope.vm.overlayTitle = angular.isUndefined(attrs.overlayTitle) ? undefined : true;

            $mdTheming($element);

            if (angular.isDefined(attrs.class)) {
                $element.addClass(attrs.class);
            }

            if (angular.isDefined(attrs.backgroundImage)) {
                $element.css('background-image', 'url(' + attrs.backgroundImage + ')');
            }

            $scope.menuClick = function ($event) {
                if (angular.isUndefined($scope.menu.menuClick)) {
                    $scope.menu.menuClick($event);
                }
            };

            // remove title attribute to stop popup on hover
            $element.attr('title', '');
        }
    }

    /* @ngInject */
    function Controller() {
        var vm = this;
        vm.menu = null;

        vm.sortType = '';
        vm.sortReverse = false;

        // vm.loading = false;

        this.setMenu = function (menu) {
            vm.menu = menu;
        };
        //
        //this.setLoading = function (loading) {
        //    vm.loading = loading;
        //};


        /*  this.toggleInnerTable = function(channel, $event,primaryId)
         {
         vm.refcontroller.getFirstLevelHierarchy(primaryId);

         console.log(vm.refcontroller);
         ($($event.currentTarget.firstElementChild).toggleClass('close'));
         $($event.currentTarget).toggleClass('highlight');
         $('#'+channel).toggleClass('active');
         };*/

        vm.searchKey = ''
        vm.commonSearchField = '';

        this.searchKeyWord = function (searchKeyword) {

            vm.searchKey="";
            vm.searchKey = searchKeyword;

            vm.refcontroller.query.filter ='';
            if( vm.searchKey) {
                vm.commonSearchField = (typeof vm.refcontroller.query.searchField != 'undefined')?vm.refcontroller.query.searchField:'name';
                vm.refcontroller.query.filter = '&'+vm.commonSearchField+'=' + searchKeyword + '%';
            }
            vm.refcontroller.setObjectList();

        };


        this.toggleInnerTable = function (channel, $event, primaryId, list, toggleIndex, listlevel) {

            var togIndex = toggleIndex;
            vm.objectList = list;

            if (toggleIndex < 0) {
                return false;
            }

            if ( typeof vm.objectList[togIndex].children == 'number') {

                vm.refcontroller.getHierarchy(primaryId, listlevel).then(function (result) {
                    vm.objectList[togIndex].children = result;

                });
            }

            // This should be handled well TODO section. DOM Element Read.
            ($($event.currentTarget).find('label').toggleClass('close'));
            $($event.currentTarget).toggleClass('highlight');
            $('#' + channel).toggleClass('active');
        };


        this.toggleIconOrderBy = function ($event) {

            $('.order').addClass('close').removeClass('focus-highlight');
            $($event.currentTarget).removeClass('close').addClass('focus-highlight');
            $($event.currentTarget).toggleClass('rotate-me');
        };


        /**
         *
         * @type {number}
         * Set the style for each table cell.
         */

        var minColumnNo = 5;

        this.setStyleLevel1 = function(){
            if(vm.header.level1.length <= minColumnNo){

                this.styleLevel1 = {
                    "width" : 100/vm.header.level1.length + "%",
                    "padding" : "0",
                };

                return this.styleLevel1;
            }
            else{
                this.emptyStyle1 = {};
                return  this.emptyStyle1;
            }
        }

        this.setStyleLevel2 = function(){
            if(vm.header.level2.length <= minColumnNo){

                this.styleLevel2 = {
                    "width" : 100/vm.header.level1.length + "%",
                    "padding" : "0"
                };

                return this.styleLevel2;
            }
            else{
                this.emptyStyle2 = {};
                return  this.emptyStyle2;
            }
        }


        this.setStyleLevel3 = function(){
            if(vm.header.level3.length <= minColumnNo){

                this.styleLevel3 = {
                    "width" : 100/vm.header.level1.length + "%",
                    "padding" : "0"
                };

                return this.styleLevel3;
            }
            else{
                this.emptyStyle3 = {};
                return  this.emptyStyle3;
            }
        }

    }
})();