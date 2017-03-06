(function () {
    'use strict';

    angular
        .module('app.foundation')
        .factory('BaseController', function (CommonDesignEventService, BaseServerService, API_CONFIG, $q, $timeout, $state, $rootScope) {


            // var model = '';//new BaseServerService('business-unit');
            var responseObject = '';


            function BaseController(data) {
                this.primaryId = data[1];
                this.model = new BaseServerService(data[0]);
            }

            BaseController.prototype.getList = function (query) {

                var promise = this.model.getList(query).then(function (response) {
                    if (response != 'error') {
                        return response.data;
                    } else {
                        return false;
                    }
                });
                return promise;
            };


            /**
             * for pagination
             * @param direction
             */
            BaseController.prototype.onPageChange = function (direction) {

                if (direction === 'left') {
                    if (this.query.page > 1) {
                        this.query.page--;
                        this.setObjectList();
                    }
                }

                if (direction === 'right') {
                    if (this.query.page < this.query.lastPageNo) {
                        this.query.page++;
                        this.setObjectList();
                    }
                }
            }

            BaseController.prototype.setDataOnStartPage = function () {
                this.query.page = 1;
                this.setObjectList();
            }


            BaseController.prototype.setDataOnEndPage = function () {
                this.query.page = this.query.lastPageNo;
                this.setObjectList();
            }


            BaseController.prototype.showToast = function (content) {
                Materialize.toast(content, 2000);
            };


            BaseController.prototype.editObject = function (id, object) {

                var promise = this.model.editObject(id, object).then(function (response) {
                    if (response.status == 200 && response.data && !response.data.error) {
                        Materialize.toast('Sucessfully Posted', 2000);
                        return response.data.data;
                    }
                    else if (response.status == 200 && response.data && response.data.error) {
                        Materialize.toast('Error', 2000);
                        return false;
                    }
                    else if (response.status != 200) {
                        Materialize.toast('Error', 2000);
                        return false;
                    }
                    else {

                    }
                });
                return promise;
            }

            BaseController.prototype.postObject = function (object) {
                var promise = this.model.postObject(object).then(function (response) {
                    if (response.status == 200 && response.data && !response.data.error) {
                        Materialize.toast('Sucessfully Posted', 2000);
                        return response.data.data;
                    }
                    else if (response.status == 200 && response.data && response.data.error) {
                        Materialize.toast('Error', 4000);
                        return false;

                    }
                    else if (response.status != 200) {
                        Materialize.toast('Error', 4000);
                        return false;
                    }
                    else {

                    }
                });

                return promise;
            }

            /** delete the object */
            BaseController.prototype.deleteObject = function (id) {
                var promise = this.model.deleteObject(id).then(function (response) {
                    if (response.status == 200 && response.data && !response.data.error) {
                        Materialize.toast('Sucessfully deleted', 2000);
                        return response.data.data;
                    }
                    else if (response.status == 200 && response.data && response.data.error) {
                        Materialize.toast('Error', 4000);
                        return false;

                    }
                    else if (response.status != 200) {
                        Materialize.toast('Error', 4000);
                        return false;
                    }
                    else {

                    }
                });

                return promise;
            };

            BaseController.prototype.toggleIconOrderBy = function ($event) {

                $('.order').addClass('close').removeClass('focus-highlight');
                $($event.currentTarget).removeClass('close').addClass('focus-highlight');
                $($event.currentTarget).toggleClass('rotate-me');

            }


            BaseController.prototype.toggleInnerTableOutlet = function (domElement, $event) {

                ($($event.currentTarget.firstElementChild).toggleClass('close'));
                $($event.currentTarget).toggleClass('highlight');
                $('#' + domElement).toggleClass('active');
            };


            BaseController.prototype.openSidebar = function (id) {
                $mdSidenav(id).toggle();
            };


            var validationLogic = function (elem) {

                if (elem.hasClass('ng-invalid')) {
                    elem.removeClass('valid').addClass('invalid');
                }
                else {
                    elem.removeClass('invalid').addClass('valid');
                }

                if (elem.hasClass('ng-invalid-required')) {
                    elem.closest('.input-field').find('label:first').attr('data-error', 'Must not be empty');
                }
                else if (elem.hasClass('ng-invalid-pattern')) {
                    elem.closest('.input-field').find('label:first').attr('data-error', 'Special characters are not allowed');
                }
                else if (elem.hasClass('ng-invalid-minlength')) {
                    var minLength = elem.attr('ng-minlength');
                    elem.closest('.input-field').find('label:first').attr('data-error', 'Minimum length must be ' + minLength);
                }
                else if (elem.hasClass('ng-invalid-maxlength')) {
                    var maxLength = elem.attr('ng-maxlength');
                    elem.closest('.input-field').find('label:first').attr('data-error', 'Maximum length must be ' + maxLength);
                }

            }

            var validateForm = function () {

                $('input').each(function () {
                    var elem = $(this);

                    // Save current value of element
                    elem.data('oldVal', elem.val());

                    // Look for changes in the value
                    elem.bind("propertychange change click keyup input paste", function (event) {
                        // If value has changed...
                        if (elem.data('oldVal') != elem.val()) {

                            validationLogic(elem);

                            // Updated stored value
                            elem.data('oldVal', elem.val());

                            // Do action

                        }
                    });

                    elem.blur(function () {
                        validationLogic(elem);

                        $(elem).closest('.input-field').find('label:first').addClass('active');
                    });

                });

            }


            /*JQUERY CODES FOR ELEMENTS*/

            function activateDomElements() {

                $(document).ready(function () {

                    /*                    $('.datepicker').pickadate({
                     container: 'body',
                     selectMonths: true, // Creates a dropdown to control month
                     selectYears: 15 // Creates a dropdown of 15 years to control year
                     });*/

                    $timeout(function () {
                        $('.materialboxed').materialbox();
                    }, 2000);


                    $('select').material_select();

                    $('label').addClass('active');

                    var dropdownButton = $('.dropdown-button');

                    dropdownButton.dropdown({
                            inDuration: 100,
                            outDuration: 100,
                            constrain_width: false, // Does not change width of dropdown to that of the activator
                            hover: false, // Activate on hover
                            gutter: 0, // Spacing from edge
                            belowOrigin: true, // Displays dropdown below the button
                            alignment: 'right' // Displays dropdown with edge aligned to the left of button
                        }
                    );

                    dropdownButton.click(function () {
                        var clickedTrigger = $(this);
                        var dropdownID = clickedTrigger.attr('data-activates');
                        $('.dropdown-button').not(clickedTrigger).removeClass('active');
                        $('.dropdown-content').not('#' + dropdownID).css('display', 'none').removeClass('active');
                    });


                    var dropdownContent = $('.dropdown-content');

                    dropdownContent.click(function () {
                        dropdownContent.removeClass('active').css('display', 'none');
                    });


                    $('.collapsible').collapsible({
                        // A setting that changes the collapsible behavior to expandable instead of the default accordion style
                        //accordion : false
                    });


                    $('.tooltipped').tooltip({delay: 50});

                    validateForm();

                });
            }

            $rootScope.$on('$includeContentLoaded', function () {
                activateDomElements();
            })


            /*Collapse collapsible*/
            BaseController.prototype.collapseCollapsible = function () {
                $(".collapsible-header").removeClass('active');
                $(".collapsible").collapsible({accordion: true});
                $(".collapsible").collapsible({accordion: false});
            };


            BaseController.prototype.filterSidebarStyle = function () {

                /*Defining Filter sidenav properties*/
                var headerHeight = $('.top-nav').css('height');

                return {
                    "height": "calc(100% - " + headerHeight + ")",
                    "top": headerHeight
                };

            }


            /** returns the array containing value of selected checkbox for given div(with divId) */
            BaseController.prototype.returnSelectedCheckBoxValues = function (divId) {
                var checkedBoxValue = [];

                $("#" + divId).find("input:checked").each(function (i, ob) {
                    checkedBoxValue.push($(ob).val());
                });

                return checkedBoxValue;
            };


            /**
             * redirect to the retail outlet detail page on dashboard.
             * @param retailOutlet
             */
            BaseController.prototype.detailView = function(retailOutlet){

                $state.go('app.sales-route-outlet-detail', {
                    retailOutletID: retailOutlet.retail_outlet_id
                });
            };


            return BaseController;
        });


})();
