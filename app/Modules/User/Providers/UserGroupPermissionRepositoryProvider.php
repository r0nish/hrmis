<?php

	namespace App\Modules\User\Providers;

	use Illuminate\Support\ServiceProvider;
	use App\Modules\User\Entities\UserGroupPermissionInterface;
	use App\Modules\User\Repositories\UserGroupPermissionRepositoryInterface;
	use App\Modules\User\Repositories\UserGroupPermissionRepository;

	class UserGroupPermissionRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserGroupPermissionRepositoryInterface::class, function () {
				return new UserGroupPermissionRepository($this->container[ UserGroupPermissionInterface::class ]);
			});
		}
	}
