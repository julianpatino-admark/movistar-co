<?php

namespace App\Providers;

use Admark\Tracking\Http\Requests\WebhookRequest;
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
    }

}
