<?php

namespace App\Modules\Configurations\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Configurations\Entities\Country;
use App\Modules\Configurations\Entities\CountryInterface;

class CountryProvider extends ServiceProvider
{
    /**
     * Register Service into the Container.
     *
     * @return CountryModel
     */
    public function register()
    {
        //Register BuModelInterface
        $this->container = $this->app;
        $this->container->bind(CountryInterface::class, function () {
            return new Country();
        });
    }
}
