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
    Route::get('user', 'PortalController@status');
    Route::resource('forms', 'API_CaseController');
});