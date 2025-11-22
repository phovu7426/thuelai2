<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('cart', function($app)
        {
            $storage = new \App\Services\Cart\DBStorage();
            $events = $app['events'];
            $instanceName = 'cart';
            $session_key = 'cart';
            
            return new \Darryldecode\Cart\Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 