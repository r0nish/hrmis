<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\EntityPropertyInterface;
	use Modules\Security\Entities\EntityProperty;

	class EntityPropertyProvider extends ServiceProvider
	{
		/**
		 * Register Service into the Container.
		 *
		 * @return EntityProperty
		 */
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(EntityPropertyInterface::class, function () {
				return new EntityProperty();
			});
		}
	}
