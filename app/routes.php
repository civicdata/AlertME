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

Route::get('', 'HomeController@showHome');

// Authentication
Route::get('login', 'AuthController@showLogin');
Route::post('login', 'AuthController@postLogin');
Route::get('logout', 'AuthController@getLogout');

// Secure Routes
Route::group(array('before' => 'auth'), function()
{
    Route::get('dashboard', 'DashboardController@showHome');

    Route::get('dashboard/datasources', 'DashboardController@showDataSources');
    Route::get('dashboard/datasources/sync', 'DashboardController@syncDataSources');

    Route::get('dashboard/categories', 'DashboardController@showCategories');

    Route::get('dashboard/settings', 'DashboardController@showSettings');
    Route::post('dashboard/settings', 'DashboardController@setSettings');
});


Route::get('/authtest', array('before' => 'auth.basic', function()
{
    return View::make('hello');
}));

// API v1
Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::resource('datasources', 'ApiDataSourceController');
    Route::resource('datasourceconfig', 'ApiDataSourceConfigController');
    Route::resource('categories', 'ApiCategoryController');
});
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('projectsgeojson', 'ApiProjectsGeojsonController', array('only' => array('index', 'show')));
});
