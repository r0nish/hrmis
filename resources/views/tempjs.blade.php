{{--
Setting for the  Angular Components
--}}

<script src="bower_components/jquery/dist/jquery.js"></script>
<script src="bower_components/angular/angular.js"></script>
<script src="bower_components/angular-animate/angular-animate.js"></script>
<script src="bower_components/Chart.js/Chart.js"></script>
<script src="bower_components/angular-chart.js/dist/angular-chart.js"></script>
<script src="bower_components/angular-cookies/angular-cookies.js"></script>
<script src="bower_components/angular-digest-hud/digest-hud.js"></script>
<script src="bower_components/angular-dragula/dist/angular-dragula.js"></script>
<script src="bower_components/angular-google-chart/ng-google-chart.js"></script>
<script src="bower_components/lodash/lodash.js"></script>
<script src="bower_components/angular-google-maps/dist/angular-google-maps.js"></script>
<script src="bower_components/highlightjs/highlight.pack.js"></script>
<script src="bower_components/angular-highlightjs/build/angular-highlightjs.js"></script>
<script src="bower_components/angular-linkify/angular-linkify.js"></script>
<script src="bower_components/angular-local-storage/dist/angular-local-storage.js"></script>
<script src="bower_components/angular-aria/angular-aria.js"></script>
<script src="bower_components/angular-material/angular-material.js"></script>
<script src="bower_components/angular-material-data-table/dist/md-data-table.js"></script>
<script src="bower_components/angular-messages/angular-messages.js"></script>
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/angular-moment/angular-moment.js"></script>
<script src="bower_components/angular-resource/angular-resource.js"></script>
<script src="bower_components/angular-touch/angular-touch.js"></script>
<script src="bower_components/angular-translate/angular-translate.js"></script>
<script src="bower_components/angular-translate-loader-partial/angular-translate-loader-partial.js"></script>
<script src="bower_components/angular-translate-storage-cookie/angular-translate-storage-cookie.js"></script>
<script src="bower_components/angular-translate-storage-local/angular-translate-storage-local.js"></script>
<script src="bower_components/angular-ui-calendar/src/calendar.js"></script>
<script src="bower_components/fullcalendar/dist/fullcalendar.js"></script>
<script src="bower_components/angular-ui-router/release/angular-ui-router.js"></script>
<script src="bower_components/countUp.js/countUp.js"></script>
<script src="bower_components/rangy/rangy-core.js"></script>
<script src="bower_components/rangy/rangy-classapplier.js"></script>
<script src="bower_components/rangy/rangy-highlighter.js"></script>
<script src="bower_components/rangy/rangy-selectionsaverestore.js"></script>
<script src="bower_components/rangy/rangy-serializer.js"></script>
<script src="bower_components/rangy/rangy-textrange.js"></script>
<script src="bower_components/textAngular/src/textAngular.js"></script>
<script src="bower_components/textAngular/src/textAngular-sanitize.js"></script>
<script src="bower_components/textAngular/src/textAngularSetup.js"></script>
<script src="bower_components/ng-file-upload/ng-file-upload-shim.js"></script>
<script src="bower_components/ng-file-upload/ng-file-upload.js"></script>

<!-- endbower -->

<!-- enqueue all translations for calendar (remove if you dont need multilanguage) -->
<!-- <script src="bower_components/fullcalendar/dist/lang-all.js"></script> -->
<!-- endbuild -->

<!-- build:js({.tmp/serve,.tmp/partials,src}) scripts/app.js -->
<!-- inject:js -->


{{--
Triangular Components
--}}


<script src="app/triangular/layouts/layouts.module.js"></script>
<script src="app/triangular/layouts/default/default-layout.controller.js"></script>
<script src="app/triangular/layouts/default/default-content.directive.js"></script>
<script src="app/triangular/components/components.module.js"></script>
<script src="app/triangular/components/wizard/wizard.directive.js"></script>
<script src="app/triangular/components/wizard/wizard-form.directive.js"></script>
<script src="app/triangular/components/widget/widget.directive.js"></script>


<script src="app/toolbar/toolbar.module.js"></script>
<script src="app/toolbar/toolbar.controller.js"></script>

{{--<script src="app/triangular/components/toolbars/toolbar.controller.js"></script>--}}
<script src="app/triangular/components/table/table.directive.js"></script>
<script src="app/triangular/components/table/table-start-from.filter.js"></script>
<script src="app/triangular/components/table/table-cell-image.filter.js"></script>
<script src="app/triangular/components/notifications-panel/notifications-panel.controller.js"></script>
<script src="app/triangular/components/menu/menu.provider.js"></script>
<script src="app/triangular/components/menu/menu.directive.js"></script>
<script src="app/triangular/components/menu/menu.controller.js"></script>
<script src="app/triangular/components/menu/menu-item.directive.js"></script>
<script src="app/triangular/components/loader/loader.directive.js"></script>
<script src="app/triangular/components/loader/loader-service.js"></script>
<script src="app/triangular/components/footer/footer.controller.js"></script>
<script src="app/triangular/components/breadcrumbs/breadcrumbs.service.js"></script>


<script src="app/triangular/themes/themes.module.js"></script>
<script src="app/triangular/themes/theming.provider.js"></script>
<script src="app/triangular/themes/skins.provider.js"></script>
<script src="app/triangular/profiler/profiler.module.js"></script>
<script src="app/triangular/profiler/profiler.config.js"></script>
<script src="app/triangular/triangular.module.js"></script>
<script src="app/triangular/layouts/layouts.provider.js"></script>
<script src="app/triangular/directives/directives.module.js"></script>
<script src="app/triangular/directives/theme-background.directive.js"></script>
<script src="app/triangular/directives/same-password.directive.js"></script>
<script src="app/triangular/directives/palette-background.directive.js"></script>
<script src="app/triangular/directives/countupto.directive.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js"></script>


<script src="app/triangular/triangular.run.js"></script>
<script src="app/triangular/settings.provider.js"></script>
<script src="app/triangular/config.route.js"></script>


{{--
Setup for scalyr ng-repeat alternative
--}}

{{--<script src="assets/scalyr/core.js"></script>
<script src="assets/scalyr/scalyr.js"></script>
<script src="assets/scalyr/slyEvaluate.js"></script>
<script src="assets/scalyr/slyRepeat.js"></script>--}}


{{--
Setup for the FOUNDATION MODULE
--}}

<script src="app/foundation/foundation.module.js"></script>
<script src="app/foundation/foundation.config.js"></script>

<script src="app/foundation/base-controller.service.js"></script>
<script src="app/foundation/base-server.service.js"></script>

<script src="app/foundation/route-scope.run.js"></script>
<script src="app/foundation/http-interceptor.js"></script>
<script src="app/foundation/http-interceptor.service.js"></script>


{{--
constant Config setting File
--}}

<script src="app/foundation/config-settings/global-config.config.js"></script>

{{--
Menu settings
--}}
<script src="app/foundation/config-settings/menu.config.js"></script>


{{--
Custom Directive Components
--}}
<script src="app/foundation/components/components.module.js"></script>
<script src="app/foundation/components/simple-table-card/widget.directive.js"></script>
<script src="app/foundation/components/template-table-card/template-widget.directive.js"></script>
<script src="app/foundation/components/dynamic-menu-table-card/dynamic-table-card.directive.js"></script>
<script src="app/foundation/components/filter-card/widget.directive.js"></script>
{{--<script src="app/configurations/filter-card/widget.directive.js"></script>--}}

{{--
Common Design Settings
--}}


<script src="app/foundation/common-design/common-design-event.service.js"></script>
<script src="app/foundation/common-design/custom-dialog.controller.js"></script>


{{--
Authentication Module
--}}
<script src="app/authentication/authentication.module.js"></script>
<script src="app/authentication/authentication.config.js"></script>
<script src="app/authentication/login/login.controller.js"></script>

<script src="app/authentication/auth.service.js"></script>
<script src="app/authentication/auth-data.service.js"></script>

<script src="app/authentication/profile/profile.controller.js"></script>


{{--
App Module Setups
--}}

<script src="app/app.module.js"></script>

<script src="app/value.googlechart.js"></script>

<script src="app/config.triangular.themes.js"></script>
<script src="app/config.triangular.settings.js"></script>
<script src="app/config.triangular.layout.js"></script>

{{--
<script src="app/config.translate.js"></script>
--}}

<script src="app/config.route.js"></script>
<script src="app/config.chartjs.js"></script>

{{--

--}}
{{--Dashboard--}}

{{--
<script src="app/dashboards/dashboards.module.js"></script>
<script src="app/dashboards/dashboards.config.js"></script>
<script src="app/dashboards/analytics/dashboard-analytics.controller.js"></script>
--}}


{{--dashboard-section--}}

<script src="app/dashboard/dashboard.module.js"></script>
<script src="app/dashboard/dashboard.controller.js"></script>
<script src="app/dashboard/dashboard.service.js"></script>


{{--Configuration Section--}}

<script src="app/configurations/configurations.module.js"></script>

<script src="app/configurations/confirm-dialog.controller.js"></script>


<script src="app/configurations/businessUnit/business-unit.controller.js"></script>
<script src="app/configurations/businessUnit/assign-dialog.controller.js"></script>

<script src="app/configurations/businessUnit/business-unit.service.js"></script>
<script src="app/configurations/businessUnit/fab-button.controller.js"></script>
<script src="app/configurations/businessUnit/dialog.controller.js"></script>


<script src="app/configurations/principal/principal.service.js"></script>
<script src="app/configurations/principal/principal.controller.js"></script>
<script src="app/configurations/principal/fab-button.controller.js"></script>
<script src="app/configurations/principal/principal-dialog.controller.js"></script>


<script src="app/configurations/catalog/catalog.service.js"></script>
<script src="app/configurations/catalog/catalog.controller.js"></script>
<script src="app/configurations/catalog/fab-button.controller.js"></script>
<script src="app/configurations/catalog/catalog-dialog.controller.js"></script>


<script src="app/configurations/sku/sku.service.js"></script>
<script src="app/configurations/sku/sku.controller.js"></script>
<script src="app/configurations/sku/fab-button.controller.js"></script>
<script src="app/configurations/sku/sku-dialog.controller.js"></script>
<script src="app/configurations/sku/sku-filter-dialog.controller.js"></script>
<script src="app/configurations/sku/sub-form-controller.js"></script>

<script src="app/configurations/skuPrice/sku-price.service.js"></script>
<script src="app/configurations/skuPrice/sku-price.controller.js"></script>
<script src="app/configurations/skuPrice/sku-price-dialog.controller.js"></script>
<script src="app/configurations/skuPrice/fab-button.controller.js"></script>
<script src="app/configurations/skuPrice/create-sku-price.dialog.controller.js"></script>


<script src="app/configurations/skuStock/sku-stock.service.js"></script>
<script src="app/configurations/skuStock/sku-stock.controller.js"></script>
<script src="app/configurations/skuStock/fab-button.controller.js"></script>
<script src="app/configurations/skuStock/sku-stock-dialog.controller.js"></script>
<script src="app/configurations/skuStock/sku-stock-filter-dialog.controller.js"></script>


<script src="app/configurations/catalogDetail/catalog-detail.service.js"></script>
<script src="app/configurations/catalogDetail/catalog-detail.controller.js"></script>


<script src="app/configurations/periods/period/period.service.js"></script>
<script src="app/configurations/periods/period/period.controller.js"></script>
<script src="app/configurations/periods/period/fab-button.controller.js"></script>
<script src="app/configurations/periods/period/period-dialog.controller.js"></script>


<script src="app/configurations/periods/periodType/period-type.controller.js"></script>
<script src="app/configurations/periods/periodType/fab-button.controller.js"></script>
<script src="app/configurations/periods/periodType/period-type-dialog.controller.js"></script>


<script src="app/configurations/route/deliveryType/delivery-type.service.js"></script>
<script src="app/configurations/route/deliveryType/delivery-type.controller.js"></script>
<script src="app/configurations/route/deliveryType/fab-button.controller.js"></script>
<script src="app/configurations/route/deliveryType/delivery-type-dialog.controller.js"></script>


<script src="app/configurations/route/visitCategory/visit-category.service.js"></script>
<script src="app/configurations/route/visitCategory/visit-category.controller.js"></script>
<script src="app/configurations/route/visitCategory/fab-button.controller.js"></script>
<script src="app/configurations/route/visitCategory/visit-category-dialog.controller.js"></script>


<script src="app/configurations/route/visitFrequency/visit-frequency.service.js"></script>
<script src="app/configurations/route/visitFrequency/visit-frequency.controller.js"></script>
<script src="app/configurations/route/visitFrequency/fab-button.controller.js"></script>
<script src="app/configurations/route/visitFrequency/visit-frequency-dialog.controller.js"></script>


<script src="app/configurations/route/visitType/visit-type.service.js"></script>
<script src="app/configurations/route/visitType/visit-type.controller.js"></script>
<script src="app/configurations/route/visitType/fab-button.controller.js"></script>
<script src="app/configurations/route/visitType/visit-type-dialog.controller.js"></script>


<script src="app/configurations/promotion/promotion/promotion.service.js"></script>
<script src="app/configurations/promotion/promotion/promotion.controller.js"></script>
<script src="app/configurations/promotion/promotion/fab-button.controller.js"></script>
<script src="app/configurations/promotion/promotion/promotion-dialog.controller.js"></script>


<script src="app/configurations/promotion/promotionCategory/promotion-category.service.js"></script>
<script src="app/configurations/promotion/promotionCategory/promotion-category.controller.js"></script>
<script src="app/configurations/promotion/promotionCategory/fab-button.controller.js"></script>
<script src="app/configurations/promotion/promotionCategory/dialog.controller.js"></script>


<script src="app/configurations/promotion/promotionCriteria/promotion-criteria.service.js"></script>
<script src="app/configurations/promotion/promotionCriteria/promotion-criteria.controller.js"></script>
<script src="app/configurations/promotion/promotionCriteria/fab-button.controller.js"></script>
<script src="app/configurations/promotion/promotionCriteria/dialog.controller.js"></script>


<script src="app/configurations/promotion/promotionRule/promotion-rule.service.js"></script>
<script src="app/configurations/promotion/promotionRule/promotion-rule.controller.js"></script>
<script src="app/configurations/promotion/promotionRule/fab-button.controller.js"></script>
<script src="app/configurations/promotion/promotionRule/promotion-rule-dialog.controller.js"></script>


<script src="app/configurations/promotion/promotionType/promotion-type.service.js"></script>
<script src="app/configurations/promotion/promotionType/promotion-type.controller.js"></script>
<script src="app/configurations/promotion/promotionType/fab-button.controller.js"></script>
<script src="app/configurations/promotion/promotionType/promotion-type-dialog.controller.js"></script>


<script src="app/configurations/user/permission/permission.controller.js"></script>
<script src="app/configurations/user/permission/fab-button.controller.js"></script>
<script src="app/configurations/user/permission/permission-dialog.controller.js"></script>


<script src="app/configurations/user/userAccount/user-account.service.js"></script>
<script src="app/configurations/user/userAccount/user-account.controller.js"></script>
<script src="app/configurations/user/userAccount/fab-button.controller.js"></script>
<script src="app/configurations/user/userAccount/user-account-dialog.controller.js"></script>
<script src="app/configurations/user/userAccount/user-account-filter-dialog.controller.js"></script>
<script src="app/configurations/user/userAccount/user-filter.controller.js"></script>
<script src="app/configurations/user/userAccount/user-filter-dialog.controller.js"></script>
<script src="app/configurations/user/userAccount/supervise-dialog.controller.js"></script>
<script src="app/configurations/user/userAccount/assign-children-users-dialog.controller.js"></script>


<script src="app/configurations/user/userGroup/user-group.service.js"></script>
<script src="app/configurations/user/userGroup/user-group.controller.js"></script>
<script src="app/configurations/user/userGroup/fab-button.controller.js"></script>
<script src="app/configurations/user/userGroup/user-group-dialog.controller.js"></script>

<script src="app/configurations/user/userAccount/userDetail/user-detail.service.js"></script>
<script src="app/configurations/user/userAccount/userDetail/user-detail-dialog.controller.js"></script>
<script src="app/configurations/user/userAccount/userDetail/user-detail.controller.js"></script>
<script src="app/configurations/user/userAccount/userDetail/edit-user-route-assignment-dialog.controller.js"></script>
<script src="app/configurations/user/userAccount/userDetail/distributor-assignment.controller.js"></script>


<script src="app/configurations/user/userLocation/user-location.service.js"></script>
<script src="app/configurations/user/userLocation/user-location.controller.js"></script>
<script src="app/configurations/user/userLocation/fab-button.controller.js"></script>
<script src="app/configurations/user/userLocation/user-location-dialog.controller.js"></script>


<script src="app/configurations/geographicLocation/geographicLocation.service.js"></script>
<script src="app/configurations/geographicLocation/geographicLocation.controller.js"></script>
<script src="app/configurations/geographicLocation/fab-button.controller.js"></script>
<script src="app/configurations/geographicLocation/geoLocation-dialog.controller.js"></script>
<script src="app/configurations/geographicLocation/dynamic-table.controller.js"></script>
<script src="app/configurations/geographicLocation/dynamicTable.controller.js"></script>
{{--<script src="app/configurations/geographicLocation/geo-location-town.controller.js"></script>--}}


<script src="app/configurations/geographicLocation/geo-location-town-dialog.controller.js"></script>
<script src="app/configurations/geographicLocation/geographicLookUp.service.js"></script>


<script src="app/configurations/channelAndCategory/channel-category.controller.js"></script>
<script src="app/configurations/channelAndCategory/category/category.controller.js"></script>
<script src="app/configurations/channelAndCategory/category/category.service.js"></script>
<script src="app/configurations/channelAndCategory/category/channel-category.service.js"></script>
<script src="app/configurations/channelAndCategory/channel/category-dialog.controller.js"></script>
<script src="app/configurations/channelAndCategory/channel/channel.controller.js"></script>
<script src="app/configurations/channelAndCategory/channel/channel.service.js"></script>
<script src="app/configurations/channelAndCategory/channel/channel-dialog.controller.js"></script>
<script src="app/configurations/channelAndCategory/channel/fab-button.controller.js"></script>
<script src="app/configurations/channelAndCategory/channel/nutritionController.js"></script>


<script src="app/configurations/unit/unit.service.js"></script>
<script src="app/configurations/unit/unit.controller.js"></script>
<script src="app/configurations/unit/fab-button.controller.js"></script>
<script src="app/configurations/unit/unit-dialog.controller.js"></script>


<script src="app/configurations/weightsAndVolume/weightsAndVolume.service.js"></script>
<script src="app/configurations/weightsAndVolume/weightsAndVolume.controller.js"></script>
<script src="app/configurations/weightsAndVolume/fab-button.controller.js"></script>
<script src="app/configurations/weightsAndVolume/weightsAndVolume-dialog.controller.js"></script>
<script src="app/configurations/weightsAndVolume/todo.config.js"></script>
<script src="app/configurations/weightsAndVolume/todo.module.js"></script>


<script src="app/configurations/entityPermission/entity-permission.service.js"></script>
<script src="app/configurations/entityPermission/entity-permission.controller.js"></script>
<script src="app/configurations/entityPermission/fab-button.controller.js"></script>
<script src="app/configurations/entityPermission/entity-permission-dialog.controller.js"></script>
<script src="app/configurations/entityPermission/entity-property.controller.js"></script>
<script src="app/configurations/entityPermission/entity-property.service.js"></script>
<script src="app/configurations/entityPermission/entity-property-dialog.controller.js"></script>


<script src="app/configurations/uiEntitySettings/ui-entity-settings.controller.js"></script>


<script src="app/configurations/menuSettings/menu-settings.service.js"></script>
<script src="app/configurations/menuSettings/menu-settings.controller.js"></script>


<script src="app/configurations/sbd/sbd.service.js"></script>
<script src="app/configurations/sbd/sbd.controller.js"></script>
<script src="app/configurations/sbd/fab-button.controller.js"></script>
<script src="app/configurations/sbd/sbd-dialog.controller.js"></script>
<script src="app/configurations/sbd/sku-filter-dialog.controller.js"></script>


<script src="app/configurations/town/town.service.js"></script>
<script src="app/configurations/town/town.controller.js"></script>
<script src="app/configurations/town/fab-button.controller.js"></script>
<script src="app/configurations/town/town-dialog.controller.js"></script>
<script src="app/configurations/town/town-filter-dialog.controller.js"></script>


<script src="app/configurations/distributors/distributors.service.js"></script>
<script src="app/configurations/distributors/distributors.controller.js"></script>
<script src="app/configurations/distributors/assign-bu.dialog.controller.js"
<script src="app/configurations/distributors/fab-button.controller.js"></script>
<script src="app/configurations/distributors/distributor-dialog.controller.js"></script>
<script src="app/configurations/distributors/todo.config.js"></script>
<script src="app/configurations/distributors/todo.module.js"></script>


<script src="app/configurations/services/data-share.service.js"></script>


{{--Inventory Section--}}

<script src="app/inventory/inventory.module.js"></script>
<script src="app/inventory/inventory.config.js"></script>
<script src="app/inventory/inventory.controller.js"></script>


<script src="app/inventory/grn/grn.service.js"></script>
<script src="app/inventory/grn/grn.controller.js"></script>
<script src="app/inventory/grn/fab-button.controller.js"></script>
<script src="app/inventory/grn/grn-dialog.controller.js"></script>
<script src="app/inventory/grn/grn-filter-dialog.controller.js"></script>


<script src="app/inventory/salesReturn/sales-return.service.js"></script>
<script src="app/inventory/salesReturn/sales-return.controller.js"></script>


<script src="app/inventory/stockLedger/stock-ledger.service.js"></script>
<script src="app/inventory/stockLedger/stock-ledger.controller.js"></script>
<script src="app/inventory/stockLedger/sku-ledger-info-dialog.controller.js"></script>
<script src="app/inventory/stockLedger/stock-ledger-filter.controller.js"></script>
<script src="app/inventory/stockLedger/stock-ledger-filter-dialog.controller.js"></script>
<script src="app/inventory/stockLedger/service/data-share.service.js"></script>


{{--Sales Section--}}

<script src="app/sales/sales.module.js"></script>
<script src="app/sales/sales.config.js"></script>
<script src="app/sales/sales.controller.js"></script>


<script src="app/sales/orderProcessing/order-processing.service.js"></script>
<script src="app/sales/orderProcessing/order-processing.controller.js"></script>
<script src="app/sales/orderProcessing/order-processing-dialog.controller.js"></script>
<script src="app/sales/orderProcessing/apply-promotion-dialog.controller.js"></script>
<script src="app/sales/orderProcessing/date-change-dialog.controller.js"></script>
<script src="app/sales/orderProcessing/fab-button.controller.js"></script>
<script src="app/sales/orderProcessing/FileSaver.js"></script>
<script src="app/sales/orderProcessing/todo.config.js"></script>
<script src="app/sales/orderProcessing/todo.module.js"></script>


<script src="app/sales/routeAndOutlet/retailOutlets/retail-outlets.module.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retail-outlets.config.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retail-outlets.controller.js"></script>

<script src="app/sales/routeAndOutlet/retailOutlets/maps/map-terrain-demo.controller.js"></script>

<script src="app/sales/routeAndOutlet/retailOutlets/retailOutlet/date-change-dialog.controller.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retailOutlet/detail-gallery.controller.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retailOutlet/detail-gallery-dialog.controller.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retailOutlet/retail-outlet-detail.controller.js"></script>

<script src="app/sales/routeAndOutlet/retailOutlets/retailOutletList/dialog.controller.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retailOutletList/retail-outlet-list-filter.controller.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retailOutletList/retail-outlet-list-service.js"></script>
<script src="app/sales/routeAndOutlet/retailOutlets/retailOutletList/retail-outlets-list.controller.js"></script>


<script src="app/sales/routeAndOutlet/route/route.controller.js"></script>

<script src="app/sales/routeAndOutlet/route/map/route-map.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/map/route-map-form.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/map/route-map-form.service.js"></script>

<script src="app/sales/routeAndOutlet/route/routeList/fab-button.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/route-dialog.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/route-list.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/route-filter-service.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/route-list.service.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/route-list-filter.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/transfer-route-dialog.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/add-route-dialog.controller.js"></script>
<script src="app/sales/routeAndOutlet/route/routeList/editRouteList/edit-route-dialog.controller.js"></script>


<script src="app/sales/routeAndOutlet/route/services/route-data-share.service.js"></script>
<script src="app/sales/routeAndOutlet/route/services/route-manager.service.js"></script>
<script src="app/sales/routeAndOutlet/route/services/route-model.service.js"></script>
<script src="app/sales/routeAndOutlet/route/services/route-server.service.js"></script>

<script src="app/sales/salesForce/sales-force.controller.js"></script>


<script src="app/validation/validation.module.js"></script>
<script src="app/validation/validation.service.js"></script>
<script src="app/validation/only-digits.directive.js"></script>


<!----Weight and Volume --->
{{--
<script src="app/configurations/weightsAndVolume/weightsAndVolume.service.js"></script>
<script src="app/configurations/weightsAndVolume/weightsAndVolume.controller.js"></script>
<script src="app/configurations/weightsAndVolume/weightsAndVolume-dialog.controller.js"></script>
<script src="app/configurations/weightsAndVolume/fab-button.controller.js"></script>
--}}

{{--Users--}}{{--

<script src="app/users/users.module.js"></script>
<script src="app/users/users.config.js"></script>
<script src="app/users/users.controller.js"></script>
<script src="app/users/users.service.js"></script>
<script src="app/users/fab-button.controller.js"></script>
<script src="app/users/user-dialog-controller.js"></script>
<script src="app/users/password-match.directive.js"></script>
<script src="app//users/filemodel.directive.js"></script>

--}}
{{--Location--}}{{--

<script src="app/location/location.module.js"></script>
<script src="app/location/location.config.js"></script>
<script src="app/location/streetTownControllers/town.controller.js"></script>
<script src="app/location/streetTownControllers/street.controller.js"></script>

<script src="app/location/location.controller.js"></script>
<script src="app/location/location.service.js"></script>
<script src="app/location/location-fab-button.controller.js"></script>
<script src="app/location/location-dialog.controller.js"></script>
<script src="app/location/assign-town.controller.js"></script>

--}}
{{--Channel--}}{{--

<script src="app/channel/channel.module.js"></script>
<script src="app/channel/category.controller.js"></script>
<script src="app/channel/channel.controller.js"></script>
<script src="app/channel/channel.service.js"></script>
<script src="app/channel/category.service.js"></script>
<script src="app/channel/fab-button.controller.js"></script>
<script src="app/channel/edit-channel-dialog.controller.js"></script>

--}}
{{--Catalog--}}{{--

<script src="app/catalog/catalog.module.js"></script>
<script src="app/catalog/sku.controller.js"></script>
<script src="app/catalog/catalog.controller.js"></script>
<script src="app/catalog/catalog.service.js"></script>
<script src="app/catalog/fab-button.controller.js"></script>
<script src="app/catalog/edit-catalog-dialog.controller.js"></script>

--}}
{{--Outlet Detail--}}{{--

<script src="app/outletDetail/outlet-detail.module.js"></script>
<script src="app/outletDetail/outlet-detail.controller.js"></script>
<script src="app/outletDetail/image-dialog.controller.js"></script>
<script src="app/outletDetail/outlet-detail.service.js"></script>


--}}
{{--Retail Outlet--}}{{--

<script src="app/retail-outlet/retail-outlet.module.js"></script>
<script src="app/retail-outlet/retail-outlet.controller.js"></script>
<script src="app/retail-outlet/maps/retail-outlet-map.controller.js"></script>
<script src="app/retail-outlet/filter/retail-outlet-filter-rMap-data.controller.js"></script>
<script src="app/retail-outlet/filter/retail-outlet-filter-rosia-data.controller.js"></script>
<script src="app/retail-outlet/maps/retail-outlet-info-window.controller.js"></script>


<script src="app/retail-outlet/retailOutletList/retail-outlet-list.controller.js"></script>
<script src="app/retail-outlet/retailOutletList/retail-outlet-list-service.js"></script>
<script src="app/retail-outlet/retail-outlets.data.share.service.js"></script>
<script src="app/retail-outlet/filter/retail-outlet-filter-switch.controller.js"></script>
<script src="app/retail-outlet/maps/retail-outlet-map-catalog-filter.controller.js"></script>

--}}
{{--Rosia Rmap Matching--}}{{--

<script src="app/matching/rosia-rmap-matching.module.js"></script>
<script src="app/matching/rosia-rmap-matching.controller.js"></script>
<script src="app/matching/rosia-rmap-matching.data.share.service.js"></script>
<script src="app/matching/rosia-rmap-matching-route-filter.controller.js"></script>
<script src="app/matching/rosia-rmap-matching-search-info.controller.js"></script>
<script src="app/matching/maps/rosia-rmap-matching.map.controller.js"></script>

--}}
{{--
<script src="app/retail-outlet/maps/retail-outlet-map.controller.js"></script>
<script src="app/retail-outlet/maps/retail-outlet-map-filter.controller.js"></script>
<script src="app/retail-outlet/maps/retail-outlet-info-window.controller.js"></script>--}}{{--



--}}
{{--Rosia Retail Outlet--}}{{--

<script src="app/rosia-outlet/rosia-outlet.module.js"></script>
<script src="app/rosia-outlet/rosia-outlet.controller.js"></script>
<script src="app/rosia-outlet/rosia-outlets.data.share.service.js"></script>
<script src="app/rosia-outlet/maps/rosia-outlet-map.controller.js"></script>
<script src="app/rosia-outlet/maps/roisa-outlet-info-window-controller.js"></script>

--}}
{{--locaiton service of rosia--}}{{--

<script src="app/rosia-outlet/rosia/rosia-location.service.js"></script>
<script src="app/rosia-outlet/maps/rosia-rmap-filter.controller.js"></script>


--}}
{{--SKU SBD--}}{{--

<script src="app/sku-sbd-inventory/sku-sbd.module.js"></script>
<script src="app/sku-sbd-inventory/sbd-list.controller.js"></script>
<script src="app/sku-sbd-inventory/sku-sbd.controller.js"></script>
<script src="app/sku-sbd-inventory/sku-sbd.service.js"></script>

--}}

{{--
<script src="app/retail-outlet/retailOutletList/retail-outlet-list.controller.js"></script>
<script src="app/rosia-outlet/retail-outlets.data.share.service.js"></script>
--}}


{{--
Full Screen Mode
--}}
{{--
<script src="styles/fullscreen.js"></script>--}}










