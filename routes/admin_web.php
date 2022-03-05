<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::group(['prefix'=>'admin','namespace'=>'Backend','as'=>'admin.','middleware'=>'adminAuth'],function(){
    Route::get('/','PageController@home')->name('home');

    //admin users
    Route::resource('admin-user', 'AdminUserController');

    Route::get('/admin-user/datatable/ssd','AdminUserController@ssd');

    //users
    Route::resource('user', 'UserController');

    Route::get('/user/datatable/ssd','UserController@ssd');

    //wallet
    Route::get('/wallet','WalletController@index')->name('wallet.index');

    Route::get('/wallet/ssd','WalletController@ssd');

    Route::get('/wallet/addAmount','WalletController@addAmount')->name('wallet.addAmount');
    Route::post('/wallet/addAmount/store','WalletController@storeAmount')->name('wallet.addAmount.store');

    Route::get('/wallet/reduceAmount','WalletController@reduceAmount')->name('wallet.reduceAmount');

    Route::post('/wallet/reduceAmount','WalletController@reduceAmountReduce')->name('wallet.reduceAmount.reduce');

});

