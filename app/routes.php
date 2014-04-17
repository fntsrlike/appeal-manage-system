<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'AppealController@index');

Route::group(array('before' => 'guest_only'), function()
{
    Route::get('login', 'PortalController@login');
    Route::get('register', 'PortalController@register');
    Route::post('register', 'PortalController@register_proccess');
});


Route::get('logout', 'PortalController@logout');
Route::get('test', 'PortalController@test');

# API
Route::group(array('prefix' => 'v1/res/'), function()
{
    $API_only = array('only' => array('index', 'store', 'update', 'show', 'destory'));

    Route::get('user', 'PortalController@status');
    Route::resource('cases', 'API_CaseController', $API_only);
    Route::resource('replies', 'API_ReplyController', $API_only);
    Route::resource('managers', 'API_ManagerController', $API_only);
    Route::resource('action', 'API_ActionController', array('only' => array('index')));
});

