<?php

	namespace Modules\Security\Providers;


	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\EntityPermission;
	use Modules\Security\Entities\EntityPermissionInterface;

	class EntityPermissionProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(EntityPermissionInterface::class, function () {
				return new EntityPermission();
			});
		}
	}
