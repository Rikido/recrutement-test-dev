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

// Route::get('/', function () {
//     return view('welcome');
// });

// user系
Auth::routes();

Route::get('/', 'ProjectsController@index');
Route::get('/project/create', 'ProjectsController@create');
Route::post('/project/create', 'ProjectsController@post');
Route::get('/project/comfirm', 'ProjectsController@comfirm');
Route::post('/project/comfirm', 'ProjectsController@register');
Route::get('/project/complete', 'ProjectsController@complete');
Route::get('/project/{project}', 'ProjectsController@show');

Route::get('/group', 'GroupsController@index');

Route::get('/home', 'HomeController@index')->name('home');
