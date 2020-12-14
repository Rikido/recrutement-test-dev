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

Route::get('/', 'ItemController@index')->name('item.index');

Route::group(['prefix' => 'contact', 'middleware' => 'auth'], function(){
    Route::get('item/create', 'ItemController@create')->name('item.create');
    Route::post('item/store', 'ItemController@store')->name('item.store');

    Route::get('purchase/index', 'PurchaseController@index')->name('purchase.index');
    Route::get('purchase/create/{id}', 'PurchaseController@create')->name('purchase.create');
    Route::post('purchase/store', 'PurchaseController@store')->name('purchase.store');

    Route::get('receipt/index', 'ReceiptController@index')->name('receipt.index');
    Route::get('receipt/create/{id}', 'ReceiptController@create')->name('receipt.create');
    Route::post('receipt/store', 'ReceiptController@store')->name('receipt.store');

    Route::get('allocate/index', 'AllocateController@index')->name('allocate.index');
    Route::get('allocate/create/{id}', 'AllocateController@create')->name('allocate.create');
    Route::post('allocate/store', 'AllocateController@store')->name('allocate.store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
