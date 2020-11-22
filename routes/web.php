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
Route::get('clients/edit/{id}', 'ClientsController@edit')->name('edit');
Route::put('clients/update/{id}', 'ClientsController@update')->name('update');
Route::get('clients/confirm/{id}', 'ClientsController@destroy_confirm')->name('confirm');
Route::delete('clients/destroy/{id}', 'ClientsController@destroy')->name('destroy');

Route::get('index_trades', 'TradesController@index_trades');

Route::get('/{id}/add_trades', 'TradesController@add_trades');
Route::post('trades/register', 'TradesController@register');

Route::get('add_payments', 'PaymentsController@add_payments');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
