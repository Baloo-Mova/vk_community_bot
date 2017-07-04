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
Route::get('/social_login/callback/', 'SocialController@loginCallback');
Route::get('/balance/check-result/', ['uses' => 'BalanceController@checkResult', 'as' => 'balance.check.result']);
Route::get('/change-response-status/{response_id}/{status}', ["uses" => "GroupsController@changeResponseStatus", "as" => "change.response.status"]);


Route::group(['middleware' => ['vkAuth', 'auth']], function () {
    Route::get('/', "GroupsController@index")->name('groups.index');
    Route::group(['prefix' => 'group'], function () {
        Route::get('/add/{id}', 'GroupsController@addGroup')->name('group.add');
        Route::get('/callback/', 'GroupsController@addGroupCallback')->name('group.add.callback');
        Route::get('/response-script/{group_id}', 'GroupsController@responseScript')->name('groups.response');
        Route::post('/add/response-script', 'GroupsController@addResponseScript')->name('groups.add.response');
        Route::post('/edit/response-script', 'GroupsController@editResponseScript')->name('groups.edit.response');
        Route::get('/delete/response-script/{response}', 'GroupsController@deleteResponseScript')->name('groups.delete.response');
        Route::get('/update', 'GroupsController@updateUserGroups')->name('groups.update');
    });

    Route::group(['prefix' => 'balance'], function () {
        Route::get('/', ['uses' => 'BalanceController@index', 'as' => 'balance.index']);
        Route::post('/replenishment', ['uses' => 'BalanceController@replenishment', 'as' => 'balance.replenishment']);
        Route::get('/check-success/', ['uses' => 'BalanceController@checkSuccess', 'as' => 'balance.check.success']);
        Route::get('/check-fair/', ['uses' => 'BalanceController@checkFair', 'as' => 'balance.check.fair']);
    });
});

