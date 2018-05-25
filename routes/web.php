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

Route::redirect('/create', '/', 301);

Route::get('/', 'TaskListController@index');
Route::post('/create', 'TaskListController@store');
Route::get('/lists/{list}', 'TaskListController@show');
Route::post('/lists/{list}/task', 'TaskController@store');
Route::post('/lists/{list}/state/', 'TaskController@state');
Route::delete('/lists/{list}/destroy', 'TaskController@destroy');
Route::get('/search', 'SearchController@index');
Route::post('/ajax/search', 'Ajax\SearchController@search');
Route::delete('/lists/{list}', 'TaskListController@destroy');