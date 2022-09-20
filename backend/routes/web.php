<?php

Auth::routes(['verify' => true]);

// 検証用
Route::get('test', 'TestController@index')->name('test.index');
