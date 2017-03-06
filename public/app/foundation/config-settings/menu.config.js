(function () {
    'use strict';

    var $stateProviderRef = null;
    var $menuConfiguration = null;

    angular
        .module('app.foundation')
        .config(moduleConfig)
        .run(dynamicMenuConfig)
        /**
         * quick hack , service section to be changed after backend manipulation,
         */
        .service('MenuConfigService', MenuConfigService);

    /* @ngInject */


    function moduleConfig($stateProvider, triMenuProvider, $httpProvider) {


        /**
         * Navigation Block for the Configuration Section. Menu And SubMenu Section.
         */

        $stateProviderRef = $stateProvider;

        $menuConfiguration = triMenuProvider;



        $stateProvider
            .state('triangular.admin-default.dashboard-analytics', {
                url: '/dashboard/analytics',
                templateUrl: 'app/dashboard/dashboard.tmpl.html',
                controller: 'DashboardController',
                controllerAs: 'vm'
            })
            .state('triangular.admin-default.configuration-business-unit', {
                url: '/configuration/business-unit',
                views: {
                    '': {
                        templateUrl: 'app/configurations/businessUnit/business-unit.tmpl.html',
                        controller: 'BusinessUnitController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/businessUnit/fab-button.tmpl.html',
                        controller: 'UnitFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-principal', {
                url: '/configuration/principal',
                views: {
                    '': {
                        templateUrl: 'app/configurations/principal/principal.tmpl.html',
                        controller: 'PrincipalController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/principal/fab-button.tmpl.html',
                        controller: 'PrincipalFabController',
                        controllerAs: 'vm'
                    }
                }
            })

            .state('triangular.admin-default.configuration-geographicLocation', {
                url: '/configuration/geographicLocation',
                views: {
                    '': {
                        templateUrl: 'app/configurations/geographicLocation/geographicLocation.tmpl.html',
                        controller: 'GeographicLocationController',
                        controllerAs: 'vm'
                    },

                    'belowContent': {
                        templateUrl: 'app/configurations/geographicLocation/fab-button.tmpl.html',
                        controller: 'GeographicLocationFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-channel', {
                url: '/configuration/channel',
                views: {
                    '': {
                        templateUrl: 'app/configurations/channelAndCategory/channel/channel.tmpl.html',
                        controller: 'ChannelController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/channelAndCategory/channel/fab-button.tmpl.html',
                        controller: 'ChannelFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-category', {
                url: '/configuration/category',
                views: {
                    '': {
                        templateUrl: 'app/configurations/channelAndCategory/category/category.tmpl.html',
                        controller: 'CategoryController',
                        controllerAs: 'vm'
                    }
                }
            })


            .state('triangular.admin-default.configuration-unit', {
                url: '/configuration/unit',
                views: {
                    '': {
                        templateUrl: 'app/configurations/unit/unit.tmpl.html',
                        controller: 'UnitController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/unit/fab-button.tmpl.html',
                        controller: 'unitFabController',
                        controllerAs: 'vm'
                    }
                }

            })
            .state('triangular.admin-default.configuration-WeightAndVolume', {
                url: '/configuration/weightsAndVolume',
                views: {
                    '': {
                        templateUrl: 'app/configurations/weightsAndVolume/weightsAndVolume-list.tmpl.html',
                        controller: 'WeightsAndVolumeController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/weightsAndVolume/fab-button.tmpl.html',
                        controller: 'weightsAndVolumeFabController',
                        controllerAs: 'vm'
                    }
                }

            })
            .state('triangular.admin-default.configuration-organization', {
                url: '/configuration/organisation',
                templateUrl: 'app/configurations/organisation/organisation.tmpl.html',
                controller: 'ConfigurationController',
                controllerAs: 'vm'
            })
            .state('triangular.admin-default.configuration-distributors', {
                url: '/configuration/distributors',
                views: {
                    '': {
                        templateUrl: 'app/configurations/distributors/distributor-list.tmpl.html',
                        controller: 'DistributorController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/distributors/fab-button.tmpl.html',
                        controller: 'DistributorFabController',
                        controllerAs: 'vm'
                    }
                }

            })
            .state('triangular.admin-default.configuration-sku', {
                url: '/configuration/sku',
                views: {
                    '': {
                        templateUrl: 'app/configurations/sku/sku.tmpl.html',
                        controller: 'SKUController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/sku/fab-button.tmpl.html',
                        controller: 'SKUFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-skuStock',{
                url: '/configuration/sku-stock',
                views: {
                    '': {
                        templateUrl: 'app/configurations/skuStock/sku-stock.tmpl.html',
                        controller: 'SKUStockController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/skuStock/fab-button.tmpl.html',
                        controller: 'SKUStockFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-skuPrice',{
                url: '/configuration/sku-price',
                views: {
                    '': {
                        templateUrl: 'app/configurations/skuPrice/sku-price.tmpl.html',
                        controller: 'SKUPriceController',
                        controllerAs: 'vm'
                    },
                    /*'belowContent': {
                        templateUrl: 'app/configurations/skuPrice/fab-button.tmpl.html',
                        controller: 'SKUPriceFabController',
                        controllerAs: 'vm'
                    }*/
                }
            })
            .state('triangular.admin-default.configuration-catalog', {
                url: '/configuration/catalog',
                views: {
                    '': {
                        templateUrl: 'app/configurations/catalog/catalog.tmpl.html',
                        controller: 'CatalogController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/catalog/fab-button.tmpl.html',
                        controller: 'CatalogFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-catalogDetail', {
                url: '/configuration/catalog-detail',
                views: {
                    '': {
                        templateUrl: 'app/configurations/catalogDetail/catalog-detail.tmpl.html',
                        controller: 'CatalogDetailController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/catalogDetail/fab-button.tmpl.html',
                        controller: 'CatalogDetailFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-visitFrequency', {
                url: '/configuration/visit-frequency',
                views: {
                    '': {
                        templateUrl: 'app/configurations/route/visitFrequency/visit-frequency.tmpl.html',
                        controller: 'VisitFrequencyController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/route/visitFrequency/fab-button.tmpl.html',
                        controller: 'VisitFrequencyFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-visitType', {
                url: '/configuration/visit-type',
                views: {
                    '': {
                        templateUrl: 'app/configurations/route/visitType/visit-type.tmpl.html',
                        controller: 'VisitTypeController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/route/visitType/fab-button.tmpl.html',
                        controller: 'VisitTypeFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-visitCategory', {
                url: '/configuration/routing/visit-category',
                views: {
                    '': {
                        templateUrl: 'app/configurations/route/visitCategory/visit-category.tmpl.html',
                        controller: 'VisitCategoryController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/route/visitCategory/fab-button.tmpl.html',
                        controller: 'VisitCategoryFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-deliveryType', {
                url: '/configuration/routing/route-delivery-Type',
                views: {
                    '': {
                        templateUrl: 'app/configurations/route/deliveryType/delivery-type.tmpl.html',
                        controller: 'DeliveryTypeController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/route/deliveryType/fab-button.tmpl.html',
                        controller: 'DeliveryTypeFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-user-account', {
                url: '/configuration/user-account',
                views: {
                    '': {
                        templateUrl: 'app/configurations/user/userAccount/user-account.tmpl.html',
                        controller: 'userAccountController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/user/userAccount/fab-button.tmpl.html',
                        controller: 'userAccountFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-user-detail', {
                url: '/configuration/user-account/detail/:userId',
                templateUrl: 'app/configurations/user/userAccount/userDetail/user-detail.tmpl.html',
                controller: 'userDetailController',
                controllerAs: 'vm'
            })
            .state('triangular.admin-default.configuration-user-group', {
                url: '/configuration/user-group',
                views: {
                    '': {
                        templateUrl: 'app/configurations/user/userGroup/user-group.tmpl.html',
                        controller: 'userGroupController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/user/userGroup/fab-button.tmpl.html',
                        controller: 'userGroupFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-user-location', {
                url: '/configuration/user-location',
                views: {
                    '': {
                        templateUrl: 'app/configurations/user/userLocation/user-location.tmpl.html',
                        controller: 'userLocationController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/user/userLocation/fab-button.tmpl.html',
                        controller: 'userLocationFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-sbd', {
                url: '/configuration/sbd',
                views: {
                    '': {
                        templateUrl: 'app/configurations/sbd/sbd.tmpl.html',
                        controller: 'SBDController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-permission', {
                url: '/configuration/permission',
                views: {
                    '': {
                        templateUrl: 'app/configurations/user/permission/permission.tmpl.html',
                        controller: 'PermissionController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/user/permission/fab-button.tmpl.html',
                        controller: 'PermissionFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-menuSettings', {
                url: '/configuration/menuSettings',
                views: {
                    '': {
                        templateUrl: 'app/configurations/menuSettings/menu-settings.tmpl.html',
                        controller: 'MenuSettingsController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.configuration-entityPermission', {
                url: '/configuration/entityPermission',
                views: {
                    '': {
                        templateUrl: 'app/configurations/entityPermission/entity-permission.tmpl.html',
                        controller: 'EntityPermissionController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/entityPermission/fab-button.tmpl.html',
                        controller: 'EntityPermissionFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            // .state('triangular.admin-default.route-configuration-periods-period', {
            //     url: '/configuration/periods/period',
            //     views: {
            //         '': {
            //             templateUrl: 'app/configurations/periods/period/period.tmpl.html',
            //             controller: 'PeriodController',
            //             controllerAs: 'vm'
            //         },
            //         'belowContent': {
            //             templateUrl: 'app/configurations/periods/period/fab-button.tmpl.html',
            //             controller: 'PeriodFabController',
            //             controllerAs: 'vm'
            //         }
            //     }
            // })
            .state('triangular.admin-default.route-configuration-periods-period-type', {
                url: '/configuration/periods/period-type',
                views: {
                    '': {
                        templateUrl: 'app/configurations/periods/periodType/period-type.tmpl.html',
                        controller: 'PeriodTypeController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/periods/periodType/fab-button.tmpl.html',
                        controller: 'PeriodTypeFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-promotion-promotionCategory', {
                url: '/configuration/promotion/promotion-category',
                views: {
                    '': {
                        templateUrl: 'app/configurations/promotion/promotionCategory/promotion-category.tmpl.html',
                        controller: 'PromotionCategoryController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/promotion/promotionCategory/fab-button.tmpl.html',
                        controller: 'PromotionCategoryFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-promotion-promotion', {
                url: '/configuration/promotion/promotion',
                views: {
                    '': {
                        templateUrl: 'app/configurations/promotion/promotion/promotion.tmpl.html',
                        controller: 'PromotionController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/promotion/promotion/fab-button.tmpl.html',
                        controller: 'PromotionFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-promotion-promotionCriteria', {
                url: '/configuration/promotion/promotion-criteria',
                views: {
                    '': {
                        templateUrl: 'app/configurations/promotion/promotionCriteria/promotion-criteria.tmpl.html',
                        controller: 'PromotionCriteriaController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/promotion/promotionCriteria/fab-button.tmpl.html',
                        controller: 'PromotionCriteriaFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-promotion-promotionRule', {
                url: '/configuration/promotion/promotion-rule',
                views: {
                    '': {
                        templateUrl: 'app/configurations/promotion/promotionRule/promotion-rule.tmpl.html',
                        controller: 'PromotionRuleController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/promotion/promotionRule/fab-button.tmpl.html',
                        controller: 'PromotionRuleFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-promotion-promotionType', {
                url: '/configuration/promotion/promotion-type',
                views: {
                    '': {
                        templateUrl: 'app/configurations/promotion/promotionType/promotion-type.tmpl.html',
                        controller: 'PromotionTypeController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/configurations/promotion/promotionType/fab-button.tmpl.html',
                        controller: 'PromotionTypeFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.route-configuration-ui-entity-settings', {
                url: '/configuration/ui-entity-settings',
                views: {
                    '': {
                        templateUrl: 'app/configurations/uiEntitySettings/ui-entity-settings.tmpl.html',
                        controller: 'UIEntitySettingsController',
                        controllerAs: 'vm'
                    }
                }
            })


        /**
         * Inventory Section States
         */

        $stateProvider
            .state('triangular.admin-default.inventory-grn', {
                url: '/inventory/grn',
                views: {
                    '': {
                        templateUrl: 'app/inventory/grn/grn.tmpl.html',
                        controller: 'GRNController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/inventory/grn/fab-button.tmpl.html',
                        controller: 'GRNFabController',
                        controllerAs: 'vm'
                    }
                }
            })

            .state('triangular.admin-default.inventory-stockLedger', {
                url: '/inventory/stock-ledger',
                views: {
                    '': {
                        templateUrl: 'app/inventory/stockLedger/stock-ledger.tmpl.html',
                        controller: 'StockLedgerController',
                        controllerAs: 'vm'
                    }
                }
            })

            .state('triangular.admin-default.inventory-salesReturn', {
                url: '/inventory/sales-return',
                views: {
                    '': {
                        templateUrl: 'app/inventory/salesReturn/sales-return.tmpl.html',
                        controller: 'SalesReturnController',
                        controllerAs: 'vm'
                    }
                }
            })

            .state('triangular.admin-default.inventory-stockLedgerDetailView', {
                url: '/inventory/stock-ledger/detail/:stockLedgerID',
                views: {
                    '': {
                        templateUrl: 'app/inventory/stockLedger/stock-ledger-detailView.tmpl.html',
                        controller: 'StockLedgerDetailController',
                        controllerAs: 'vm'
                    }
                }
            })


        /**
         * Sales Section States
         */

        $stateProvider
            .state('triangular.admin-default.order-processing',{
                url: '/sales/order-processing',
                templateUrl: 'app/sales/orderProcessing/order-processing.tmpl.html',
                controller: 'OrderProcessingController',
                controllerAs: 'vm'
            })
            .state('triangular.admin-default.sales-retail-outlet', {
                url: '/sales/retail-outlet',
                templateUrl: 'app/sales/routeAndOutlet/retailOutlets/retail-outlets.tmpl.html',
                controller: 'RetailOutletController',
                controllerAs: 'vm'
            })
            .state('triangular.admin-default.sales-route', {
                url: '/sales/route',
                views: {
                    '': {
                        templateUrl: 'app/sales/routeAndOutlet/route/route.tmpl.html',
                        controller: 'RouteListController',
                        controllerAs: 'vm'
                    },
                    'belowContent': {
                        templateUrl: 'app/sales/routeAndOutlet/route/routeList/fab-button.tmpl.html',
                        controller: 'RouteFabController',
                        controllerAs: 'vm'
                    }
                }
            })
            .state('triangular.admin-default.sales-route-outlet-detail', {
                url: '/sales/retail-outlet/detail/:retailOutletID',
                templateUrl: 'app/sales/routeAndOutlet/retailOutlets/retailOutlet/detail.tmpl.html',
                controller: 'RetailOutletDetailController',
                controllerAs: 'vm'
            })

            .state('triangular.admin-default.sales-force', {
                url: '/sales/sales-force',
                templateUrl: 'app/sales/salesForce/sales-force.tmpl.html',
                controller: 'SalesForceController',
                controllerAs: 'vm'
            })


        /**
         * Interceptors to Determine the push and pull request to the server
         * Generally to set the header with authentication and respond to the server response.
         */
        $httpProvider.interceptors.push('APIInterceptor');

    }

    /**
     * Recursion function to generate the menu ..
     *
     * @param menu
     * @returns {{name: string, type: string, state: string, icon: string}}
     */

    function generateHierarchyMenu(menu)
    {

        var menuList = {
            name:'',
            type:'',
            state:'',
            icon:''
        };

        menuList.name = menu.parent.title;
        menuList.type = 'link';
        menuList.state = menu.parent.state;
        menuList.icon = menu.parent.icon;
        if(menu.children && menu.children.length){
            menuList.type = 'dropdown';
            menuList.state = menu.parent.state;
            menuList.children = [];
            angular.forEach(menu.children, function (menu) {
                menuList.children.push(generateHierarchyMenu(menu));
            });
        }

        return menuList;

    }

    function dynamicMenuConfig($http, API_CONFIG, AuthDataShareService) {

        var menuList = null;

        var menuState = {};

        var userInfo = AuthDataShareService.getUserInfo();

        if(userInfo != null){

            var userGroup = userInfo.user.user_group_id;
            //console.log('user_group_id',userGroup);
            $http.get(API_CONFIG.baseUrl + 'generate-menu/'+userGroup+'/1/1').then(function (response) {
                menuList = response.data.data;
//                console.log("menu received is thank you ",response);
                angular.forEach(menuList, function (menu) {
                    $menuConfiguration.addMenu(
                        generateHierarchyMenu(menu)
                    );
                });
            });
        }


    }

    function MenuConfigService($http, API_CONFIG,AuthDataShareService){
        var sharedService = {};
        sharedService.dynamicMenuConfig = function( ){
            dynamicMenuConfig($http,API_CONFIG,AuthDataShareService);

            /* var menuList = null;
            $http.get(API_CONFIG.baseUrl + 'generate-menu/1/1/0').then(function (response) {
               // console.log("menu received is thank you ",response);
                menuList = response.data.data;


                angular.forEach(menuList, function (menu) {
                    $menuConfiguration.addMenu(
                        generateHierarchyMenu(menu)
                    );
                });
            });*/
        };
        return sharedService;
    }
})();