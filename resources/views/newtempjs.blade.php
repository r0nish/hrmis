<script src="bower_components/jquery/dist/jquery.js"></script>
<script src="bower_components/angular/angular.js"></script>
<script src="bower_components/angular-ui-router/release/angular-ui-router.js"></script>
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/angular-moment/angular-moment.js"></script>
<script src="bower_components/materialize/js/materialize.js"></script>
<script src="bower_components/angular-map/ng-map.min.js"></script>
<script src="bower_components/ng-csv/ng-csv.min.js"></script>
<script src="bower_components/angular-sanitize/angular-sanitize.js"></script>
<script src="bower_components/angular-cookies/angular-cookies.min.js"></script>

{{--<script src="http://maps.google.com/maps/api/js?key=AIzaSyAMvbbRSFGsBGawwLg5c15nS4sGRSYBzjM"></script>--}}


<!--
 Script for the Optimizations
-->

<script data-require="bindonce@0.3.1" data-server="0.3.1" src="bower_components/bindonce/bindonce.min.js"></script>
<script src="bower_components/sly/core.js"></script>
<script type="text/javascript" src="bower_components/sly/scalyr.js"></script>
<script type="text/javascript" src="bower_components/sly/slyEvaluate.js"></script>
<script type="text/javascript" src="bower_components/sly/slyRepeat.js"></script>



{{--ui bootstrap for typeahead--}}
<script src="bower_components/ui-bootstrap-custom-build/ui-bootstrap-custom-2.1.3.js"></script>
<script src="bower_components/ui-bootstrap-custom-build/ui-bootstrap-custom-2.1.3.min.js"></script>
<script src="bower_components/ui-bootstrap-custom-build/ui-bootstrap-custom-tpls-2.1.3.js"></script>
<script src="bower_components/ui-bootstrap-custom-build/ui-bootstrap-custom-tpls-2.1.3.min.js"></script>


<!-- endbower -->
<!-- endbuild -->

<!-- build:js({.tmp/serve,.tmp/partials,src}) scripts/app.js -->
<!-- inject:js -->
<script src="app/app.js"></script>
<script src="app/index.js"></script>
<script src="app/tabs.js"></script>


<!--
All the scripts that we require all
-->


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

{{--
<script src="app/foundation/config-settings/menu.config.js"></script>
--}}


{{--
Custom Directive Components
--}}
<script src="app/foundation/components/components.module.js"></script>
<script src="app/foundation/components/simple-table-card/widget.directive.js"></script>
<script src="app/foundation/components/template-table-card/template-widget.directive.js"></script>
{{--<script src="app/foundation/components/filter-card/widget.directive.js"></script>--}}
<script src="app/foundation/components/filter-card/new-widget.directive.js"></script>
<script src="app/foundation/components/file-parser/file-parser.directive.js"></script>
{{--<script src="app/configurations/filter-card/widget.directive.js"></script>--}}

{{--
Common Design Settings
--}}


<script src="app/foundation/common-design/common-design-event.service.js"></script>
<script src="app/foundation/common-design/custom-dialog.controller.js"></script>
<script src="bower_components/Chart.js/Chart.js"></script>
<script src="bower_components/angular-chart.js/dist/angular-chart.min.js"></script>

{{--
Navigation Section
--}}

<script src="app/navigation/navigation.module.js"></script>
<script src="app/navigation/navigation.service.js"></script>
<script src="app/navigation/navigation.controller.js"></script>


{{--
<script src="app/controllers/layoutController.js"></script>
--}}

{{--overall content--}}
<script src="app/controllers/rosia-controller.js"></script>

{{--Logout--}}
<script src="app/controllers/app-bar.controller.js"></script>

{{--Main Content--}}
<script src="app/controllers/rosia-container.controller.js"></script>

{{--
Authentication Module
--}}
<script src="app/authentication/authentication.module.js"></script>
<script src="app/authentication/authentication.config.js"></script>
<script src="app/authentication/login/login.controller.js"></script>

<script src="app/authentication/auth.service.js"></script>
<script src="app/authentication/auth-data.service.js"></script>

<script src="app/authentication/profile/profile.controller.js"></script>


{{-- plese inject configuration  module over here (it has to be injected before retail outlet section
as many retail outlet controller relies upon configuration service)
 Configuration Section--}}


{{--user section--}}
<script src="app/configurations/configurations.module.js"></script>
<script src="app/configurations/confirm-dialog.controller.js"></script>
<script src="app/configurations/dynamictable.directive.js"></script>
{{--dashboard section--}}
<script src="app/dashboard/dashboard.module.js"></script>
<script src="app/dashboard/dashboard.controller.js"></script>
<script src="app/dashboard/dashboard.service.js"></script>
<script src="app/dashboard/config.chartjs.js"></script>


{{--end of rmap configuration section--}}

<script src="app/map-print/print.module.js"></script>
<script src="app/map-print/print.controller.js"></script>
<script src="app/map-print/print-service.js"></script>


<script src="app/csv-to-json/csvToJson.module.js"></script>
<script src="app/csv-to-json/csv-to-json.service.js"></script>


{{--country section--}}

<script src="app/configurations/country/country.controller.js"></script>
<script src="app/configurations/country/country-service.js"></script>
