<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {

    Route::middleware(['userAuth'])->group(function () {
        Route::match(['get', 'post'], 'merchant/index', 'Aphly\LaravelChat\Controllers\Front\MerchantController@index');
        Route::match(['get', 'post'], 'merchant/center', 'Aphly\LaravelChat\Controllers\Front\MerchantController@center');
    });

});

Route::middleware(['web'])->group(function () {

    Route::prefix('chat_admin')->middleware(['managerAuth'])->group(function () {

        Route::middleware(['rbac'])->group(function () {
            Route::get('user/index', 'Aphly\LaravelChat\Controllers\Admin\UserController@index');
            Route::match(['get', 'post'],'user/{uuid}/edit', 'Aphly\LaravelChat\Controllers\Admin\UserController@edit')->where('uuid', '[0-9]+');

            $route_arr = [
                ['group','\GroupController'],
            ];

            foreach ($route_arr as $val){
                Route::get($val[0].'/index', 'Aphly\LaravelChat\Controllers\Admin'.$val[1].'@index');
                Route::get($val[0].'/form', 'Aphly\LaravelChat\Controllers\Admin'.$val[1].'@form');
                Route::post($val[0].'/save', 'Aphly\LaravelChat\Controllers\Admin'.$val[1].'@save');
                Route::post($val[0].'/del', 'Aphly\LaravelChat\Controllers\Admin'.$val[1].'@del');
            }



        });
    });

});
