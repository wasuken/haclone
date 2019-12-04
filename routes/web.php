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

Auth::routes();

Route::get('/', 'NewsController@index');
Route::get('/newsList', 'NewsController@index');
Route::get('/search', 'NewsController@search');
Route::get('/comments', 'NewsCommentController@index');
Route::get('/news', 'NewsController@show');
Route::post('/comment', 'NewsCommentController@store')->middleware('auth');
Route::get('/comment/reply', 'NewsCommentController@reply')->middleware('auth');
