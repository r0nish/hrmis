<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\Menu;
	use Modules\Security\Entities\MenuInterface;

	class MenuProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(MenuInterface::class, function () {
				return new Menu();
			});
		}
	}
