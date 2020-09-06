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

Route::post('/login', 'Api\AuthController@login');
Route::get('/login', 'Api\AuthController@login')->name('login');
Route::post('/register', 'Api\AuthController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user', 'Api\LoanController@getCurrentUser');
    Route::get('/getFrequency', 'Api\LoanController@getFrequency');
    Route::get('/getStatus', 'Api\LoanController@getStatus');
    Route::get('/getCurrency', 'CurrencyController@getCurrencyList');
    Route::get('/testconvert', 'CurrencyController@convertAmount');
    Route::post('/logout', 'Api\AuthController@logout');


    Route::post('/makePayment', 'Api\PaymentController@makePayment');
    Route::get('/getPayment/{loan}', 'Api\PaymentController@getPayment');
    Route::apiResource('/loan', 'Api\LoanController');
});

//// Auth Route
//Route::post('/register', 'Api\AuthController@register');
//Route::post('/login', 'Api\AuthController@login');
//Route::post('/logout', 'Api\AuthController@logout');
//
//// Loan Route
//Route::get('/loan','Api\LoanController@index');
//Route::post('/loan','Api\LoanController@store');
//Route::get('/loan/{loan}','Api\LoanController@show');
//Route::patch('/loan/{loan}','Api\LoanController@update');
//Route::delete('/loan/{loan}','Api\LoanController@destroy');
//Route::get('/user', 'Api\LoanController@getCurrentUser');
//Route::get('/getFrequency', 'Api\LoanController@getFrequency');
//Route::get('/getStatus', 'Api\LoanController@getStatus');
//Route::get('/getCurrency', 'CurrencyController@getCurrencyList');
//Route::get('/testconvert', 'CurrencyController@convertAmount');
