<?php

namespace SerkanMertKaptan\LibraryOperations;

use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/router.php');
        $this->publishes([
            __DIR__ . '/../config/options.php' => config_path('options.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton(Library::class, function () {
            return new Library();
        });
    }
}
