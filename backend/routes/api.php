<?php

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
Route::namespace('Api')->name('api.')->group(function () {
    Route::get('me', 'MeController@fetch')->name('me.fetch');
});

Route::namespace('Auth')->group(function () {
    Route::get('verify/url/{id}/{hash}', 'VerificationController@url')->name('verify.url');
    Route::post('email/resend', 'VerificationController@resend');
    Route::post('register', 'RegisterController@register');
    Route::post('corporation/register', 'RegisterController@corporationRegister');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::middleware(['verified','auth:sanctum'])->group(function () {
    Route::namespace('Api')->name('api.')->group(function () {
        Route::get('menus', 'MenuController@fetch')->name('menus.fetch');
        Route::get('dns-record-type', 'DnsRecordTypeController@fetch')->name('dns-record-type.fetch');
        Route::get('menus/items', 'MenuController@fetchItems')->name('menus.items.fetch');

        Route::prefix('user')->name('user.')->group(function () {
            Route::get('', 'UserController@fetch');
        });

        Route::prefix('domain')->name('domain.')->group(function () {
            Route::get('', 'DomainController@fetch')->name('fetch');
            Route::get('total-seller', 'DomainController@fetchTotalSeller')->name('fetch.total-seller');
            Route::get('sort-expired', 'DomainController@fetchSortExpired')->name('fetch.sort-expired');
            Route::get('transaction', 'DomainController@fetchTransition')->name('fetch.transaction');
            Route::get('active-summary', 'DomainController@fetchActiveSummary')->name('fetch.active-summary');
            Route::post('', 'DomainController@store')->name('store');
            Route::put('{domain}', 'DomainController@update')->where('domain', '[0-9]+')->name('update');
            Route::delete('{domain}', 'DomainController@delete')->where('domain', '[0-9]+')->name('delete');
        });

        Route::prefix('dns')->name('dns.')->group(function () {
            Route::get('', 'DnsController@fetch')->name('fetch');
            Route::post('', 'DnsController@store')->name('store');
            Route::put('{subdomain}', 'DnsController@update')->where('subdomain', '[0-9]+')->name('update');
            Route::delete('{subdomain}', 'DnsController@delete')->where('subdomain', '[0-9]+')->name('delete');

            Route::post('apply', 'DnsController@apply')->name('apply');
        });

        Route::prefix('role')->name('role.')->group(function () {
            Route::get('', 'RoleController@fetch')->name('fetch');
            Route::get('has', 'RoleController@has')->name('has');
            Route::get('has/page', 'RoleController@hasPage')->name('has.page');

            Route::post('', 'RoleController@store')->name('store');
            Route::put('{role}', 'RoleController@update')->name('update');
            Route::delete('{role}', 'RoleController@delete')->name('delete');
        });

        Route::prefix('registrar')->name('registrar.')->group(function () {
            Route::get('', 'RegistrarController@fetch')->name('fetch');
            Route::post('', 'RegistrarController@store')->name('store');
            Route::put('{registrar}', 'RegistrarController@update')->where('registrar', '[0-9]+')->name('update');
            Route::delete('{registrar}', 'RegistrarController@delete')->where('registrar', '[0-9]+')->name('delete');
        });

        Route::prefix('client')->name('client.')->group(function () {
            Route::get('', 'ClientController@fetch')->name('fetch');
            Route::post('', 'ClientController@store')->name('store');
            Route::put('{client}', 'ClientController@update')->where('client', '[0-9]+')->name('update');
            Route::delete('{client}', 'ClientController@delete')->where('client', '[0-9]+')->name('delete');
        });

        Route::prefix('dealing')->name('dealing.')->group(function () {
            Route::get('', 'DealingController@fetch')->name('fetch');
            Route::post('', 'DealingController@store')->name('store');
            Route::get('{domainDealing}', 'DealingController@fetchId')->where('domainDealing', '[0-9]+')->name('fetch-id');
            Route::put('{domainDealing}', 'DealingController@update')->where('domainDealing', '[0-9]+')->name('update');
            Route::get('billings/transaction', 'DealingController@fetchBillingTransaction')->name('fetch.billings.transaction');
            Route::get('billings/sort-billing-date', 'DealingController@fetchBillingSortBillingDate')->name('fetch.billings.sort-billing-date');
            Route::get('detail', 'DealingController@detail')->where('domainDealing', '[0-9]+')->name('detail');
            Route::put('billing/{domainBilling}', 'DealingController@updateBilling')->where('domainBilling', '[0-9]+')->name('updateBilling');
        });

        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('user-mails', 'SettingController@getMails');
            Route::get('user-generals', 'SettingController@getGenerals');
            Route::put('user-mails', 'SettingController@saveMails');
            Route::put('user-generals', 'SettingController@saveGenerals');
        });

        Route::prefix('account')->name('account.')->group(function () {
            Route::post('', 'AccountController@store')->name('store');
            Route::put('{user}', 'AccountController@update')->where('user', '[0-9]+')->name('update');
            Route::delete('{user}', 'AccountController@delete')->where('user', '[0-9]+')->name('delete');
        });
    });
});
