<?php

namespace Admark\GoContact;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Support\Facades\Event;

class GoContactServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/gocontact.php', 'gocontact');

        if (!$this->app['config']->has('logging.channels.gocontact')) {
            $this->app['config']->set('logging.channels.gocontact', [
                'driver' => 'daily',
                'path' => storage_path('logs/gocontact.log'),
                'level' => env('GOCONTACT_LOG_LEVEL', 'info'),
                'days' => (int) env('GOCONTACT_LOG_DAYS', 30),
            ]);
        }

        $this->app->bind('gocontact.logger', function ($app) {
            return $app['log']->channel($app['config']->get('gocontact.log_channel', 'gocontact'));
        });

        $this->app->singleton(GoContact::class, function ($app) {
            return new GoContact(
                $app->make(HttpFactory::class),
                $app->make(CacheRepository::class),
                $app->make(ConfigRepository::class),
                $app->make('gocontact.logger'),
                $app->make(EventDispatcher::class)
            );
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'gocontact');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Event::listen(GoContactSubmissionAttempted::class, Listeners\StoreSubmissionAttempt::class);

        $this->publishes([
            __DIR__ . '/../config/gocontact.php' => config_path('gocontact.php'),
        ], 'gocontact-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/gocontact'),
        ], 'gocontact-views');
    }
}
