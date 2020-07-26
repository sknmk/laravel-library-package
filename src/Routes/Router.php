<?php

use Illuminate\Support\Facades\Route;
use Sknmk\LibraryOperations\Http\Controller\ReaderController;
use Sknmk\LibraryOperations\Http\Controller\BookController;
use Sknmk\LibraryOperations\Http\Controller\BookReaderController;

Route::group(['middleware' => 'web'], function () {
    Route::get('/reader/create', function () {
        return app(ReaderController::class)->form();
    });

    Route::post('/reader/create', 'Sknmk\LibraryOperations\Http\Controller\ReaderController@create')
        ->name('reader.createReader');

    Route::post('/reader/list', function () {
        return app(ReaderController::class)->list();
    })->name('reader.list');

    Route::post('/reader/list/withReader', function () {
        return app(ReaderController::class)->listWithReader();
    })->name('reader.listWithReader');

    Route::get('/book/create', function () {
        return app(BookController::class)->form();
    });

    Route::post('/book/create', 'Sknmk\LibraryOperations\Http\Controller\BookController@create')
        ->name('book.createBook');

    Route::get('/book/list', function () {
        return app(BookController::class)->listView();
    });

    Route::post('/book/list', 'Sknmk\LibraryOperations\Http\Controller\BookController@list')
        ->name('book.list');

    Route::post('/book/list/withReader', function () {
        return app(BookController::class)->listWithReader();
    })->name('book.listWithReader');

    Route::get('/book/detail/{id}', function () {
        return app(BookController::class)->detailView();
    });

    Route::post('/book/detail/{id}', function ($id) {
        return app(BookController::class)->detail($id);
    })->name('book.detail');

    Route::get('/book/assign', function () {
        return app(BookReaderController::class)->assignView();
    });

    Route::post('/book/assign', 'Sknmk\LibraryOperations\Http\Controller\BookReaderController@assign')
        ->name('book.assign');

    Route::get('/book/return', function () {
        return app(BookReaderController::class)->returnView();
    });

    Route::post('/book/return', 'Sknmk\LibraryOperations\Http\Controller\BookReaderController@return')
        ->name('book.return');
});
