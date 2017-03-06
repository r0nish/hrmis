<?php

	namespace App\Modules\User\Providers;

	use App\Modules\User\Repositories\OAuthRepository;
	use OAuth2;

	use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

	class OAuthServerProvider extends ServiceProvider
	{
		/**
		 * The policy mappings for the application.
		 *
		 * @var array
		 */
		/*    protected $policies = [
				'App\Model' => 'App\Policies\ModelPolicy',
			];*/

		/**
		 * Register any application authentication / authorization services.
		 *
		 * @param \Illuminate\Contracts\Auth\Access\Gate $gate
		 */

		public function register()
		{

			$this->container = $this->app;
			$this->container->singleton('OauthServer', function () {
				$storage = new OAuthRepository();
				$server = new OAuth2\Server($storage);
				$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
				$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));

				return $server;
			});
			/*
			
					$this->container->bind(BusinessUnitInterface::class, function () {
						return new BusinessUnit();
					});
			
					$storage = new \app\Http\Controllers\MyPDO(App::make('db')->getPdo());
					$server = new OAuth2\Server($storage);
					$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
					$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
					return $server;*/

		}
	}
