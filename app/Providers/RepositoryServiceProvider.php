<?php

namespace App\Providers;

use App\Contracts\CarMakeRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CarMakeRepository;
use App\Models\CarMake;

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
        $this->app->bind(CarMakeRepositoryInterface::class, function () {
            /** Any class that is abstract cannot be resolved as it cannot be instantiated
             * so a bind like $this->app->bind(CarMakeRepositoryInterface::class, CarMakeRepository::class)
             * wouldn't work as the model is abstract
            */
            return new CarMakeRepository(new carMake);
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
