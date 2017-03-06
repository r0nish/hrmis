<?php

	namespace App\Modules\User\Providers;

	use App\Modules\User\Entities\PermissionInterface;
	use App\Modules\User\Entities\Permission;
	use Illuminate\Support\ServiceProvider;

	class PermissionProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(PermissionInterface::class, function () {
				return new Permission();
			});
		}
	}
