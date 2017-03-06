/**
 *  Base Service consists of the basic service to interact with the
 */
(function () {
    'use strict';

    angular
        .module('app.foundation')
        .factory('BaseServerService', function ($http, API_CONFIG) {

            var apiUrl = API_CONFIG.baseUrl;


            // instantiate our initial object
            var BaseServerService = function (url) {
                this.url = apiUrl + url;
            };

            // define the getProfile method which will fetch data


            BaseServerService.prototype.getList = function (query) {
                //filter: "", limit: 50, order: "-id", page: 1, total: ""
                // Generally, javascript callbacks, like here the $http.get callback,
                // change the value of the "this" variable inside it
                // so we need to keep a reference to the current instance "this" :
                var self = this; // console.log(query.nonHierarchy);
                var urlList = (typeof query.nonHierarchy != undefined && query.nonHierarchy == true ) ? '/non-hierarchy-paginated-list' : '/paginated-list';
              //  return $http.get(self.url + urlList + '?pagelimit=' + query.limit + '&page=' + query.page + query.filter).
                return $http.get(self.url + urlList + '?pagelimit=' + query.limit + '&page=' + query.page +'&order=' + query.order +'&total=' + query.total + query.filter).
                then(function (response) {
                    return response;
                });
            };


            // define the getProfile method which will fetch data
            // from GH API and *returns* a promise
            BaseServerService.prototype.getListRO = function (query) {
                // Generally, javascript callbacks, like here the $http.get callback,
                // change the value of the "this" variable inside it
                // so we need to keep a reference to the current instance "this" :
                var self = this;
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: self.url + '/paginated-list',
                    data: $.param({page: query.page + query.filter})
                });
                //return $http.get(self.url+'/paginated-list' + '?page=' + query.page+query.filter).
                //then(function (response) {
                //    return response;
                //});
            };

            BaseServerService.prototype.postObject = function (postDetail) {
                var self = this;
                return $http({
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: self.url,
                    data: $.param({detail: postDetail})
                });
            };

            BaseServerService.prototype.editObject = function (id, postDetail) {

                return $http({
                    method: "PUT",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: this.url + '/' + id,
                    data: $.param({detail: postDetail})
                });
            };

            BaseServerService.prototype.deleteObject = function (id) {

                return $http({
                    method: "DELETE",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    url: this.url + '/' + id,
                });
            };

            BaseServerService.prototype.deActivateObject = function (id) {
                return $http.get(this.url + '/deactivate/' + id);
            };

            BaseServerService.prototype.activateObject = function (id) {
                return $http.get(this.url + '/activate/' + id);
            };


            BaseServerService.prototype.getActiveList = function () {
                return $http.get(this.url);
            };

            return BaseServerService;
        });

})();
