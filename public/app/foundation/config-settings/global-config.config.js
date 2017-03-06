/**
 * Constant File To Specify the constants for the file
 * Please Set all the constant Here.
 * And Keep All the constant name GLOBAL.
 *
 *
 */

(function() {
    'use strict';

    angular
        .module('app.foundation')
        .constant('API_CONFIG', {
            'input_min_length' : 13,
            'baseUrl': window.location.origin +'/api/v2/',
           // 'baseUrl': 'http://localhost/rosiadevelopment/public/api/v2/',
            db_name: 'DB',
                tables: [
                    {
                        name: 'retail',
                        columns: [
                            {name: 'retail_outlet_id', type: 'integer primary key'},
                            {name: 'title', type: 'text'},
                            {name: 'latitude', type: 'text'},
                            {name: 'longitude', type: 'text'},
                            {name: 'channel', type: 'integer'},
                            {name: 'category', type: 'integer'},
                            {name: 'hotspot_status', type: 'integer'},
                            {name: 'verification_status', type: 'integer'},
                            {name: 'town_id', type: 'integer'},
                            {name: 'street_id', type: 'integer'},
                            {name: 'zone_id', type: 'zone_id'}
                        ]
                    }
                ]


        });
})();