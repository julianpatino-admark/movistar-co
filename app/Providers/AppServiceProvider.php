<?php

namespace App\Providers;

use Admark\Tracking\Http\Controllers\WebhookController;
use Admark\Tracking\Http\Requests\WebhookRequest;
use App\Http\Controllers\TrackingWebhookController;
use App\Http\Requests\TrackingWebhookRequest;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(WebhookController::class, TrackingWebhookController::class);
    }

}
