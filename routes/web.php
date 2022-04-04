<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Auth')->group(function () {
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', 'RegisterController@index')->name('index');

        Route::post('/', 'RegisterController@register')->name('register');
    });

    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verify');
});

Route::middleware('verified')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });
});
