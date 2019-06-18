<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create', 'BookController@create');
Route::get('/check', 'BookController@check');
Route::get('/add/{id}', 'BookController@add')->name('card_add');
Route::post('/add-handle/{id}', 'BookController@addHandle')->name('card_add_handle');
Route::get('/sub/{id}', 'BookController@sub')->name('card_sub');
Route::post('/sub-handle/{id}', 'BookController@subHandle')->name('card_sub_handle');
Route::get('/transfer', 'BookController@transfer')->name('card_transfer');
Route::post('/transfer-handle', 'BookController@transferHandle')->name('card_transfer_handle');
Route::get('/vue', 'BookController@vue');
Route::get('/history/{id}', 'BookController@history')->name('history');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
