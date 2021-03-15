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

Route::get('/projects/create', 'ProjectsController@create');
Route::post('/projects/create', 'ProjectsController@createStore');

Route::get('/projects/confirm', 'ProjectsController@confirm');
Route::post('/projects/confirm', 'ProjectsController@confirmStore');

Route::get('/projects/done', 'ProjectsController@done');