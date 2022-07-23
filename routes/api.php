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
    Route::post('login', 'LoginController@login');
});


Route::middleware(['verified','auth'])->group(function () {
    Route::namespace('Api')->name('api.')->group(function () {
        Route::get('menus', 'MenuController@getMenus');
        Route::get('roles', 'RoleController@getRoles');

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@getUsers');
            Route::put('/{user}', 'UserController@update')->where('user', '[0-9]+');
            ;
        });

        Route::prefix('registrars')->name('registrar.')->group(function () {
            Route::get('/', 'RegistrarController@getRegistrars');

            Route::post('/', 'RegistrarController@store')->name('store');
            ;
        });

        Route::get('me', 'MeController@get');
    });
});
