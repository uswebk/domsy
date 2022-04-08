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
                Route::get('/{domain}/edit', 'DomainController@edit')->name('edit')->where('domain', '[0-9]+');
            });
        });
    });
});
