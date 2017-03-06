<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 9/9/16
	 * Time: 11:46 AM
	 */

	namespace Modules\Dashboard\Providers;


	use app\Modules\Dashboard\Repositories\DashboardRepository;
	use app\Modules\Dashboard\Repositories\DashboardRepositoryInterface;
	use Illuminate\Support\ServiceProvider;

	class DashboardRepositoryProvider extends ServiceProvider
	{
		/**
		 * Register Service into the Container.
		 *
		 * @return Dashboard
		 */
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(DashboardRepositoryInterface::class, function () {
				return new DashboardRepository($this->app[ DashboardRepositoryInterface::class ]);
			});
		}
	}