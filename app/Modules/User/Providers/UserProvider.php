<?php
	namespace App\Modules\User\Providers;

	use App\Modules\User\Entities\UserInterface;
	use App\Modules\User\Entities\User;
	use Illuminate\Support\ServiceProvider;

	class UserProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserInterface::class, function () {
				return new User();
			});
		}
	}
