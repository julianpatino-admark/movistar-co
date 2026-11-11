<?php

namespace Admark\Anubis;

use Illuminate\Support\ServiceProvider;
use Admark\Soap\Soap as Soap;

class AnubisServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishConfig();
    }

    public function register()
    {
        $this->registerConfig();
        $this->bindAnubis();
    }

    private function publishConfig(){

        $this->publishes([

            __DIR__.'/config/anubis.php' => config_path('anubis.php')

        ]);

    }

    private function registerConfig(){

        $this->mergeConfigFrom(__DIR__.'/config/anubis.php', 'anubis');

    }

    public function bindAnubis(){

        $this->app->bind(AnubisLead::class,function($app){

            return new AnubisLead();

        });

    }

}
