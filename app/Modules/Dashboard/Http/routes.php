<?php
/**
 * Created by PhpStorm.
 * User: binita
 * Date: 8/22/16
 * Time: 3:10 PM
 */
Route::group(['prefix' => 'api/v2'], function () {
    Route::post('download/report', 'Modules\Dashboard\Http\Controllers\DashboardController@getReports');
});

Route::group([
    'prefix' => 'api/v2',
    'namespace' => 'Modules\Dashboard\Http\Controllers',
    'middleware' => ['oauth', 'authorize']
], function () {

    Route::post('dash-board/report', 'DashboardController@getDashBoardReport');
    Route::post('dash-board/detail-view/report', 'DashboardController@getDetailViewReports');

    Route::post('dash-board/active-dse-info/report', 'DashboardController@getDetailOfActiveDse');
    Route::post('dash-board/active/ro-call', 'DashboardController@getDetailOfActiveDseRouteRetailOutlet');
    Route::post('dash-board/offline/ro-call', 'DashboardController@getDetailOfflineRouteRetailOutlet');


    Route::post('dash-board/scheduled-call/report', 'DashboardController@getDetailOfScheduledCall');
    Route::post('dash-board/scheduled/ro-call', 'DashboardController@getScheduleRouteRetailOutlet');

    Route::post('dash-board/success-call/report', 'DashboardController@getDetailOfSuccessFullCall');
    Route::post('dash-board/success/ro-call', 'DashboardController@getSuccessfulRouteRetailOutlet');

    Route::post('dash-board/unsuccess-call/report', 'DashboardController@getDetailOfUnSuccessFullCall');
    Route::post('dash-board/unsuccess/ro-call', 'DashboardController@getUnSuccessfulRouteRetailOutlet');

    Route::post('dash-board/call-made/report', 'DashboardController@getDetailOfCallMade');
    Route::post('dash-board/call-made/ro-call', 'DashboardController@getDetailOfCallMadeRouteRetailOutlet');


    Route::post('dash-board/month-report/report', 'DashboardController@getDashBoardMonthlyReport');

    // Route::post('dash-board/all-order-value/report', 'DashboardController@getAllOrderStatusCountWithAmount');
    // Route::post('dash-board/today-order-value/report', 'DashboardController@getTodayOrderStatusCountWithAmount');
    Route::post('dash-board/call-not-made/report', 'DashboardController@getCallNotPerformedDetail');
    Route::post('dash-board/call-not-made/ro-call', 'DashboardController@getCallNotPerformedRouteRetailOutlet');

    Route::post('dash-board/dse-productivity', 'DashboardController@dseProductivityReport');
    Route::post('dash-board/summary-report', 'DashboardController@getSummaryReport');
    Route::post('dash-board/channel-category-report', 'DashboardController@getChannelCategoryWiseReport');
    Route::post('dash-board/sales-report-old', 'DashboardController@getSalesSummaryReport');
    Route::get('dash-board/sales-report', 'DashboardController@getSalesSummaryReport');
    Route::get('dash-board/sales-report-get', 'DashboardController@getSalesSummaryReport');


});