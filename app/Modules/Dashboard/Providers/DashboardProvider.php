<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 9/9/16
	 * Time: 11:46 AM
	 */

	namespace Modules\Dashboard\Providers;


	use Illuminate\Support\ServiceProvider;
	use Modules\Dashboard\Entities\Dashboard;
	use Modules\Dashboard\Entities\DashboardInterface;

	class DashboardProvider extends ServiceProvider
	{
		/**
		 * Register Service into the Container.
		 *
		 * @return Adjustment
		 */
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(DashboardInterface::class, function () {
				return new Dashboard();
			});
		}
	}
