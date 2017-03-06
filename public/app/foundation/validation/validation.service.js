(function () {
    'use strict';

    angular
        .module('app.foundation')
        .service('ValidationService', ValidationService);

    /* @ngInject */
    function ValidationService() {
        var vm = this;

        vm.displayMessage = displayMessage;
        vm.displayRequiredMessage = displayRequiredMessage;

        var formName, inputContainer, inputName, messagesDivWrapper, innerMessageDiv, innerMessageSpan;

        /**
         * HOW TO USE THIS SERVICE
         *
         *
         *
         *
         * { required
         *  ng-minlength = '3'
         *  } /** These are validation according to the Input Field or Form Field
         *  ng-keyup="vm.controller.validateForm($event)"
         *  ng-focus="vm.controller.validateEmptyForm('Email', $event)
         *
         *
         *
         *
         * Display Text for the instance of model. eg. Business Unit.
         * eg. Enter the Business Unit
         * where Business Unit is the Display Text
         *
         *
         * Usages . validateForm('Title', $event) in form if validateFrom is in the controller.
         *
         *             ValidationService.displayMessage('displayText', $event);
         *
         *
         * @param displayText
         * @param $event
         */

        function initializeElements($event){

            if(!($($event.currentTarget).closest('md-input-container').find(".messagesDivWrapper").length)){
                formName = $($event.currentTarget).closest('form').attr('name');
                inputContainer = $($event.currentTarget).closest('md-input-container');
                inputName = $($event.currentTarget).attr('name');
                messagesDivWrapper = $("<div>", {class: "messagesDivWrapper"});
                messagesDivWrapper.attr('ng-messages',formName + '.' + inputName + '.$error');
                inputContainer.append(messagesDivWrapper);

                innerMessageDiv = $("<div>", {class: "innerMessageDiv"});
                messagesDivWrapper.append(innerMessageDiv);
                innerMessageSpan = $("<span>", {class: "innerMessageSpan"});
                innerMessageDiv.append(innerMessageSpan);
            }

        }

        function displayRequiredMessage(displayText, $event){

            initializeElements($event);

            if($($event.currentTarget).hasClass('ng-invalid-required')){
                vm.updateElement(messagesDivWrapper, innerMessageDiv);
                innerMessageDiv.attr('ng-message','required');
                innerMessageSpan.text('Please Enter The ' + displayText);
            }

        }

        function displayMessage($event){

            initializeElements($event);

            var currentMessagesDivWrapper = $($event.currentTarget).closest('md-input-container').find(".messagesDivWrapper");
            var currentInnerMessageDiv = $($event.currentTarget).closest('md-input-container').find(".innerMessageDiv");
            var currentInnerMessageSpan = $($event.currentTarget).closest('md-input-container').find(".innerMessageSpan");


            if($($event.currentTarget).hasClass('ng-invalid-required')){
                vm.updateElement($event);
                currentInnerMessageDiv.attr('ng-message','required');
                currentInnerMessageSpan.text('Must not be empty');
            }
            else if($($event.currentTarget).hasClass('ng-invalid-number')){
                vm.updateElement($event);
                currentInnerMessageDiv.attr('ng-message','number');
                currentInnerMessageSpan.text('Must contain numbers');
            }
            else if($($event.currentTarget).hasClass('ng-invalid-email')){
                vm.updateElement($event);
                currentInnerMessageDiv.attr('ng-message','email');
                currentInnerMessageSpan.text('Invalid email');
            }
            else if($($event.currentTarget).hasClass('ng-invalid-minlength')){
                var innerMessageValue = $($event.currentTarget).attr('ng-minlength');
                vm.updateElement($event);
                currentInnerMessageDiv.attr('ng-message','minlength');
                currentInnerMessageSpan.text('Must be at least ' + innerMessageValue + ' characters');
            }
            else if($($event.currentTarget).hasClass('ng-invalid-maxlength')){
                var innerMessageValue = $($event.currentTarget).attr('ng-maxlength');
                vm.updateElement($event);
                currentInnerMessageDiv.attr('ng-message','maxlength');
                currentInnerMessageSpan.text('Must be ' + innerMessageValue + ' characters at most');
            }
            else if($($event.currentTarget).hasClass('ng-invalid-pattern')){
                vm.updateElement($event);
                currentInnerMessageDiv.attr('ng-message','pattern');
                currentInnerMessageSpan.text('Must not contain special characters');
            }

            else {
                messagesDivWrapper.removeClass('ng-active');
                messagesDivWrapper.addClass('ng-inactive');
                messagesDivWrapper.attr('aria-live','assertive');
                currentInnerMessageDiv.removeClass('ng-scope');
                currentInnerMessageSpan.text('');
            }

            if($($($event.currentTarget).closest('div')).hasClass('password-validation-wrapper')){

                var passwordfield1 = $($event.currentTarget).closest('.password-validation-wrapper').find('input').get(0);
                var passwordfield2 = $($event.currentTarget).closest('.password-validation-wrapper').find('input').get(1);

                var currentInnerMessageDivForPassword = $($event.currentTarget).closest('.password-validation-wrapper').find('#confirm-password-field').find('.innerMessageDiv');
                var currentInnerMessageSpanForPassword = $($event.currentTarget).closest('.password-validation-wrapper').find('#confirm-password-field').find('.innerMessageSpan');

                 if(passwordfield1.value == passwordfield2.value){
                     currentInnerMessageDivForPassword.attr('ng-message','');
                     currentInnerMessageSpanForPassword.text('');
                 }
                 else{
                     currentInnerMessageDivForPassword.attr('ng-message','passwordMatch');
                     currentInnerMessageSpanForPassword.text('The passwords don\'t match');
                 }
            }
        }

        vm.updateElement = updateElement;
        function updateElement($event){
            var currentMessagesDivWrapper = $($event.currentTarget).closest('md-input-container').find(".messagesDivWrapper");
            var currentInnerMessageDiv = $($event.currentTarget).closest('md-input-container').find(".innerMessageDiv");

            currentMessagesDivWrapper.removeClass('ng-inactive');
            currentMessagesDivWrapper.addClass('ng-active');
            currentMessagesDivWrapper.attr('aria-live','assertive');
            currentInnerMessageDiv.addClass('ng-scope');
        }
    }
})();