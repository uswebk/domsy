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
        Route::get('domain', 'DomainController@index')->name('domain.index');
        Route::get('dns', 'DnsController@index')->name('dns.index');
        Route::get('registrar', 'RegistrarController@index')->name('registrar.index');
        Route::get('client', 'ClientController@index')->name('client.index');
        Route::get('dealing', 'DealingController@index')->name('dealing.index');
        Route::get('account', 'AccountController@index')->name('account.index');
        Route::get('settings', 'SettingController@index')->name('settings.index');
    });
});
