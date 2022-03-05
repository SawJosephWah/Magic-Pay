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



Route::group(['namespace'=>'Api'], function(){
    Route::post('/register','AuthController@register');
    Route::post('/login','AuthController@login');

     Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/profile','PageController@profile');

        Route::get('/logout','PageController@logout');

        Route::get('/transactions','PageController@transactions');
        Route::get('/transaction&detials/{id}','PageController@transactionDetails');

        Route::get('/notifications','PageController@notifications');
        Route::get('/notifications&detials/{id}','PageController@notificationDetails');

        Route::get('/verify_phone','PageController@verifyPhone');

        Route::get('/transfer/confirm','PageController@transferConfirm');
        Route::post('/transfer/final','PageController@transferFinal');

     });


});
