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

// ユーザー
Auth::routes();
// 案件情報
Route::get('/', 'ProjectsController@index');
Route::get('/project/create', 'ProjectsController@create');
Route::post('/project/create', 'ProjectsController@post');
Route::get('/project/comfirm', 'ProjectsController@comfirm');
Route::post('/project/comfirm', 'ProjectsController@register');
Route::get('/project/complete', 'ProjectsController@complete');
Route::get('/project/{project}', 'ProjectsController@show');
// グループ
Route::get('/group', 'GroupsController@index');
// 進行プラン
Route::get('/project/{project}/progress_plan/resource', 'ProgressPlansController@resource');
Route::post('/project/{project}/progress_plan/resource', 'ProgressPlansController@resource_post');
Route::get('/project/{project}/progress_plan/task_charge', 'ProgressPlansController@task_charge');
Route::post('/project/{project}/progress_plan/task_charge', 'ProgressPlansController@task_charge_post');
Route::get('/project/{project}/progress_plan/location', 'ProgressPlansController@location');

Route::get('/project/{project}/progress_plan/scheduled_date', 'ProgressPlansController@scheduled_date');
// 設計書PDFファイルのダウンロード
Route::get('/project/{project}/progress_plan/download', 'ProgressPlansController@download');
// ホーム
Route::get('/home', 'HomeController@index')->name('home');
