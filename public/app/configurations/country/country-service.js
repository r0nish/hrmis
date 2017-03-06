(function () {
    'use strict';

    angular
        .module('app.configurations')
        .factory('CountryService', function (BaseServerService, $http, API_CONFIG) {

            var apiUrl = API_CONFIG.baseUrl;

            var CountryService = function () {
                BaseServerService.constructor.call(this);
            };

            CountryService.prototype = new BaseServerService('country');


            /**
             * add data to country table.
             * @param data
             */
            CountryService.prototype.addCountry = function(data){

                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + '',
                    data: $.param(data)
                });
            };


            /**
             *
             * @param data
             */
            CountryService.prototype.editCountry = function(data){

                return $http({
                    method: "PUT",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: apiUrl + 'country/' + data['detail[id_country]'],
                    data: $.param(data)
                });
            };


            return new CountryService();
        });
})();