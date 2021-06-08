<?php

namespace App\Providers;

use App\Contracts\CarMakeRepositoryInterface;
use App\Contracts\CarModelRepositoryInterface;
use App\Contracts\CarRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CarMakeRepository;
use App\Repositories\CarModelRepository;
use App\Repositories\CarRepository;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Car;

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

        $this->app->bind(CarRepositoryInterface::class, function () {
            return new CarRepository(new car, new carMake, new carModel);
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
