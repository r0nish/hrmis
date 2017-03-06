
<script src="{{ asset('bower_components/jquery/dist/jquery.js')}}"></script>
<script src="{{ asset('bower_components/angular/angular.js')}}"></script>
<script src="{{ asset('bower_components/angular-animate/angular-animate.js')}}"></script>
<script src="{{ asset('bower_components/Chart.js/Chart.js')}}"></script>
<script src="{{ asset('bower_components/angular-chart.js/dist/angular-chart.js')}}"></script>
<script src="{{ asset('bower_components/angular-cookies/angular-cookies.js')}}"></script>
<script src="{{ asset('bower_components/angular-digest-hud/digest-hud.js')}}"></script>
<script src="{{ asset('bower_components/angular-dragula/dist/angular-dragula.js')}}"></script>
<script src="{{ asset('bower_components/angular-google-chart/ng-google-chart.js')}}"></script>
<script src="{{ asset('bower_components/lodash/lodash.js')}}"></script>
<script src="{{ asset('bower_components/angular-google-maps/dist/angular-google-maps.js')}}"></script>
<script src="{{ asset('bower_components/highlightjs/highlight.pack.js')}}"></script>
<script src="{{ asset('bower_components/angular-highlightjs/build/angular-highlightjs.js')}}"></script>
<script src="{{ asset('bower_components/angular-linkify/angular-linkify.js')}}"></script>
<script src="{{ asset('bower_components/angular-local-storage/dist/angular-local-storage.js')}}"></script>
<script src="{{ asset('bower_components/angular-aria/angular-aria.js')}}"></script>
<script src="{{ asset('bower_components/angular-material/angular-material.js')}}"></script>
<script src="{{ asset('bower_components/angular-material-data-table/dist/md-data-table.min.js')}}"></script>
<script src="{{ asset('bower_components/angular-messages/angular-messages.js')}}"></script>
<script src="{{ asset('bower_components/moment/moment.js')}}"></script>
<script src="{{ asset('bower_components/angular-moment/angular-moment.js')}}"></script>
<script src="{{ asset('bower_components/angular-resource/angular-resource.js')}}"></script>
<script src="{{ asset('bower_components/angular-touch/angular-touch.js')}}"></script>
<script src="{{ asset('bower_components/angular-translate/angular-translate.js')}}"></script>
<script src="{{ asset('bower_components/angular-translate-loader-partial/angular-translate-loader-partial.js')}}"></script>
<script src="{{ asset('bower_components/angular-translate-storage-cookie/angular-translate-storage-cookie.js')}}"></script>
<script src="{{ asset('bower_components/angular-translate-storage-local/angular-translate-storage-local.js')}}"></script>
<script src="{{ asset('bower_components/angular-ui-calendar/src/calendar.js')}}"></script>
<script src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.js')}}"></script>
<script src="{{ asset('bower_components/angular-ui-router/release/angular-ui-router.js')}}"></script>
<script src="{{ asset('bower_components/countUp.js/countUp.js')}}"></script>
<script src="{{ asset('bower_components/rangy/rangy-core.js')}}"></script>
<script src="{{ asset('bower_components/rangy/rangy-classapplier.js')}}"></script>
<script src="{{ asset('bower_components/rangy/rangy-highlighter.js')}}"></script>
<script src="{{ asset('bower_components/rangy/rangy-selectionsaverestore.js')}}"></script>
<script src="{{ asset('bower_components/rangy/rangy-serializer.js')}}"></script>
<script src="{{ asset('bower_components/rangy/rangy-textrange.js')}}"></script>
<script src="{{ asset('bower_components/textAngular/src/textAngular.js')}}"></script>
<script src="{{ asset('bower_components/textAngular/src/textAngular-sanitize.js')}}"></script>
<script src="{{ asset('bower_components/textAngular/src/textAngularSetup.js')}}"></script>
<script src="{{ asset('bower_components/ng-file-upload/ng-file-upload-shim.js')}}"></script>
<script src="{{ asset('bower_components/ng-file-upload/ng-file-upload.js')}}"></script>
<!-- endbower -->

<!-- enqueue all translations for calendar (remove if you dont need multilanguage) -->
<!-- <script src="{{ asset('bower_components/fullcalendar/dist/lang-all.js')}}"></script> -->
<!-- endbuild -->

<!-- build:js({.tmp/serve,.tmp/partials,src}) scripts/app.js -->
<!-- inject:js -->


<script src="{{ asset('app/triangular/layouts/layouts.module.js')}}"></script>
<script src="{{ asset('app/triangular/layouts/default/default-layout.controller.js')}}"></script>
<script src="{{ asset('app/triangular/layouts/default/default-content.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/components.module.js')}}"></script>
<script src="{{ asset('app/triangular/components/wizard/wizard.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/wizard/wizard-form.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/widget/widget.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/toolbars/toolbar.controller.js')}}"></script>
<script src="{{ asset('app/triangular/components/table/table.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/table/table-start-from.filter.js')}}"></script>
<script src="{{ asset('app/triangular/components/table/table-cell-image.filter.js')}}"></script>
<script src="{{ asset('app/triangular/components/notifications-panel/notifications-panel.controller.js')}}"></script>
<script src="{{ asset('app/triangular/components/menu/menu.provider.js')}}"></script>
<script src="{{ asset('app/triangular/components/menu/menu.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/menu/menu.controller.js')}}"></script>
<script src="{{ asset('app/triangular/components/menu/menu-item.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/loader/loader.directive.js')}}"></script>
<script src="{{ asset('app/triangular/components/loader/loader-service.js')}}"></script>
<script src="{{ asset('app/triangular/components/footer/footer.controller.js')}}"></script>
<script src="{{ asset('app/triangular/components/breadcrumbs/breadcrumbs.service.js')}}"></script>
<script src="{{ asset('app/examples/elements/elements.module.js')}}"></script>







<script src="{{ asset('app/examples/auth.module.js')}}"></script>
<script src="{{ asset('app/examples/route-scope.run.js')}}"></script>
<script src="{{ asset('app/examples/http-interceptor.service.js')}}"></script>
<script src="{{ asset('app/examples/auth-data.service.js')}}"></script>
<script src="{{ asset('app/examples/auth.service.js')}}"></script>
<script src="{{ asset('app/examples/directives/directive.module.js')}}"></script>

<script src="{{ asset('app/examples/directives/dynamictable.directive.js')}}"></script>




<script src="{{ asset('app/examples/menu/menu.module.js')}}"></script>
<script src="{{ asset('app/examples/maps/maps.module.js')}}"></script>
<script src="{{ asset('app/examples/forms/forms.module.js')}}"></script>


<script src="{{ asset('app/examples/dashboards/dashboards.module.js')}}"></script>
<script src="{{ asset('app/examples/charts/charts.module.js')}}"></script>
<script src="{{ asset('app/examples/authentication/authentication.module.js')}}"></script>
<script src="{{ asset('app/examples/authentication/login/login.controller.js')}}"></script>
<script src="{{ asset('app/triangular/themes/themes.module.js')}}"></script>
<script src="{{ asset('app/triangular/directives/directives.module.js')}}"></script>
<script src="{{ asset('app/examples/layouts/layouts.module.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/dashboards.module.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-weather.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-twitter.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-todo.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-server.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-load-data.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-google-geochart.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-contacts.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-chat.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-chartjs-ticker.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-chartjs-pie.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-chartjs-line.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/widgets/widget-calendar.directive.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/social/dashboard-social.controller.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/server/dashboard-server.controller.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/sales/sales.service.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/sales/order-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/sales/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/sales/date-change-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/sales/dashboard-sales.controller.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/analytics/dashboard-analytics.controller.js')}}"></script>

<script src="{{ asset('app/triangular/themes/theming.provider.js')}}"></script>
<script src="{{ asset('app/triangular/themes/skins.provider.js')}}"></script>
<script src="{{ asset('app/triangular/triangular.module.js')}}"></script>
<script src="{{ asset('app/triangular/layouts/layouts.provider.js')}}"></script>

<script src="{{ asset('app/triangular/directives/palette-background.directive.js')}}"></script>
<script src="{{ asset('app/examples/ui/ui.module.js')}}"></script>
<script src="{{ asset('app/examples/todo/todo.module.js')}}"></script>
<script src="{{ asset('app/examples/extras/extras.module.js')}}"></script>

<script src="{{ asset('app/examples/dashboards/dashboards.config.js')}}"></script>
<script src="{{ asset('app/examples/dashboards/dashboard-draggable-controller.js')}}"></script>
<script src="{{ asset('app/examples/calendar/calendar.module.js')}}"></script>

<script src="{{ asset('app/examples/authentication/authentication.config.js')}}"></script>
<script src="{{ asset('app/triangular/triangular.run.js')}}"></script>
<script src="{{ asset('app/triangular/settings.provider.js')}}"></script>
<script src="{{ asset('app/triangular/config.route.js')}}"></script>
<script src="{{ asset('app/seed-module/seed.module.js')}}"></script>
<script src="{{ asset('app/seed-module/seed.config.js')}}"></script>
<script src="{{ asset('app/seed-module/seed-page.controller.js')}}"></script>
<script src="{{ asset('app/examples/examples.module.js')}}"></script>
<script src="{{ asset('app/app.module.js')}}"></script>
<script src="{{ asset('app/config.triangular.themes.js')}}"></script>
<script src="{{ asset('app/config.triangular.settings.js')}}"></script>
<script src="{{ asset('app/config.triangular.layout.js')}}"></script>
<script src="{{ asset('app/config.translate.js')}}"></script>
<script src="{{ asset('app/config.route.js')}}"></script>


{{--
Dynamic Menu Settings
--}}
<script src="{{ asset('app/examples/examples.config.js')}}"></script>



<script src="{{ asset('app/examples/tools/tools.module.js')}}"></script>
<script src="{{ asset('app/examples/tools/tools.config.js')}}"></script>


<script src="{{ asset('app/examples/configurations/configurations.module.js')}}"></script>
<script src="{{ asset('app/examples/custom-menu.provider.js')}}"></script>

<script src="{{ asset('app/examples/configurations/configurations.config.js')}}"></script>
<script src="{{ asset('app/examples/configurations/dynamictable.directive.js')}}"></script>

{{--
Parent Class
--}}
<script src="{{ asset('app/examples/common-design-event.service.js')}}"></script>
<script src="{{ asset('app/examples/base-server.service.js')}}"></script>
<script src="{{ asset('app/examples/base-controller.service.js')}}"></script>
<script src="{{ asset('app/examples/http-interceptor.js')}}"></script>
<script src="{{ asset('app/examples/validation/validation.service.js')}}"></script>

<!----Weight and Volume --->
<script src="{{ asset('app/examples/configurations/weightsAndVolume/weightsAndVolume.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/weightsAndVolume/weightsAndVolume.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/weightsAndVolume/weightsAndVolume-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/weightsAndVolume/fab-button.controller.js')}}"></script>

<!--- Unit  --->
<script src="{{ asset('app/examples/configurations/unit/unit.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/unit/unit.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/unit/unit-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/unit/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/distributors/distributors.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/distributors/distributor-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/tools/tools.module.js')}}"></script>
<script src="{{ asset('app/examples/tools/tools.config.js')}}"></script>

<script src="{{ asset('app/examples/configurations/businessUnit/business-unit.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/businessUnit/assign-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/businessUnit/business-unit.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/businessUnit/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/businessUnit/dialog.controller.js')}}"></script>


<script src="{{ asset('app/examples/configurations/principal/principal.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/principal/principal.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/principal/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/principal/principal-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/town/town.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/town/town.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/town/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/town/town-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/town/town-filter-dialog.controller.js')}}"></script>


<script src="{{ asset('app/examples/configurations/geographicLocation/geographicLocation.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/geographicLocation/geographicLocation.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/geographicLocation/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/geographicLocation/geoLocation-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/geographicLocation/geographicLookUp.service.js')}}"></script>


<script src="{{ asset('app/examples/configurations/geographicLocation/geo-location-town-controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/channelAndCategory/channel/channel.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/channelAndCategory/category/category.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/channelAndCategory/channel/channel.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/channelAndCategory/channel/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/channelAndCategory/channel/channel-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/channelAndCategory/channel/category-dialog.controller.js')}}"></script>




<script src="{{ asset('app/examples/configurations/channelAndCategory/category/category.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/channelAndCategory/channel/nutritionController.js')}}"></script>

<script src="{{ asset('app/examples/account/account.module.js')}}"></script>
<script src="{{ asset('app/examples/account/account.config.js')}}"></script>
<script src="{{ asset('app/examples/account/account.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/sales.module.js')}}"></script>
<script src="{{ asset('app/examples/sales/sales.config.js')}}"></script>
<script src="{{ asset('app/examples/sales/sales.controller.js')}}"></script>


<script src="{{ asset('app/examples/account/account.module.js')}}"></script>
<script src="{{ asset('app/examples/account/account.config.js')}}"></script>
<script src="{{ asset('app/examples/account/account.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/sales.module.js')}}"></script>
<script src="{{ asset('app/examples/sales/sales.config.js')}}"></script>
<script src="{{ asset('app/examples/sales/sales.controller.js')}}"></script>

<script src="{{ asset('app/examples/account/account.module.js')}}"></script>
<script src="{{ asset('app/examples/account/account.config.js')}}"></script>
<script src="{{ asset('app/examples/account/account.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/sales.module.js')}}"></script>
<script src="{{ asset('app/examples/sales/sales.config.js')}}"></script>
<script src="{{ asset('app/examples/sales/sales.controller.js')}}"></script>


<script src="{{ asset('app/examples/inventory/inventory.module.js')}}"></script>
<script src="{{ asset('app/examples/inventory/inventory.config.js')}}"></script>
<script src="{{ asset('app/examples/inventory/inventory.controller.js')}}"></script>


<script src="{{ asset('app/examples/reports/reports.module.js')}}"></script>
<script src="{{ asset('app/examples/reports/reports.config.js')}}"></script>
<script src="{{ asset('app/examples/reports/reports.controller.js')}}"></script>


<script src="{{ asset('app/examples/salesForce/sales-force.module.js')}}"></script>
<script src="{{ asset('app/examples/salesForce/sales-force.config.js')}}"></script>
<script src="{{ asset('app/examples/salesForce/sales-force.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/salesForce/sales-force.controller.js')}}"></script>

<script src="{{ asset('app/examples/security/security.module.js')}}"></script>
<script src="{{ asset('app/examples/security/security.config.js')}}"></script>
<script src="{{ asset('app/examples/security/security.controller.js')}}"></script>


<script src="{{ asset('app/examples/configurations/distributors/distributors.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/distributors/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/sku/sku.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sku/sku.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sku/sku-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sku/sku-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sku/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sku/sub-form-controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/services/data-share.service.js')}}"></script>


<script src="{{ asset('app/examples/configurations/skuStock/sku-stock.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/skuStock/sku-stock.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/skuStock/sku-stock-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/skuStock/sku-stock-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/skuStock/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/catalog/catalog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/catalog/catalog.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/catalog/catalog-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/catalog/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/route/visitFrequency/visit-frequency.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitFrequency/visit-frequency.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitFrequency/visit-frequency-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitFrequency/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/route/visitType/visit-type.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitType/visit-type.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitType/visit-type-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitType/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/route/visitCategory/visit-category.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitCategory/visit-category.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitCategory/visit-category-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/visitCategory/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/route/deliveryType/delivery-type.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/deliveryType/delivery-type.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/deliveryType/delivery-type-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/route/deliveryType/fab-button.controller.js')}}"></script>

{{--<script src="{{ asset('app/examples/configurations/periods/period/period.controller.js')}}"></script>--}}
{{--<script src="{{ asset('app/examples/configurations/periods/period/period.service.js')}}"></script>--}}
{{--<script src="{{ asset('app/examples/configurations/periods/period/period-dialog.controller.js')}}"></script>--}}
{{--<script src="{{ asset('app/examples/configurations/periods/period/fab-button.controller.js')}}"></script>--}}

<script src="{{ asset('app/examples/configurations/periods/periodType/period-type-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/periods/periodType/period-type.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/periods/periodType/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/orderProcessing/order-processing.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/orderProcessing/order-processing.service.js')}}"></script>
<script src="{{ asset('app/examples/sales/orderProcessing/order-processing-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/orderProcessing/apply-promotion-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/orderProcessing/order-processing.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/orderProcessing/date-change-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/orderProcessing/FileSaver.js')}}"></script>

<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retail-outlets.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/maps/map-terrain-demo.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutletList/retail-outlets-list.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutletList/retail-outlet-list-service.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutletList/dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutletList/retail-outlet-list-filter.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutlet/retail-outlet-detail.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutlet/detail-gallery.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutlet/detail-gallery-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/retailOutlets/retailOutlet/date-change-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/routeAndOutlet/route/route.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/routeList/route-list.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/routeList/route-list.service.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/routeList/route-list-filter.controller.js')}}"></script>

<script src="{{ asset('app/examples/sales/routeAndOutlet/route/map/route-map.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/routeList/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/routeList/route-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/routeList/transfer-route-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/route-data-share.service.js')}}"></script>

<script src="{{ asset('app/examples/sales/routeAndOutlet/route/services/route-server.service.js')}}"></script>
<script src="{{ asset('app/examples/sales/routeAndOutlet/route/services/route-data-share.service.js')}}"></script>

<script src="{{ asset('app/examples/sales/routeAndOutlet/route/map/route-map-form.service.js')}}"></script>

<script src="{{ asset('app/examples/sales/routeAndOutlet/route/map/route-map-form.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/geographicLocation/dynamicTable.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/geographicLocation/dynamic-table.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/user/userAccount/user-account.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userAccount/user-account.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userAccount/user-account-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userAccount/user-account-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userAccount/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userAccount/supervise-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userAccount/user-account-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userLocation/user-account-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userLocation/user-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/services/data-share.service.js')}}"></script>


<script src="{{ asset('app/examples/configurations/user/userGroup/user-group.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userLocation/user-location.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userLocation/user-location.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userLocation/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userLocation/user-location-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/user/userGroup/user-group.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userGroup/user-group-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/userGroup/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/user/permission/permission.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/permission/permission-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/user/permission/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/menuSettings/menu-settings.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/menuSettings/menu-settings.service.js')}}"></script>

<script src="{{ asset('app/examples/configurations/uiEntitySettings/ui-entity-settings.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/sbd/sbd.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sbd/sbd.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/sbd/sbd-dialog.controller.js')}}"></script>


<script src="{{ asset('app/examples/configurations/entityPermission/entity-property.service.js')}}"></script>


<script src="{{ asset('app/examples/configurations/entityPermission/entity-permission.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/entityPermission/entity-permission.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/entityPermission/entity-permission-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/entityPermission/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/entityPermission/entity-property-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/inventory/grn/grn.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/grn/grn.service.js')}}"></script>
<script src="{{ asset('app/examples/inventory/grn/grn-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/grn/grn-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/grn/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/inventory/stockLedger/stock-ledger.service.js')}}"></script>
<script src="{{ asset('app/examples/inventory/stockLedger/stock-ledger.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/stockLedger/stock-ledger-filter-dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/stockLedger/stock-ledger-detail.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/stockLedger/stock-ledger-filter.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/stockLedger/service/data-share.service.js')}}"></script>
<script src="{{ asset('app/examples/inventory/stockLedger/sku-ledger-info-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/inventory/salesReturn/sales-return.controller.js')}}"></script>
<script src="{{ asset('app/examples/inventory/salesReturn/sales-return.service.js')}}"></script>


<script src="{{ asset('app/examples/configurations/promotion/promotion/promotion.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotion/promotion.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotion/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotion/promotion-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/promotion/promotionCriteria/promotion-criteria.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionCriteria/promotion-criteria.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionCriteria/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionCriteria/dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/promotion/promotionCategory/promotion-category.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionCategory/promotion-category.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionCategory/dialog.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionCategory/fab-button.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/promotion/promotionRule/promotion-rule.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionRule/promotion-rule.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionRule/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionRule/promotion-rule-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/promotion/promotionType/promotion-type.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionType/promotion-type.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionType/fab-button.controller.js')}}"></script>
<script src="{{ asset('app/examples/configurations/promotion/promotionType/promotion-type-dialog.controller.js')}}"></script>

<script src="{{ asset('app/examples/configurations/catalogDetail/catalog-detail.service.js')}}"></script>
<script src="{{ asset('app/examples/configurations/catalogDetail/catalog-detail.controller.js')}}"></script>



{{--
Setup for the FOUNDATION MODULE
--}}

<script src="app/foundation/foundation.module.js"></script>
<script src="app/foundation/foundation.config.js"></script>

<script src="app/foundation/validation/validation.service.js"></script>

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
{{--
<script src="app/foundation/config-settings/menu.config.js"></script>
--}}


{{--
Custom Directive Components
--}}
<script src="app/foundation/components/components.module.js"></script>
<script src="app/foundation/components/simple-table-card/widget.directive.js"></script>
<script src="app/foundation/components/template-table-card/template-widget.directive.js"></script>
<script src="app/foundation/components/filter-card/widget.directive.js"></script>
{{--<script src="app/configurations/filter-card/widget.directive.js"></script>--}}


{{--
Authentication Module
--}}
<script src="app/authentication/authentication.module.js"></script>
<script src="app/authentication/authentication.config.js"></script>
<script src="app/authentication/login/login.controller.js"></script>

<script src="app/authentication/auth.service.js"></script>
<script src="app/authentication/auth-data.service.js"></script>

<script src="app/authentication/profile/profile.controller.js"></script>


