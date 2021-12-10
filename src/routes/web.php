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

// Home
Route::get('/', 'HomeController@home')->name('homes.home');

// Article
Route::get('/articles/new', 'ArticleController@new')->name('articles.new');
Route::post('/articles/create', 'ArticleController@create')->name('articles.create');
Route::get('/articles/{article}', 'ArticleController@show')->name('articles.show');
