<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Restaurant\RestaurantRepositoryInterface;
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
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
