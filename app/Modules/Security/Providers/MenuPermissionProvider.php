<?php

	namespace Modules\Security\Providers;


	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\MenuPermission;
	use Modules\Security\Entities\MenuPermissionInterface;

	class MenuPermissionProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(MenuPermissionInterface::class, function () {
				return new MenuPermission();
			});
		}
	}
