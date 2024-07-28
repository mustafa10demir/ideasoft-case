<?php

namespace App\Providers;

use App\Repositories\Contracts\Order\DiscountRepositoryInterface;
use App\Repositories\Contracts\Order\OrderRepositoryInterface;
use App\Repositories\Discount\DiscountRepository;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind( OrderRepositoryInterface::class, OrderRepository::class );
        $this->app->bind( DiscountRepositoryInterface::class, DiscountRepository::class );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
