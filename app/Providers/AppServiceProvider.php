<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CrawlerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CrawlerService::class, function () {
            $endpoint = config('crawler.endpoint');

            return new CrawlerService($endpoint);
        });
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
