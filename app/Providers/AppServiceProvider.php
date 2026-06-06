<?php

namespace App\Providers;

use App\Repositories\Contracts\RestaurantRepositoryInterface;
use App\Repositories\RestaurantRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RestaurantRepositoryInterface::class, RestaurantRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
