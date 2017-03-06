<?php

	Route::group(['prefix' => 'api/v2', 'namespace' => 'Modules\User\Http\Controllers', 'middleware' => ['oauth', 'authorize']], function () {

		Route::post('user/update-password', 'UserController@updateUserPassword');

		Route::get('permission/paginated-list', 'PermissionController@paginatedList');
		Route::resource('permission', 'PermissionController');
		Route::get('permission/{id}/deactivate', 'PermissionController@deactivate');
		Route::get('permission/{id}/activate', 'PermissionController@activate');


		/***
		 * END ROUTE LIST
		 */

		Route::get('user-group/paginated-list', 'UserGroupController@paginatedList');
		Route::resource('user-group/paginated-list', 'UserGroupController@paginatedList');
		//   Route::get('user/paginated-list', 'UserController@paginatedUserList');
		Route::get('user/paginated-list', 'UserController@paginatedList');

		Route::get('user-hierarchy/{id}', 'UserController@userHierarchy');
		Route::get('user-detail/{id}', 'UserController@userDetail');
		Route::get('get-user', 'UserController@getUser');
		Route::resource('user', 'UserController');
		Route::resource('user-group', 'UserGroupController');
		Route::post('user/assignBU', 'UserController@assignDistributor');
		Route::get('user-group/deactivate/{user}', 'UserGroupController@deactivate');
		Route::get('user-group/activate/{user}', 'UserGroupController@activate');

		/** get the user group to assign territory  */
		Route::post('user-group/assign-user-territory', 'UserGroupController@getUserGroupToAssignTerritory');


		Route::get('user/deactivate/{user}', 'UserController@deactivate');
		Route::get('user/activate/{user}', 'UserController@activate');
		Route::post('user/assignParentUser', 'UserController@assignParentUserGroup');
		Route::post('user/attach-geo-location', 'UserController@attachGeographicLocation');
		Route::post('user/assignTown', 'UserController@assignTown');
		Route::post('user/filter-user', 'UserController@getFilterList');
		Route::post('route/assignUser', 'UserController@assignRoute');
		//Route::post('route/assignUser', 'API\Sales\RouteAndOutlet\Route\RouteController@assignUser');
		Route::post('user/listUsers', 'UserController@assignChildUserTownWise');
		Route::post('user/group/listUsers', 'UserController@getUserGroupWise');

		Route::post('user/route/remove-assign-route', 'UserController@detachRoute');

		Route::post('user/assign-child', 'UserController@getChildUserBUWise');


		Route::post('user-location/location-list', 'UserController@listUserLocation');

		Route::post('user/edit-pivot', 'UserController@editPivotData');

		/**
		 * get the  user under that distributor user
		 *
		 */
		Route::post('user/dse-list', 'UserController@getUserUnderDistributor');

		Route::post('user/route-dse-list', 'UserController@dseListToAssignRoute');


		/***
		 *
		 *
		 */
		Route::post('user/distributor-dse', 'UserController@dseUnderDistributor');

		/***
		 * GET the list of user(parent user list [ ASM => ZM user List])
		 */
		Route::post('user/user-group-location', 'UserController@getGeoLocationListParentUser');

		/**
		 * SFH assign distributor
		 */
		Route::post('assign-user-distributor-sfh', 'UserController@assignDistributorUserSFH');

		Route::get('user-distributor-sfh/{id}', 'UserController@getSFHUserDistributor');


	});
