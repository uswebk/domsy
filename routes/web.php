<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::namespace('Auth')->group(function () {
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', 'RegisterController@index')->name('index');
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

        Route::get('domain', 'DomainController@index')->name('domain.index');
        Route::get('dns', 'DnsController@index')->name('dns.index');
        Route::get('registrar', 'RegistrarController@index')->name('registrar.index');
        Route::get('client', 'ClientController@index')->name('client.index');

        Route::prefix('dealing')->name('dealing.')->group(function () {
            Route::get('/', 'DealingController@index')->name('index');
            Route::get('new', 'DealingController@new')->name('new');
            Route::get('{domainDealing}/edit', 'DealingController@edit')->name('edit')->where('domainDealing', '[0-9]+');
            Route::get('{domainDealing}/detail', 'DealingController@detail')->name('detail')->where('domainDealing', '[0-9]+');

            Route::post('store', 'DealingController@store')->name('store');
            Route::post('{domainDealing}/update', 'DealingController@update')->name('update')->where('domainDealing', '[0-9]+');
        });

        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/', 'AccountController@index')->name('index');
        });
    });
});
