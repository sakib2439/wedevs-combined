<?php

use Illuminate\Support\Facades\Route;

/*Removing cache*/
Route::get('reboot', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    file_put_contents(storage_path('logs/laravel.log'),'');
    Artisan::call('key:generate');
    Artisan::call('config:cache');
    return '<center><h1>System Rebooted!</h1></center>';
});

/*Migrate from route*/
Route::get('migrate',function(){
    Artisan::call('migrate');
    return redirect('/');
});

/*Seed from route*/
Route::get('seed',function(){
    Artisan::call('db:seed');
    return redirect('/');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/','HomeController@index')->name('home');
	Route::get('/{any_path}','HomeController@index')->where('path','.*'); /*For any path*/
});
