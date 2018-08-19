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

Route::get('/', 'VoucherController@index');
Route::get('/offers', 'OfferController@index');
Route::post('/offers/store', 'OfferController@store');

Route::get('/recipients', 'RecipientController@index');
Route::get('/recipients/{id}/vouchers', 'RecipientController@vouchers');
Route::post('/recipients/store', 'RecipientController@store');

Route::post('/vouchers/redeem', 'VoucherController@redeem');
Route::post('/vouchers/generate', 'VoucherController@generate');

