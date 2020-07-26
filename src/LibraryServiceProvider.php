<?php

namespace Sknmk\LibraryOperations;

use Illuminate\Support\ServiceProvider;
use Sknmk\LibraryOperations\Http\Controller\BookController;
use Sknmk\LibraryOperations\Http\Controller\ReaderController;
use Sknmk\LibraryOperations\Http\Controller\BookReaderController;

/**
 * Class LibraryServiceProvider
 * @package Sknmk\LibraryOperations
 */
class LibraryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/Router.php');
        $this->loadViewsFrom(__DIR__ . '/../view', 'library');
    }

    public function register()
    {
        $this->app->singleton(BookController::class, function () {
            return new BookController();
        });
        $this->app->singleton(ReaderController::class, function () {
            return new ReaderController();
        });
        $this->app->singleton(BookReaderController::class, function () {
            return new BookReaderController();
        });
    }
}
