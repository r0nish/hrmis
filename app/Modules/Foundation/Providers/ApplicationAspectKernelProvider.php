<?php

	namespace App\Modules\Foundation\Providers;

	use Modules\Foundation\Aspects\ApplicationAspectKernel;
	use Illuminate\Support\ServiceProvider;

	class ApplicationAspectKernelProvider extends ServiceProvider
	{
		/**
		 * Register Service into the Container.
		 *
		 * @return Adjustment
		 */
		public function register()
		{

			$applicationAspectKernel = ApplicationAspectKernel::getInstance();

			$applicationAspectKernel->init();

			/*        $applicationAspectKernel->init(array(
						'debug' => true, // Use 'false' for production mode
						// Cache directory
						'cacheDir' => '../storage/cache/', // Adjust this path if needed
					));*/

		}
	}
