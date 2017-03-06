<?php
	namespace App\Modules\User\Providers;

	use App\Modules\User\Entities\UserGroupPermissionInterface;
	use App\Modules\User\Entities\UserGroupPermission;
	use Illuminate\Support\ServiceProvider;

	class UserGroupPermissionProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserGroupPermissionInterface::class, function () {
				return new UserGroupPermission();
			});
		}
	}
