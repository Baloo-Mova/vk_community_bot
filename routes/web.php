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

Route::get('/social_login/{provider}', 'SocialController@login');
Route::get('/social_login/callback/{provider}', 'SocialController@callback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
