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

Route::middleware(['verified','auth'])->group(function () {
    Route::namespace('Client')->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

        Route::prefix('domain')->name('domain.')->group(function () {
            Route::get('/', 'DomainController@index')->name('index');
            Route::get('new', 'DomainController@new')->name('new');
            Route::get('{domain}/edit', 'DomainController@edit')->name('edit')->where('domain', '[0-9]+');

            Route::post('store', 'DomainController@store')->name('store');
            Route::post('{domain}/update', 'DomainController@update')->name('update')->where('domain', '[0-9]+');
            Route::post('{domain}/delete', 'DomainController@delete')->name('delete')->where('domain', '[0-9]+');
        });

        Route::prefix('dns')->name('dns.')->group(function () {
            Route::get('/', 'DnsController@index')->name('index');
            Route::get('domain/{domain}/new', 'DnsController@new')->name('new')->where('domain', '[0-9]+');
            Route::get('{subdomain}/edit', 'DnsController@edit')->name('edit')->where('subdomain', '[0-9]+');

            Route::post('/store', 'DnsController@store')->name('store');
            Route::post('{subdomain}/update', 'DnsController@update')->name('update')->where('subdomain', '[0-9]+');
            Route::post('{subdomain}/delete', 'DnsController@delete')->name('delete')->where('subdomain', '[0-9]+');
        });

        Route::prefix('registrar')->name('registrar.')->group(function () {
            Route::get('/', 'RegistrarController@index')->name('index');
            Route::get('new', 'RegistrarController@new')->name('new');
            Route::get('{registrar}/edit', 'RegistrarController@edit')->name('edit')->where('registrar', '[0-9]+');

            Route::post('store', 'RegistrarController@store')->name('store');
            Route::post('{registrar}/update', 'RegistrarController@update')->name('update')->where('registrar', '[0-9]+');
            Route::post('{registrar}/delete', 'RegistrarController@delete')->name('delete')->where('registrar', '[0-9]+');
        });
    });
});
