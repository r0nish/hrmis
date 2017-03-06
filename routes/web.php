<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::group(['prefix' => 'api/v2'], function () {
    Route::resource('login', 'AccountController');
    Route::get('logout', 'AccountController@logout');
});

Auth::routes();

Route::get('/app', 'HomeController@index');

Route::group(['prefix' => 'api/v2', 'namespace' => 'Configurations'], function () {

    Route::get('country/paginated-list', 'CountryController@paginatedList');
    Route::resource('country', 'CountryController');

});

