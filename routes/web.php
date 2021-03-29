<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'ProjectsController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/groups', 'GroupsController@index');

Route::get('/projects', 'ProjectsController@index');
Route::get('/project/{id}', 'ProjectsController@show');

Route::get('/projects/create', 'ProjectsController@create');
Route::post('/projects/create', 'ProjectsController@createStore');

Route::get('/projects/confirm', 'ProjectsController@confirm');
Route::post('/projects/confirm', 'ProjectsController@confirmStore');

Route::get('/projects/done', 'ProjectsController@done');

Route::get('/project/{id}/progress_plan/resource_select', 'ProgressPlansController@resourceSelect');
Route::post('/project/{id}/progress_plan/task_charges', 'ProgressPlansController@taskCharges');
Route::post('/project/{id}/progress_plan/location_select', 'ProgressPlansController@locationSelect');
Route::post('/project/{id}/progress_plan/vehicle_select', 'ProgressPlansController@vehicleSelect');
// Route::get('/project/{id}/progress_plan/work_schedule', 'ProgressPlansController@workSchedule');
Route::any('/project/{id}/progress_plan/work_schedule', 'ProgressPlansController@workSchedule')->name('progress_plan.work_schedule');
Route::post('/project/{id}/progress_plan/confirm', 'ProgressPlansController@confirm');
Route::post('/project/{id}/progress_plan/store', 'ProgressPlansController@store');

Route::get('/project/{id}/task_charge/{task_charge_id}/create', 'TaskChargeCompleteController@create');
Route::post('/project/{id}/task_charge/{task_charge_id}/create', 'TaskChargeCompleteController@store');
Route::get('/project/task_charge/complete', 'TaskChargeCompleteController@complete');
