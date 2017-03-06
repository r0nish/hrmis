<?php


	Route::group(['prefix' => 'api/v2', 'namespace' => 'Modules\Security\Http\Controllers'], function () {

		/**
		 * END ROUTE LIST FOR PROMOTION
		 */
		// Route::group(['middleware' => ['oauth','permission']], function () {


//Menu settings
		Route::resource('menu', 'Menu\MenuController');

		Route::post('menu/deactivate/{id}', 'Menu\MenuController@deactivate');
		Route::post('menu/activate/{id}', 'Menu\MenuController@activate');


		Route::get('generate-menu/{role_id}/{show_all}/{is_visible}', 'Menu\MenuController@generateMenu');

		Route::get('menu-code/{id_menu}', 'Menu\MenuController@getMenuCode');
		Route::resource('menu-permission', 'MenuPermission\MenuPermissionController');
		Route::post('menu-permission/deactivate', 'MenuPermission\MenuPermissionController@deactivate');
		Route::get('get-menu-children/{menu_id}', 'Menu\MenuController@getMenuChildren');
		Route::get('get-menu-permission/{role_id}', 'Menu\MenuController@getMenuPermission');

		Route::post('add-menu-permission/{parent_menu_id}',
					'Menu\MenuController@addParentMenuPermission');

		Route::post('edit-menu-permission', 'Menu\MenuController@editMenuPermission');

		Route::get('get-menu-permission-settings/{menu_id}',
				   'Menu\MenuController@getMenuPermissionSettings');

		Route::post('menu-permission/configure', 'MenuPermission\MenuPermissionController@configure');

		Route::post('entity-permission/configure', 'EntityPermission\EntityPermissionController@configure');

//end Menu settings


//Start Entities settings

		Route::get('menu/entities/{menu_id}', 'Entity\EntityController@getEntitiesByMenu');

		Route::get('get-menu-permission/{role_id}', 'Menu\MenuController@getMenuPermission');
		Route::post('add-menu-permission/{parent_menu_id}',
					'Menu\MenuController@addParentMenuPermission');
		Route::post('edit-menu-permission', 'Menu\MenuController@editMenuPermission');

		Route::resource('entity', 'Entity\EntityController');

		Route::get('entity/deactivate/{id}', 'Entity\EntityController@deactivate');

		Route::get('entity/activate/{id}', 'Entity\EntityController@activate');

		Route::resource('entity-property', 'EntityProperty\EntityPropertyController');

		Route::get('entity-property/deactivate/{id}', 'EntityProperty\EntityPropertyController@deactivate');
		Route::get('entity-property/activate/{id}', 'EntityProperty\EntityPropertyController@activate');
		Route::get('get-entity-property/{menu_id}', 'EntityProperty\EntityPropertyController@deactivate');


		Route::resource('entity-permission', 'EntityPermission\EntityPermissionController');

		Route::get('entity-permission/deactivate/{id}',
				   'EntityPermission\EntityPermissionController@deactivate');

		Route::get('entity-permission/activate/{id}',
				   'EntityPermission\EntityPermissionController@activate');


		Route::post('edit-menu-entities-permission',
					'EntityProperty\EntityPropertyController@editMenuEntitiesPermission');

		Route::get('get-entities-permission-settings/{entities_property_id}',
				   'EntityProperty\EntityPropertyController@getEntitiesPermissionSettings');

		Route::get('get-menu-entities-properties/{menu_id}',
				   'EntityProperty\EntityPropertyController@getEntitiesSettings');

		/**
		 * Get menu of the role with the permission.
		 */

		Route::get('menu/permission/role/{role_id}', 'MenuPermission\MenuPermissionController@getMenuPermissionByRole');


		/**
		 * Get entity-property permissions by role for entity
		 */
		Route::get('entity-property/permission/role/entity/{role_id}/{entity_id}', 'EntityProperty\EntityPropertyController@getEntityPropertyPermissionByRoleIdAndEntityId');


		Route::post('menu/list-child', 'Menu\MenuController@getChildMenu');

	});

