<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\HolidayRepository;
use App\Repositories\WorkDatesRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\HolidayRepositoryInterface;
use App\Repositories\Interfaces\WorkDatesRepositoryInterface;

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
