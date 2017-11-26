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
Route::get('/in-work-page', "HomeController@inWorkPage")->name('inwork');
Route::post('/vk-tells-us/{id}', ['uses' => 'VkListenerController@index', 'as' => 'vk.tells.us.post']);

Route::get('/vk-app-gate/', ['uses' => 'VkListenerController@appGate', 'as' => 'vk.app.listener']);
Route::get('/vk-app-subscribe/{to}', ['uses' => 'VkListenerController@subscribeApp', 'as' => 'vk.app.subscribe']);
Route::get('/vk-app-cancel/{to}', ['uses' => 'VkListenerController@cancelApp', 'as' => 'vk.app.cancel']);

Route::get('/actions-invoked-list', ['uses' => 'GroupTasksController@invokedList', 'as' => 'actionsInvoked']);

Route::group(['middleware' => ['vkAuth', 'auth']], function () {

    Route::get('/partnership', ['uses' => 'BalanceController@partnership', 'as' => 'partnership']);
    Route::post('/partnership', ['uses' => 'BalanceController@partnershipChange', 'as' => 'partnership.change']);

    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/rate-list', ['uses' => 'RateController@index', 'as' => 'rate.index']);
        Route::post('/rate-edit', ['uses' => 'RateController@update', 'as' => 'rate.edit']);
        Route::get('/rate-delete/{id}', ['uses'
        => 'RateController@delete', 'as' => 'rate.delete']);
        Route::post('/rate-add', ['uses' => 'RateController@add', 'as' => 'rate.add']);
    });
    Route::get('/', "GroupsController@index")->name('groups.index');
    Route::group(['prefix' => 'group'], function () {
        Route::get('/add/{id}', 'GroupsController@addGroup')->name('group.add');
        Route::get('/callback/', 'GroupsController@addGroupCallback')->name('group.add.callback');
        Route::get('/update', 'GroupsController@updateUserGroups')->name('groups.update');
        Route::get('/delete-permissions/{group_id}',
            'GroupsController@deleteGroupPermissions')->name('groups.delete.permissions');
    });
    Route::group(['prefix' => 'group-settings'], function () {
        Route::get('/{id}', 'GroupSettingsController@index')->name('groupSettings.index');
        Route::post('/new-subscription',
            'GroupSettingsController@newSubscription')->name('groupSettings.new.subscription');
    });
    Route::group(['prefix' => 'client-groups'], function () {
        Route::get('/{group_id}', 'ClientGroupsController@index')->name('clientGroups.index');
        Route::get('/{group_id}/download', 'ClientGroupsController@downloadList')->name('clientGroups.download');
        Route::post('/add-group', 'ClientGroupsController@addGroup')->name('clientGroups.add.group');
        Route::get('/group/{group_id}', 'ClientGroupsController@group')->name('clientGroups.group');
        Route::post('/edit-group', 'ClientGroupsController@editGroup')->name('clientGroups.edit.group');
        Route::get('/delete-group/{group_id}', 'ClientGroupsController@deleteGroup')->name('clientGroups.delete.group');
        Route::post('/add-users', 'ClientGroupsController@addUser')->name('clientGroups.add.user');
        Route::post('/mass-delete-users',
            'ClientGroupsController@massDeleteClientGroup')->name('clientGroups.mass.delete.users');
        Route::get('/delete-user/{user_id}', 'ClientGroupsController@deleteUser')->name('clientGroups.delete.user');

        Route::group(['prefix' => 'times'], function () {
            Route::get('/{id}')->name('client.group.times')->uses('ClientGroupTimes@index');
            Route::post('/add')->name('client.group.times.add')->uses('ClientGroupTimes@add');
            Route::post('/edit')->name('client.group.times.edit')->uses('ClientGroupTimes@edit');
            Route::get('/delete/{id}')->name('client.group.times.delete')->uses('ClientGroupTimes@delete');
        });
    });
    Route::group(['prefix' => 'group-tasks'], function () {
        Route::get('/{group_id}', 'GroupTasksController@index')->name('groupTasks.index');
        Route::post('/add', 'GroupTasksController@add')->name('groupTasks.add');
        Route::post('/edit', 'GroupTasksController@edit')->name('groupTasks.edit');
        Route::get('/delete/{response}', 'GroupTasksController@delete')->name('groupTasks.delete');

        Route::group(['prefix' => 'times'], function () {
            Route::get('/{id}')->name('group.task.times')->uses('GroupTasksTimeController@index');
            Route::post('/add')->name('group.task.times.add')->uses('GroupTasksTimeController@add');
            Route::post('/edit')->name('group.task.times.edit')->uses('GroupTasksTimeController@edit');
            Route::get('/delete/{id}')->name('group.task.times.delete')->uses('GroupTasksTimeController@delete');
        });
    });
    Route::group(['prefix' => 'mass-delivery'], function () {
        Route::get('/{group_id}', 'MassDeliveryController@index')->name('massDelivery.index');
        Route::post('/add', 'MassDeliveryController@add')->name('massDelivery.add');
        Route::get('/delete/{delivery_id}', 'MassDeliveryController@delete')->name('massDelivery.delete');
    });

    Route::group(['prefix' => 'balance'], function () {
        Route::get('/', ['uses' => 'BalanceController@index', 'as' => 'balance.index']);
        Route::post('/replenishment', ['uses' => 'BalanceController@replenishment', 'as' => 'balance.replenishment']);
        Route::get('/check-success/', ['uses' => 'BalanceController@checkSuccess', 'as' => 'balance.check.success']);
        Route::get('/check-fair/', ['uses' => 'BalanceController@checkFair', 'as' => 'balance.check.fair']);
    });

    Route::group(['prefix' => 'funnels'], function () {
        Route::get('/{group_id}', 'FunnelsController@index')->name('funnels.index');
        Route::post('/add', 'FunnelsController@add')->name('funnels.add');
        Route::post('/add-time', 'FunnelsController@addTime')->name('funnels.add.time');
        Route::get('/delete/{funnel_id}', 'FunnelsController@delete')->name('funnels.delete');
        Route::get('/delete-time/{time_id}', 'FunnelsController@deleteTime')->name('funnels.delete.time');
        Route::post('/edit', 'FunnelsController@edit')->name('funnels.edit');
        Route::post('/edit-time', 'FunnelsController@editTime')->name('funnels.edit.time');
        Route::get('/show/{funnel_id}', 'FunnelsController@show')->name('funnels.show');
    });

    Route::group(['prefix' => 'moderator'], function () {
        Route::get('/{group_id}', ['uses' => 'ModeratorController@index', 'as' => 'moderator.index']);
        Route::post('/moderator-settings', ['uses' => 'ModeratorController@settings', 'as' => 'moderator.settings']);
        Route::post('/scenario-list', ['uses' => 'ModeratorController@scenarioList', 'as' => 'moderator.scenarion.list']);
    });

});

