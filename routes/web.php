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

Route::get('/project/{id}/progress_plan/resource', 'ProgressPlansController@resource');
Route::post('/project/{id}/progress_plan/resource', 'ProgressPlansController@resourceStore');
Route::get('/project/{id}/progress_plan/task_charge', 'ProgressPlansController@task_charge');
Route::post('/project/{id}/progress_plan/task_charge', 'ProgressPlansController@task_chargeStore');
Route::get('/project/{id}/progress_plan/location', 'ProgressPlansController@location');
Route::post('/project/{id}/progress_plan/location', 'ProgressPlansController@locationStore');
Route::get('/project/{id}/progress_plan/work_schedule', 'ProgressPlansController@work_schedule');
Route::post('/project/{id}/progress_plan/work_schedule', 'ProgressPlansController@work_scheduleStore');
Route::get('/project/{id}/progress_plan/confirm', 'ProgressPlansController@confirm');
Route::post('/project/{id}/progress_plan/confirm', 'ProgressPlansController@confirmStore');
Route::get('/project/{id}/progress_plan/complete', 'ProgressPlansController@complete');


