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

Route::get('index_clients', 'ClientsController@index_clients');
Route::get('add_clients', 'ClientsController@add_clients');
Route::post('clients/register', 'ClientsController@register');
Route::get('clients/edit/{id}', 'ClientsController@edit')->name('edit_client');
Route::put('clients/update/{id}', 'ClientsController@update')->name('update_client');
Route::get('clients/confirm/{id}', 'ClientsController@destroy_confirm')->name('confirm_client');
Route::delete('clients/destroy/{id}', 'ClientsController@destroy')->name('destroy_client');

Route::get('index_trades', 'TradesController@index_trades');
Route::get('/{id}/add_trades', 'TradesController@add_trades');
Route::post('trades/register/{id}', 'TradesController@register')->name('register_trade');
Route::put('trades/update/{id}', 'TradesController@update')->name('update_trade');
Route::get('trades/confirm/{id}', 'TradesController@destroy_confirm')->name('confirm_trade');
Route::delete('trades/destroy/{id}', 'TradesController@destroy')->name('destroy_trade');

Route::get('index_repayments', 'RepaymentsController@index_repayments');
Route::get('/{id}/add_repayments', 'RepaymentsController@add_repayments');
Route::post('repayments/register/{id}', 'RepaymentsController@register')->name('register_repayment');
Route::put('repayments/update/{id}', 'RepaymentsController@update')->name('update_repayment');
Route::get('repayments/confirm/{id}', 'RepaymentsController@destroy_confirm')->name('confirm_repayment');
Route::delete('repayments/destroy/{id}', 'RepaymentsController@destroy')->name('destroy_repayment');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
