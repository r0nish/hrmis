<!doctype html>
<html class="no-js" ng-app="rosiaApp">
<head>
    <meta charset="utf-8">
    <title>HR Application </title>
    <meta name="description" content="HRMIS Application">
    <meta name="autoe" content="flatlogic.com">
    <meta name="viewport" content="width=device-width">

    <!--
      Use the materialize css for the style sheet.
    -->
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


     <link rel="stylesheet" href="{{asset('deployDist/all.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('deployDist/all.min.css')}}"/>


    <?php echo View::make('newtempcss')?>

            <!-- endinject -->
    <!-- endbuild -->
</head>
<body>

<div class="full-height" ui-view></div>


<script src="http://maps.google.com/maps/api/js?key=AIzaSyAMvbbRSFGsBGawwLg5c15nS4sGRSYBzjM"></script>


{{--<script src="{{asset('deployDist/all.min.js')}}"></script>--}}

<?php  // echo View::make('newtempjs')?>

<?php  echo View::make('newtempjs')?>


</body>
</html>