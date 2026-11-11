<?php

namespace App\Providers;

use Admark\Tracking\Http\Requests\WebhookRequest;
use App\Http\Requests\TrackingWebhookRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use App\View\Components\PromoCards;
use App\View\Components\ResponsiveImage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WebhookRequest::class, TrackingWebhookRequest::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('promo-cards', PromoCards::class);
        Blade::component('responsive-image', ResponsiveImage::class);
    }
}
