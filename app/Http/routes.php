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

//Route::resource('photo', 'Admin\AdminController');


// admin routes
Route::group(['as' => 'admin.', 'middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'dashboard'], function () {
    Route::get('/', ['as' => 'root', 'uses' => 'AdminController@index']);

    // menu
    Route::get('/menus', ['as' => 'menu', 'uses' => 'AdminMenuController@index']);
    Route::get('/menus/create', ['as' => 'menu.create', 'uses' => 'AdminMenuController@create']);
    Route::post('/menus/create', ['as' => 'menu.store', 'uses' => 'AdminMenuController@store']);
    Route::get('/menus/{menu}/edit', ['as' => 'menu.edit', 'uses' => 'AdminMenuController@edit']);
    Route::put('/menus/{menu}/edit', ['as' => 'menu.update', 'uses' => 'AdminMenuController@update']);

    Route::put('/menus/publish', ['as' => 'menu.publish', 'uses' => 'AdminMenuController@publish']);
    Route::put('/menus/unpublish', ['as' => 'menu.unpublish', 'uses' => 'AdminMenuController@unpublish']);
    Route::delete('/menus/delete', ['as' => 'menu.delete', 'uses' => 'AdminMenuController@destroy']);
});

// Authentication routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
