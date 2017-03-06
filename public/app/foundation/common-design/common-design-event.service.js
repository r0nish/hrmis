(function () {
    'use strict';

    angular
        .module('app.foundation')
        .service('CommonDesignEventService', CommonDesignEventService);

    //ChannelService.$inject = ['$http', '$q'];

    /* @ngInject */
    function CommonDesignEventService() {

        this.toggleInnerTableOutlet = toggleInnerTableOutlet;
        this.toggleIconOrderBy = toggleIconOrderBy;

        function toggleInnerTableOutlet(channel, $event)
        {
            ($($event.currentTarget.firstElementChild).toggleClass('close'));
            $($event.currentTarget).toggleClass('highlight');
            $('#'+channel).toggleClass('active');
        }


        function toggleIconOrderBy($event)
        {
            $('.order').addClass('close').removeClass('focus-highlight');
            $($event.currentTarget).removeClass('close').addClass('focus-highlight');
            $($event.currentTarget).toggleClass('rotate-me');
        }

    }
})();
