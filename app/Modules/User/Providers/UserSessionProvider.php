<?php

	namespace App\Modules\User\Providers;

	use App\Modules\User\Entities\UserSessionInterface;
	use App\Modules\User\Entities\UserSession;
	use Illuminate\Support\ServiceProvider;

	class UserSessionProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserSessionInterface::class, function () {
				return new UserSession();
			});
		}
	}
