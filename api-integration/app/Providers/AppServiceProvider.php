<?php

namespace App\Providers;

use App\Jobs\ProductIntegrationJob;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Http::macro("shopify", function () {
            return Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => config('shopify.access_token'),
            ])->baseUrl(config('shopify.base_url')."/admin/api/2024-01");
        });

        Queue::after(function (JobProcessed $event) {
            // If the processed job is an instance of ExecuteTask,
            // you can perform additional actions here if needed.
            if ($event->job->resolveName() === ProductIntegrationJob::class) {
                // Additional actions (optional)
            }
        });
    }
}
