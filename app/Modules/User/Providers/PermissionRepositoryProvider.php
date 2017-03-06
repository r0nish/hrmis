<?php

	namespace App\Modules\User\Providers;

	use Illuminate\Support\ServiceProvider;
	use App\Modules\User\Entities\PermissionInterface;
	use App\Modules\User\Repositories\PermissionRepositoryInterface;
	use App\Modules\User\Repositories\PermissionRepository;

	class PermissionRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(PermissionRepositoryInterface::class, function () {
				return new PermissionRepository($this->container[ PermissionInterface::class ]);
			});
		}
	}
