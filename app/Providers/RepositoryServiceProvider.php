<?php

namespace App\Providers;

use App\Contracts\CarMakeRepositoryInterface;
use App\Contracts\CarModelRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CarMakeRepository;
use App\Repositories\CarModelRepository;
use App\Models\CarMake;
use App\Models\CarModel;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // bind the repositories to their interfaces for the dependency injection
        /** Any class that is abstract cannot be resolved as it cannot be instantiated
         * so a bind like $this->app->bind(CarMakeRepositoryInterface::class, CarMakeRepository::class)
         * wouldn't work as the model is abstract
         */
        $this->app->bind(CarMakeRepositoryInterface::class, function () {
            return new CarMakeRepository(new carMake);
        });

        $this->app->bind(CarModelRepositoryInterface::class, function () {
            return new CarModelRepository(new carModel, new carMake);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
