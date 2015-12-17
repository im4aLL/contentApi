<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', function() {
    return redirect('dashboard');
}]);


// admin routes
Route::group(['as' => 'admin::', 'middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'dashboard'], function () {
    Route::get('/', ['as' => 'root', 'uses' => 'AdminController@index']);
    Route::get('/menus', ['as' => 'menus', 'uses' => 'AdminMenuController@index']);
});

// Authentication routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
