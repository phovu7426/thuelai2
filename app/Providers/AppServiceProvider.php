<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;


// Import các services mới
use App\Services\Admin\Driver\DriverPricingRuleService;
use App\Services\Admin\Driver\DriverContactService;
use App\Services\Admin\Driver\DriverDistanceTierService;
use App\Services\Admin\Driver\DriverPricingTierService;
use App\Services\Admin\Driver\DriverDashboardService;
use App\Services\Admin\Driver\TestimonialService;


// Import các repositories
use App\Repositories\Admin\Driver\DriverPricingRuleRepository;
use App\Repositories\Admin\Driver\DriverContactRepository;
use App\Repositories\Admin\Driver\DriverDistanceTierRepository;
use App\Repositories\Admin\Driver\DriverPricingTierRepository;
use App\Repositories\Admin\Driver\TestimonialRepository;

// Import các models
use App\Models\DriverPricingRule;
use App\Models\DriverContact;
use App\Models\DriverDistanceTier;
use App\Models\DriverPricingTier;
use App\Models\Testimonial;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind các services cho Driver
        $this->app->bind(DriverPricingRuleService::class, function ($app) {
            return new DriverPricingRuleService(new DriverPricingRuleRepository(new DriverPricingRule()));
        });

        $this->app->bind(DriverContactService::class, function ($app) {
            return new DriverContactService(new DriverContactRepository(new DriverContact()));
        });

        $this->app->bind(DriverDistanceTierService::class, function ($app) {
            return new DriverDistanceTierService(new DriverDistanceTierRepository(new DriverDistanceTier()));
        });

        $this->app->bind(DriverPricingTierService::class, function ($app) {
            return new DriverPricingTierService(new DriverPricingTierRepository(new DriverPricingTier()));
        });

        $this->app->bind(DriverDashboardService::class, function ($app) {
            return new DriverDashboardService();
        });

        $this->app->bind(TestimonialService::class, function ($app) {
            return new TestimonialService(new TestimonialRepository(new Testimonial()));
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        
        try {
            // Chỉ thực hiện nếu kết nối thành công
            if (DB::connection()->getPdo()) {
                // Stone layout composer removed - stone views no longer exist
            }
        } catch (\Exception $e) {
            // Không có DB → không thực hiện gì, chỉ log hoặc im lặng
            Log::warning('DB not ready: ' . $e->getMessage());
        }
    }
}
