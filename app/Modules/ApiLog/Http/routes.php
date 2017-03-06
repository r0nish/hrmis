<?php

	Route::group([
					 'prefix'    => 'api/v2',
					 'namespace' => 'Modules\ApiLog\Http\Controllers',
					 //  'middleware' => ['oauth', 'authorize']
				 ], function () {

		Route::resource('api-log', 'ApiLogController');

	});
