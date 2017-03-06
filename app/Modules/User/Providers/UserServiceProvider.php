<?php

    namespace App\Modules\User\Providers;

    use Illuminate\Support\ServiceProvider;

    class UserServiceProvider extends ServiceProvider
    {
        /**
         * Indicates if loading of the provider is deferred.
         *
         * @var bool
         */
        protected $defer = false;

        /**
         * Boot the application events.
         */
        public function boot()
        {
            $this->registerConfig();
            $this->registerTranslations();
            $this->registerViews();
            $this->registerRoutes();
        }

        /**
         * Register the service provider.
         */
        public function register()
        {
            //
        }

        /**
         * Register config.
         */
        protected function registerConfig()
        {
            $this->publishes([
                                 __DIR__ . '/../Config/config.php' => config_path('user.php'),
                             ]);
            $this->mergeConfigFrom(
                __DIR__ . '/../Config/config.php', 'user'
            );
        }

        /**
         * Register views.
         */
        public function registerViews()
        {
            $viewPath = base_path('resources/views/modules/user');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                                 $sourcePath => $viewPath,
                             ]);

            $this->loadViewsFrom([$viewPath, $sourcePath], 'user');
        }

        /**
         * Register translations.
         */
        public function registerTranslations()
        {
            $langPath = base_path('resources/lang/modules/user');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'user');
            }
            else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'user');
            }
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides()
        {
            return [];
        }

        /*
		 * Register Routes
		 *
		 * @return void
		 */

        public function registerRoutes()
        {
            if (!$this->app->routesAreCached()) {
                require __DIR__ . '/../Http/routes.php';
            }
        }
    }
