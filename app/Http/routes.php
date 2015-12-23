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

    // categories
    Route::get('/categories', ['as' => 'cat', 'uses' => 'AdminCategoryController@index']);
    Route::get('/categories/create', ['as' => 'cat.create', 'uses' => 'AdminCategoryController@create']);
    Route::post('/categories/create', ['as' => 'cat.store', 'uses' => 'AdminCategoryController@store']);
    Route::get('/categories/{cat}/edit', ['as' => 'cat.edit', 'uses' => 'AdminCategoryController@edit']);
    Route::put('/categories/{cat}/edit', ['as' => 'cat.update', 'uses' => 'AdminCategoryController@update']);
    Route::put('/categories/publish', ['as' => 'cat.publish', 'uses' => 'AdminCategoryController@publish']);
    Route::put('/categories/unpublish', ['as' => 'cat.unpublish', 'uses' => 'AdminCategoryController@unpublish']);
    Route::delete('/categories/delete', ['as' => 'cat.delete', 'uses' => 'AdminCategoryController@destroy']);

    // contents
    Route::get('/contents', ['as' => 'content', 'uses' => 'AdminContentController@index']);
    Route::get('/contents/create', ['as' => 'content.create', 'uses' => 'AdminContentController@create']);
    Route::post('/contents/create', ['as' => 'content.store', 'uses' => 'AdminContentController@store']);
    Route::get('/contents/{content}/edit', ['as' => 'content.edit', 'uses' => 'AdminContentController@edit']);
    Route::put('/contents/{content}/edit', ['as' => 'content.update', 'uses' => 'AdminContentController@update']);
    Route::put('/contents/publish', ['as' => 'content.publish', 'uses' => 'AdminContentController@publish']);
    Route::put('/contents/unpublish', ['as' => 'content.unpublish', 'uses' => 'AdminContentController@unpublish']);
    Route::delete('/contents/delete', ['as' => 'content.delete', 'uses' => 'AdminContentController@destroy']);
    Route::post('/contents/settings', ['as' => 'content.settings', 'uses' => 'AdminContentController@settings']);

    // pages
    Route::get('/pages', ['as' => 'page', 'uses' => 'AdminPageController@index']);
    Route::get('/pages/create', ['as' => 'page.create', 'uses' => 'AdminPageController@create']);
    Route::post('/pages/create', ['as' => 'page.store', 'uses' => 'AdminPageController@store']);
    Route::get('/pages/{page}/edit', ['as' => 'page.edit', 'uses' => 'AdminPageController@edit']);
    Route::put('/pages/{page}/edit', ['as' => 'page.update', 'uses' => 'AdminPageController@update']);
    Route::put('/pages/publish', ['as' => 'page.publish', 'uses' => 'AdminPageController@publish']);
    Route::put('/pages/unpublish', ['as' => 'page.unpublish', 'uses' => 'AdminPageController@unpublish']);
    Route::delete('/pages/delete', ['as' => 'page.delete', 'uses' => 'AdminPageController@destroy']);

});

// Authentication routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
