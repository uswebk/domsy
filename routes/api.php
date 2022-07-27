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
        Route::get('me', 'MeController@get');
        Route::get('menus', 'MenuController@getMenus');
        Route::get('roles', 'RoleController@getRoles');
        Route::get('dns-record-type', 'DnsRecordTypeController@getDnsRecordType');

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@getUsers');
            Route::put('/{user}', 'UserController@update')->where('user', '[0-9]+');
        });

        Route::prefix('domains')->name('domain.')->group(function () {
            Route::get('/', 'DomainController@getDomains');
            Route::put('/{domain}', 'DomainController@update')->where('domain', '[0-9]+')->name('update');
            Route::post('/', 'DomainController@store')->name('store');
            Route::delete('/{domain}', 'DomainController@delete')->where('domain', '[0-9]+')->name('delete');
        });

        Route::prefix('dns')->name('dns.')->group(function () {
            Route::get('/', 'DnsController@getSubdomains');
            Route::put('/{subdomain}', 'DnsController@update')->where('subdomain', '[0-9]+')->name('update');
            Route::post('/', 'DnsController@store')->name('store');
            Route::delete('/{subdomain}', 'DnsController@delete')->where('subdomain', '[0-9]+')->name('delete');
        });

        Route::prefix('registrars')->name('registrar.')->group(function () {
            Route::get('/', 'RegistrarController@getRegistrars');
            Route::put('/{registrar}', 'RegistrarController@update')->where('registrar', '[0-9]+')->name('update');
            Route::post('/', 'RegistrarController@store')->name('store');
            Route::delete('/{registrar}', 'RegistrarController@delete')->where('registrar', '[0-9]+')->name('delete');
        });

        Route::prefix('clients')->name('client.')->group(function () {
            Route::get('/', 'ClientController@getClients');
            Route::put('/{client}', 'ClientController@update')->where('client', '[0-9]+')->name('update');
            Route::post('/', 'ClientController@store')->name('store');
            Route::delete('/{client}', 'ClientController@delete')->where('client', '[0-9]+')->name('delete');
        });

        Route::prefix('dealings')->name('dealing.')->group(function () {
            Route::get('/', 'DealingController@getDealings');
            Route::put('/{domainDealing}', 'DealingController@update')->where('domainDealing', '[0-9]+')->name('update');
            Route::post('/', 'DealingController@store')->name('store');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/user-mails', 'SettingController@getMails');
            Route::get('/user-generals', 'SettingController@getGenerals');
            Route::put('/user-mails', 'SettingController@saveMails');
            Route::put('/user-generals', 'SettingController@saveGenerals');
        });
    });
});
