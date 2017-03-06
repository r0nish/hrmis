<?php
	/**
	 * Created by PhpStorm.
	 * User: BNTA
	 * Date: 1/13/2016
	 * Time: 9:01 AM.
	 */

	namespace App\Modules\User\Providers;

	use Illuminate\Support\ServiceProvider;
	use App\Modules\User\Entities\UserInterface;
	use App\Modules\User\Repositories\UserRepositoryInterface;
	use App\Modules\User\Repositories\UserRepository;

	class UserRepositoryProvider extends ServiceProvider
	{
		public function register()
		{
			$this->container = $this->app;
			$this->container->bind(UserRepositoryInterface::class, function () {
				return new UserRepository($this->container[ UserInterface::class ]);
			});
		}
	}
