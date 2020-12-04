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


Route::get('/', 'ProductionPlanOnChargeController@index')->name('production_plan_on_charge.index');

Route::group(['middleware' => 'auth'], function() {
  Route::resource('product_item', 'ProductItemController', ['except' => ['show']]);

  Route::resource('charge', 'ChargeController');

  Route::delete('charge_can_work/{product_item_id}/{charge_id}', 'ChargeCanWorkController@destroy')->name('charge_can_work.destroy');
  Route::resource('charge_can_work', 'ChargeCanWorkController', ['only' => ['store']]);

  Route::get('production_plan_on_charge/past_plan_act', 'ProductionPlanOnChargeController@past_plan_act')->name('production_plan_on_charge.past_plan_act');
  Route::get('production_plan_on_charge/create/{product_item_id}', 'ProductionPlanOnChargeController@create')->name('production_plan_on_charge.create');
  Route::get('production_plan_on_charge/edit/{product_item_id}/{charge_id}/{week}', 'ProductionPlanOnChargeController@edit')->name('production_plan_on_charge.edit');
  Route::resource('production_plan_on_charge', 'ProductionPlanOnChargeController', ['only' => ['index','store','update']]);

  Route::get('production_act_on_charge/create/{product_item_id}', 'ProductionActOnChargeController@create')->name('production_act_on_charge.create');
  Route::resource('production_act_on_charge', 'ProductionActOnChargeController', ['only' => ['index','store']]);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


