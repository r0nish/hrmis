<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\EntityPropertyInterface;
	use Modules\Security\Repositories\EntityPropertyRepository;
	use Modules\Security\Repositories\EntityPropertyRepositoryInterface;

	class EntityPropertyRepositoryProvider extends ServiceProvider
	{

		/**
		 * Register the service provider.
		 */
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(EntityPropertyRepositoryInterface::class, function () {
				return new EntityPropertyRepository($this->container[ EntityPropertyInterface::class ]);
			});
		}

	}

