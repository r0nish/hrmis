<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 2/18/16
	 * Time: 12:19 PM
	 */

	namespace Modules\ApiLog\Providers;


	use Illuminate\Support\ServiceProvider;
	use Modules\ApiLog\Entities\ApiLogInterface;
	use Modules\ApiLog\Repositories\ApiLogRepository;
	use Modules\ApiLog\Repositories\ApiLogRepositoryInterface;
	use Modules\SBD\Entities\SBDReportDistributionInterface;
	use Modules\SBD\Repositories\SBDReportDistributionRepository;
	use Modules\SBD\Repositories\SBDReportDistributionRepositoryInterface;


	class ApiLogRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(ApiLogRepositoryInterface ::class, function () {
				return new ApiLogRepository($this->app[ ApiLogInterface::class ]);
			});
		}
	}