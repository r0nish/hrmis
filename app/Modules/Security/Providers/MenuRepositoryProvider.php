<?php

	namespace Modules\Security\Providers;

	use Illuminate\Support\ServiceProvider;
	use Modules\Security\Entities\MenuInterface;
	use Modules\Security\Repositories\MenuRepository;
	use Modules\Security\Repositories\MenuRepositoryInterface;

	class MenuRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(MenuRepositoryInterface::class, function () {
				return new MenuRepository($this->container[ MenuInterface::class ]);
			});
		}
	}
