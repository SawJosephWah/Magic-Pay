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

//user auth
Auth::routes();



//admin auth
Route::get('/admin/login','Auth\AdminLoginController@showLoginForm');

Route::post('/admin/login','Auth\AdminLoginController@login')->name('admin.login');

Route::post('/admin/logout','Auth\AdminLoginController@logout')->name('admin.logout');

//user
Route::group(['middleware'=>'auth','namespace'=>'FrontEnd'],function(){
    Route::get('/', 'HomeController@home')->name('home');

    Route::get('/profile', 'HomeController@profile')->name('profile');

    Route::get('/updatePassword','HomeController@updatePasswordPage')->name('updatePasswordPage');

    Route::post('/updatePassword','HomeController@updatePassword')->name('updatePassword');

    Route::get('/wallet','HomeController@wallet')->name('wallet');

    //transfer
    Route::get('/transfer','HomeController@transfer')->name('transfer');
    Route::get('/transfer_hash','HomeController@transferHash');
    Route::get('/check_to_phone','HomeController@checkToPhone');
    Route::get('/transfer/confirm','HomeController@transferConfirm')->name('transfer.confirm');
    Route::get('/transfer_password_check','HomeController@transferPasswordCheck');
    Route::post('/transfer','HomeController@transferFinal')->name('transfer');
    //transfer end

    Route::get('/transactions','HomeController@transactionList')->name('transactions_list');
    Route::get('/transaction_detials/{trx_id}','HomeController@transactionDetials')->name('transaction.details');

    Route::get('/scannerqr','HomeController@scannerQr')->name('scannerqr');

    Route::get('/scan&and&pay','HomeController@sanAndPay')->name('san_and_pay');
    Route::get('/scan&and&trnasfer','HomeController@sanAndTransfer');

    Route::get('/notifications','NotificationController@index')->name('notifications');
    Route::get('/notification&details/{id}','NotificationController@show')->name('notificationDetails');

});


