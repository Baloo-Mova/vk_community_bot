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
Route::get('/change-response-status/{response_id}/{status}',
    ["uses" => "GroupsController@changeResponseStatus", "as" => "change.response.status"]);
Route::get('/change-group-bot-status/{group_id}/{status}',
    ["uses" => "GroupsController@changeGroupBotStatus", "as" => "change.group.bot.status"]);
Route::get('/vk-tells-us/{id}', ['uses' => 'VkListenerController@index', 'as' => 'vk.tells.us']);

Route::group(['middleware' => ['vkAuth', 'auth']], function () {
    Route::get('/', "GroupsController@index")->name('groups.index');
    Route::group(['prefix' => 'group'], function () {
        Route::get('/add/{id}', 'GroupsController@addGroup')->name('group.add');
        Route::get('/callback/', 'GroupsController@addGroupCallback')->name('group.add.callback');
        Route::get('/response-script/{group_id}', 'GroupsController@responseScript')->name('groups.response');
        Route::post('/add/response-script', 'GroupsController@addResponseScript')->name('groups.add.response');
        Route::post('/edit/response-script', 'GroupsController@editResponseScript')->name('groups.edit.response');
        Route::get('/delete/response-script/{response}',
            'GroupsController@deleteResponseScript')->name('groups.delete.response');
        Route::get('/update', 'GroupsController@updateUserGroups')->name('groups.update');
        Route::get('/bot-settings/{group_id}', 'GroupsController@groupSettings')->name('groups.groupSettings');
        Route::get('/new-subscription', 'GroupsController@newSubscription')->name('groups.new.subscription');
        Route::get('/client-group/{group_id}', 'GroupsController@clientGroup')->name('groups.clientGroup');
        Route::get('/client-group-user/{group_id}',
            'GroupsController@clientGroupsUsers')->name('groups.clientGroupsUsers');
        Route::post('/add/client-group', 'GroupsController@addClientGroup')->name('groups.add.client.group');
        Route::post('/edit/client-group', 'GroupsController@editClientGroup')->name('groups.edit.client.group');
        Route::get('/delete/client-group/{group_id}',
            'GroupsController@deleteClientGroup')->name('groups.delete.client.group');
        Route::post('/mass-delete/client-group',
            'GroupsController@massDeleteClientGroup')->name('groups.mass.delete.client.group');
        Route::post('/add/client-group-user',
            'GroupsController@addClientGroupUser')->name('groups.add.client.group.user');
        Route::get('/delete/client-group-user/{user_id}',
            'GroupsController@deleteClientGroupUser')->name('groups.delete.client.group.user');
        Route::get('/mass-delivery/{group_id}', 'GroupsController@massDelivery')->name('groups.massDelivery');
        Route::post('/add/mass-delivery', 'GroupsController@addMassDelivery')->name('groups.add.massDelivery');
        Route::get('/delete/mass-delivery/{delivery_id}',
            'GroupsController@deleteMassDelivery')->name('groups.delete.massDelivery');
    });

    Route::group(['prefix' => 'balance'], function () {
        Route::get('/', ['uses' => 'BalanceController@index', 'as' => 'balance.index']);
        Route::post('/replenishment', ['uses' => 'BalanceController@replenishment', 'as' => 'balance.replenishment']);
        Route::get('/check-success/', ['uses' => 'BalanceController@checkSuccess', 'as' => 'balance.check.success']);
        Route::get('/check-fair/', ['uses' => 'BalanceController@checkFair', 'as' => 'balance.check.fair']);
    });
});

