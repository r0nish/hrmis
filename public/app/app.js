/**
 * Inject any modules in the application here.
 */
(function(){
  'use strict';

    angular.module('app', [
        'app.foundation',
        'app.navigation',
        'app.authentication',
        //'app.sales',
        //'app.inventory',
        'app.configurations',
        'app.dashboard',
        //'app.rmap',
        'ui.bootstrap',
        //'app.print',
        //'app.csvToJson',
        //'app.sbd-distribution-report'
    ])
      .constant('API_CONFIG', {
        'url': 'http://triangular-api.oxygenna.com/',
        'baseUrl': window.location.origin+'/hrmis/public/api/v2/',
        ///*'baseUrl': 'http://rosiav2.local/api/v2/',*/
        'dbLimit': '50'
      });

})();
