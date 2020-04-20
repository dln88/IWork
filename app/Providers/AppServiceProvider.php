<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\HolidayRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\WorkDatesRepository;
use App\Repositories\AdminWorkRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\HolidayRepositoryInterface;
use App\Repositories\Interfaces\WorkDatesRepositoryInterface;
use App\Repositories\Interfaces\AdminWorkRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AuthRepositoryInterface::class, 
            AuthRepository::class
        );
        $this->app->bind(
            WorkDatesRepositoryInterface::class, 
            WorkDatesRepository::class
        );
        $this->app->bind(
            HolidayRepositoryInterface::class, 
            HolidayRepository::class
        );

        $this->app->bind(
            AdminWorkRepositoryInterface::class,
            AdminWorkRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
