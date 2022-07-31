<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Auth')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('corporation/register', 'RegisterController@corporationRegister');
    Route::post('login', 'LoginController@login');
});


Route::middleware(['verified','auth'])->group(function () {
    Route::namespace('Api')->name('api.')->group(function () {
        Route::get('me', 'MeController@fetch')->name('me.fetch');
        Route::get('menus', 'MenuController@fetch')->name('menus.fetch');
        Route::get('menus/items', 'MenuController@fetchItems')->name('menus.items.fetch');
        Route::get('dns-record-type', 'DnsRecordTypeController@fetch')->name('dns-record-type.fetch');

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'RoleController@fetch')->name('fetch');
            Route::get('/user', 'RoleController@has')->name('has');

            Route::post('/', 'RoleController@store')->name('store');
            Route::put('/{role}', 'RoleController@update')->name('update');
            Route::delete('/{role}', 'RoleController@delete')->name('delete');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', 'UserController@fetch');
        });

        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::post('/', 'AccountController@store')->name('store');
            Route::put('/{user}', 'AccountController@update')->where('user', '[0-9]+')->name('update');
            Route::delete('/{user}', 'AccountController@delete')->where('user', '[0-9]+')->name('delete');
        });

        Route::prefix('domains')->name('domains.')->group(function () {
            Route::get('/', 'DomainController@fetch')->name('fetch');
            Route::post('/', 'DomainController@store')->name('store');
            Route::put('/{domain}', 'DomainController@update')->where('domain', '[0-9]+')->name('update');
            Route::delete('/{domain}', 'DomainController@delete')->where('domain', '[0-9]+')->name('delete');
        });

        Route::prefix('dns')->name('dns.')->group(function () {
            Route::get('/', 'DnsController@fetch')->name('fetch');
            Route::post('/', 'DnsController@store')->name('store');
            Route::put('/{subdomain}', 'DnsController@update')->where('subdomain', '[0-9]+')->name('update');
            Route::delete('/{subdomain}', 'DnsController@delete')->where('subdomain', '[0-9]+')->name('delete');
        });

        Route::prefix('registrars')->name('registrars.')->group(function () {
            Route::get('/', 'RegistrarController@fetch')->name('fetch');
            Route::post('/', 'RegistrarController@store')->name('store');
            Route::put('/{registrar}', 'RegistrarController@update')->where('registrar', '[0-9]+')->name('update');
            Route::delete('/{registrar}', 'RegistrarController@delete')->where('registrar', '[0-9]+')->name('delete');
        });

        Route::prefix('clients')->name('clients.')->group(function () {
            Route::get('/', 'ClientController@fetch')->name('fetch');
            Route::post('/', 'ClientController@store')->name('store');
            Route::put('/{client}', 'ClientController@update')->where('client', '[0-9]+')->name('update');
            Route::delete('/{client}', 'ClientController@delete')->where('client', '[0-9]+')->name('delete');
        });

        Route::prefix('dealings')->name('dealings.')->group(function () {
            Route::get('/', 'DealingController@fetch');
            Route::post('/', 'DealingController@store')->name('store');
            Route::put('/{domainDealing}', 'DealingController@update')->where('domainDealing', '[0-9]+')->name('update');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/user-mails', 'SettingController@getMails');
            Route::get('/user-generals', 'SettingController@getGenerals');
            Route::put('/user-mails', 'SettingController@saveMails');
            Route::put('/user-generals', 'SettingController@saveGenerals');
        });
    });
});
