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
    Route::get('{project}', 'ProjectsController@show');
    Route::get('confirm', 'ProjectsController@confirm');
    Route::get('complete', 'ProjectsController@create');
});
