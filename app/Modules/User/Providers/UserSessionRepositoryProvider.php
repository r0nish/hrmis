<?php


	namespace App\Modules\User\Providers;

	use Illuminate\Support\ServiceProvider;
	use App\Modules\User\Entities\UserSessionInterface;
	use App\Modules\User\Repositories\UserSessionRepositoryInterface;
	use App\Modules\User\Repositories\UserSessionRepository;

	class UserSessionRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserSessionRepositoryInterface::class, function () {
				return new UserSessionRepository($this->container[ UserSessionInterface::class ]);
			});
		}
	}
