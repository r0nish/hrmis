<?php
/**
 * Created by PhpStorm.
 * User: Dell'
 * Date: 3/3/2017
 * Time: 2:34 PM
 */
Route::group(['prefix' => 'api/v2', 'namespace' => 'App\Modules\Configurations\Http\Controllers'], function () {

    Route::resource('country', 'CountryControllereeeeeeeeee');

});