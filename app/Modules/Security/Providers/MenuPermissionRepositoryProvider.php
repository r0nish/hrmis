<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\MenuPermissionInterface;
	use Modules\Security\Repositories\MenuPermissionRepository;
	use Modules\Security\Repositories\MenuPermissionRepositoryInterface;

	class MenuPermissionRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(MenuPermissionRepositoryInterface::class, function () {
				return new MenuPermissionRepository($this->container[ MenuPermissionInterface::class ]);
			});
		}
	}
