<?php

use Illuminate\Support\Facades\Route;

/* Role Management */
Route::get('mypage', 'Controller@index')->name('mypage.index');
Route::get('dashboard', 'Controller@index')->name('dashboard.index');
Route::get('domain', 'Controller@index')->name('domain.index');
Route::get('dns', 'Controller@index')->name('dns.index');
Route::get('registrar', 'Controller@index')->name('registrar.index');
Route::get('client', 'Controller@index')->name('client.index');
Route::get('dealing', 'Controller@index')->name('dealing.index');
Route::get('account', 'Controller@index')->name('account.index');
Route::get('setting', 'Controller@index')->name('setting.index');
