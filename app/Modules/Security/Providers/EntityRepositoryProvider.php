<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\EntityInterface;
	use Modules\Security\Repositories\EntityRepository;
	use Modules\Security\Repositories\EntityRepositoryInterface;


	class EntityRepositoryProvider extends ServiceProvider
	{

		/**
		 * Register the service provider.
		 */
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(EntityRepositoryInterface::class, function () {
				return new EntityRepository($this->container[ EntityInterface::class ]);
			});
		}

	}

