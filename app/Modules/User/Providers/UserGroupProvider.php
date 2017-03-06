<?php

	namespace App\Modules\User\Providers;

	use App\Modules\User\Entities\UserGroupInterface;
	use App\Modules\User\Entities\UserGroup;
	use Illuminate\Support\ServiceProvider;

	class UserGroupProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserGroupInterface::class, function () {
				return new UserGroup();
			});
		}
	}
