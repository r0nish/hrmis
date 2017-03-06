<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\EntityPermissionInterface;
	use Modules\Security\Repositories\EntityPermissionRepository;
	use Modules\Security\Repositories\EntityPermissionRepositoryInterface;

	class EntityPermissionRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(EntityPermissionRepositoryInterface::class, function () {
				return new EntityPermissionRepository($this->container[ EntityPermissionInterface::class ]);
			});
		}
	}
