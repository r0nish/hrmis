<?php

	namespace App\Modules\User\Providers;

	use Illuminate\Support\ServiceProvider;
	use App\Modules\User\Entities\UserGroupInterface;
	use App\Modules\User\Repositories\UserGroupRepositoryInterface;
	use App\Modules\User\Repositories\UserGroupRepository;

	class UserGroupRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserGroupRepositoryInterface::class, function () {
				return new UserGroupRepository($this->container[ UserGroupInterface::class ]);
			});
		}
	}
