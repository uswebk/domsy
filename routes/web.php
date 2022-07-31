<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::namespace('Auth')->group(function () {
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', 'RegisterController@index')->name('index');
    });

    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verify');
});

Route::namespace('Frontend')->group(function () {
    Route::get('/', 'TopController@index')->name('top.index');

    Route::middleware(['verified','auth'])->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::get('domains', 'DomainController@index')->name('domains.index');
        Route::get('dns', 'DnsController@index')->name('dns.index');
        Route::get('registrars', 'RegistrarController@index')->name('registrars.index');
        Route::get('clients', 'ClientController@index')->name('clients.index');
        Route::get('dealings', 'DealingController@index')->name('dealings.index');
        Route::get('accounts', 'AccountController@index')->name('accounts.index');
        Route::get('settings', 'SettingController@index')->name('settings.index');
    });
});
