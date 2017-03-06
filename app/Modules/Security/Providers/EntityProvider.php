<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\EntityInterface;
	use Modules\Security\Entities\Entity;

	class EntityProvider extends ServiceProvider
	{
		/**
		 * Register Service into the Container.
		 *
		 * @return Entity
		 */
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(EntityInterface::class, function () {
				return new Entity();
			});
		}
	}
