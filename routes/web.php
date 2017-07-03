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

Route::get('/login', "HomeController@login")->name('login');
Route::post('/logout', "HomeController@logout")->name('logout');
Route::get('/social_login/', 'SocialController@login')->name('vk_login');
Route::get('/social_login/callback/', 'SocialController@callback');

Route::group(['middleware' => ['vkAuth', 'auth']], function () {
    Route::get('/', "GroupsController@index")->name('groups.index');
});

Route::group(['prefix' => 'balance', 'middleware' => ['vkAuth', 'auth']], function () {
    Route::get('/', ['uses'=>'BalanceController@index', 'as'=>'balance.index']);
    Route::post('/replenishment', ['uses'=>'BalanceController@replenishment', 'as'=>'balance.replenishment']);
    Route::get('/check-result/', ['uses'=>'BalanceController@checkResult', 'as'=>'balance.check.result']);
    Route::get('/check-success/', ['uses'=>'BalanceController@checkSuccess', 'as'=>'balance.check.success']);
    Route::get('/check-fair/', ['uses'=>'BalanceController@checkFair', 'as'=>'balance.check.fair']);
});