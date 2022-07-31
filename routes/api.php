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
        Route::get('menu-items', 'MenuController@getMenuItems');
        Route::get('dns-record-type', 'DnsRecordTypeController@getDnsRecordType');

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'RoleController@getRoles');
            Route::get('/user', 'RoleController@has');

            Route::post('/', 'RoleController@store')->name('store');
            Route::put('/{role}', 'RoleController@update')->name('update');
            Route::delete('/{role}', 'RoleController@delete')->name('delete');
        });

        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', 'UserController@getUsers');
        });

        Route::prefix('accounts')->name('account.')->group(function () {
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

        Route::prefix('clients')->name('client.')->group(function () {
            Route::get('/', 'ClientController@getClients');
            Route::post('/', 'ClientController@store')->name('store');
            Route::put('/{client}', 'ClientController@update')->where('client', '[0-9]+')->name('update');
            Route::delete('/{client}', 'ClientController@delete')->where('client', '[0-9]+')->name('delete');
        });

        Route::prefix('dealings')->name('dealing.')->group(function () {
            Route::get('/', 'DealingController@getDealings');
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
