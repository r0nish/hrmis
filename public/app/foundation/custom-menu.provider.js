(function () {
    'use strict';

    angular
        .module('app')
        .provider('customMenu', customMenuProvider);

    function customMenuProvider()
    {

        var type;
        return {
            setType: function (value) {
                type = value;
            },
            $get: function ($http, API_CONFIG) {
                return {
                    title: $http.get(API_CONFIG.baseUrl+'generate-menu/1/1/0')
                };
            }
        };



    }

})();
