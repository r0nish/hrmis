<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 2/18/16
	 * Time: 12:19 PM
	 */

	namespace Modules\ApiLog\Providers;


	use Illuminate\Support\ServiceProvider;
	use Modules\ApiLog\Entities\ApiLog;
	use Modules\ApiLog\Entities\ApiLogInterface;


	class ApiLogProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(ApiLogInterface::class, function () {
				return new ApiLog();
			});
		}
	}