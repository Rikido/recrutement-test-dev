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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/groups', 'GroupsController@index');


Route::prefix('projects')->group(function() {
    Route::get('/', 'ProjectsController@index');
    Route::get('create', 'ProjectsController@create');
    Route::post('create', 'ProjectsController@store');
    Route::get('confirm', 'ProjectsController@confirm');
    Route::post('confirm', 'ProjectsController@confirmStore');
    Route::get('complete', 'ProjectsController@complete');
    Route::get('{id}', 'ProjectsController@show');

});

Route::prefix('project/{id}/progress_plan')->group(function() {
    Route::get('resource', 'ProgressPlansController@resource');
    Route::post('resource', 'ProgressPlansController@resourceStore');
    Route::get('task_charge', 'ProgressPlansController@task_charge');
    Route::post('task_charge', 'ProgressPlansController@task_chargeStore');
    Route::get('location', 'ProgressPlansController@location');
    Route::post('location', 'ProgressPlansController@locationStore');
    Route::get('work_schedule', 'ProgressPlansController@work_schedule');
    Route::post('work_schedule', 'ProgressPlansController@work_scheduleStore');
    Route::get('confirm', 'ProgressPlansController@confirm');
    Route::post('confirm', 'ProgressPlansController@confirmStore');
    Route::get('complete', 'ProgressPlansController@complete');
});

Route::get('/project/{id}/task_charge/{task_charge_id}/create', 'TaskChargeCompletesController@create');
Route::post('/project/{id}/task_charge/{task_charge_id}/create', 'TaskChargeCompletesController@createStore');
Route::get('/project/{id}/task_charge/{task_charge_id}/complete', 'TaskChargeCompletesController@complete');
