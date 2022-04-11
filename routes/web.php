<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::namespace('Auth')->group(function () {
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', 'RegisterController@index')->name('index');

        Route::post('/', 'RegisterController@register')->name('register');
    });

    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verify');
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('verified')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::namespace('Client')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

            Route::prefix('domain')->name('domain.')->group(function () {
                Route::get('/', 'DomainController@index')->name('index');
                Route::get('/new', 'DomainController@new')->name('new');
                Route::get('/{domain}/edit', 'DomainController@edit')->name('edit')->where('domain', '[0-9]+');

                Route::post('/create', 'DomainController@store')->name('create');
                Route::post('/{domain}/update', 'DomainController@update')->name('update')->where('domain', '[0-9]+');
                Route::post('/{domain}/delete', 'DomainController@delete')->name('delete');
            });
        });
    });
});
