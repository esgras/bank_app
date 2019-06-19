<?php

use Illuminate\Http\Request;


Route::get('/user', function() {
    return \App\User::find(1);
})->middleware('auth:api');

Route::prefix('v1')->group(function () {
    Route::group(['namespace' => 'Api', 'prefix' => 'cards', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'CardController@index');
        Route::post('/', 'CardController@store');
        Route::post('/add-money', 'CardController@addMoney');
        Route::post('/money-transfer', 'CardController@moneyTransfer');
        Route::post('/withdraw-money', 'CardController@withdrawMoney');
        Route::post('/check-pin', 'CardController@checkPin');
        Route::post('/change-pin-code', 'CardController@changePinCode');
    });
});