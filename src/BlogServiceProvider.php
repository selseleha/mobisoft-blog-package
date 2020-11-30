<?php

namespace mobisoft\blog;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->publishes([
            __DIR__.'/migrations/' => App::databasePath('migrations')
        ], 'migrations');


        $this->loadViewsFrom(__DIR__ . '/views', 'blog');

        $this->publishes([
            __DIR__ . '/views' => App::resourcePath('views'),
        ], 'views');



        $this->loadRoutesFrom(__DIR__.'/routes/web.php');


    }

    public function register()
    {

    }
}
