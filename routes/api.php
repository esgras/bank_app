<?php

use Illuminate\Http\Request;

Route::prefix('v1')->group(function () {
    Route::group(['namespace' => 'Api', 'prefix' => 'cards', 'middleware' => ['web', 'auth'] ], function () {
        Route::get('/', 'CardController@index');
        Route::post('/', 'CardController@store');
//        Route::put('/{id}', 'BookController@update');
//        Route::get('/{id}', 'BookController@show')->where('id', '\d+');
//        Route::delete('/{id}', 'BookController@destroy');
//        Route::get('/search/{query?}', 'BookController@search');
    });
});