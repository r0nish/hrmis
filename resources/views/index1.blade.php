<!doctype html>
<html class="no-js" ng-app="app">
<head>
    <meta charset="utf-8">
    <title>ROSIA </title>
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
    <link rel="icon" type="image/png" href="favicon.png"/>
{{--
    <link rel="stylesheet" href="assets/css/all.css">
--}}
    <?php echo View::make('tempcss')?>

</head>

<body translate-cloak ng-class="bodyClasses">
<!--[if lt IE 10]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->


<div class="full-height" ui-view></div>



{{--
<script src="assets/js/all.js"></script>--}}
<?php echo View::make('tempjs')?>

</body>
</html>
