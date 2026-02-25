<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repositories
use App\Repositories\CustomerRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;

// Services
use App\Services\CustomerService;
use App\Services\SubscriptionService;
use App\Services\SipProvisioningService;
use App\Services\Interfaces\CustomerServiceInterface;
use App\Services\Interfaces\SubscriptionServiceInterface;
use App\Services\Interfaces\SipProvisioningServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Bind Interfaces → Concrete Implementations (Dependency Injection)
     */
    public function register(): void
    {
        // ── Repositories ─────────────────────────────────────────────
        $this->app->bind(            
            CustomerRepository::class
        );

        $this->app->bind(            
            SubscriptionRepository::class
        );

        // ── Services ─────────────────────────────────────────────────
        $this->app->bind(            
            CustomerService::class
        );

        $this->app->bind(            
            SubscriptionService::class
        );

        $this->app->bind(            
            SipProvisioningService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}