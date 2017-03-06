'use strict';

/** Include any foreign dependency here ***/

var rosiaApp = angular.module('rosiaApp', ['ui.router', 'app', 'pasvaz.bindonce', 'sly', 'ngMap', 'ngSanitize', 'ngCsv', 'ngCookies']);

rosiaApp.config(function ($stateProvider, $urlRouterProvider, $httpProvider) {

    $urlRouterProvider.when("", "/login");
    $urlRouterProvider.when("/", "/login");

    // For any unmatched url, send to /route1
    $urlRouterProvider.otherwise("/login");

    $stateProvider
        .state('authentication', {
            abstract: true,
            templateUrl: 'app/authentication/layouts/authentication.tmpl.html'
        })
        .state('authentication.login', {
            url: '/login',
            templateUrl: 'app/authentication/login/login.tmpl.html',
            controller: 'LoginController',
            controllerAs: 'vm'
        });

    $stateProvider
        .state('app', {
            abstract: true,
            url: '/app',
            templateUrl: "app/views/layout.html",
        })
        .state('app.user', {
            url: '/user-account',
            // loaded into ui-view of parent's template
            templateUrl: 'app/configurations/user/userAccount/user-account.tmpl.html',
            controller: 'userAccountController',
            controllerAs: 'vm'
        })

        .state('app.dashboard', {
            url: '/dashboard',
            templateUrl: 'app/dashboard/dashboard.tmpl.html',
            controller: 'DashboardController',
            controllerAs: 'vm'
        })
    .state('app.country', {
        url: '/country',
        templateUrl: 'app/configurations/country/country.tmpl.html',
        controller: 'CountryController',
        controllerAs: 'vm'
    });



    /*
     //Interceptor implementation
     */
    $httpProvider.interceptors.push('APIInterceptor');


});


