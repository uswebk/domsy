<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::namespace('Auth')->group(function () {
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', 'RegisterController@index')->name('index');

        Route::post('/', 'RegisterController@register')->name('register');
    });

    Route::namespace('Corporation')->prefix('corporation')->name('corporation.')
    ->group(function () {
        Route::get('register', 'RegisterController@index')->name('index');

        Route::post('register', 'RegisterController@register')->name('register');
    });

    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verify');
});

Route::namespace('Frontend')->group(function () {
    Route::get('/', 'TopController@index')->name('top.index');

    Route::middleware(['verified','auth'])->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'SettingController@index')->name('index');

            Route::post('mail', 'SettingController@saveMail')->name('mail.save');
            Route::post('general', 'SettingController@saveGeneral')->name('general.save');
        });

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

        Route::prefix('client')->name('client.')->group(function () {
            Route::get('/', 'ClientController@index')->name('index');
            Route::get('new', 'ClientController@new')->name('new');
            Route::get('{client}/edit', 'ClientController@edit')->name('edit')->where('client', '[0-9]+');

            Route::post('store', 'ClientController@store')->name('store');
            Route::post('{client}/update', 'ClientController@update')->name('update')->where('client', '[0-9]+');
            Route::post('{client}/delete', 'ClientController@delete')->name('delete')->where('client', '[0-9]+');
        });

        Route::prefix('dealing')->name('dealing.')->group(function () {
            Route::get('/', 'DealingController@index')->name('index');
            Route::get('new', 'DealingController@new')->name('new');
            Route::get('{domainDealing}/edit', 'DealingController@edit')->name('edit')->where('domainDealing', '[0-9]+');
            Route::get('{domainDealing}/detail', 'DealingController@detail')->name('detail')->where('domainDealing', '[0-9]+');

            Route::post('store', 'DealingController@store')->name('store');
            Route::post('{domainDealing}/update', 'DealingController@update')->name('update')->where('domainDealing', '[0-9]+');
        });
    });
});

// Front Test
Route::middleware(['verified','auth'])->group(function () {
    Route::namespace('Temporarily')->prefix('tmp')->name('tmp.')
    ->group(function () {
        Route::get('vue', 'VueTestController@index')->name('index');

        Route::get('api', 'VueTestController@api')->name('api');
    });
});
