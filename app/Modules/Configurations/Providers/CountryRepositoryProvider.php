<?php


namespace App\Modules\Configurations\Providers;

use App\Modules\Configurations\Entities\CountryInterface;
use Illuminate\Support\ServiceProvider;
use App\Modules\Configurations\Repositories\CountryRepository;
use App\Modules\Configurations\Repositories\CountryRepositoryInterface;

class CountryRepositoryProvider extends ServiceProvider
{
    /**
     * Register Service into the Container.
     *
     * @return CountryRepository
     */
    public function register()
    {
        // Register CountryRepositoryInterface
        $this->container = $this->app;
        $this->container->bind(CountryRepositoryInterface::class, function () {
            return new CountryRepository($this->app[CountryInterface::class]);
        });
    }
}
