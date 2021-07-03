<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('admin.layout');
});
Route::prefix('admin')->group(function () {
    Route::prefix('cate')->group(function () {
        Route::get('index', [
            'as' => 'admin.cate.index',
            'uses' => 'CategoryController@index',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('create', [
            'as' => 'admin.cate.create',
            'uses' => 'CategoryController@create',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('edit/{id}', [
            'as' => 'admin.cate.edit',
            'uses' => 'CategoryController@edit',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('store', [
            'as' => 'admin.cate.store',
            'uses' => 'CategoryController@store',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('update/{id}', [
            'as' => 'admin.cate.update',
            'uses' => 'CategoryController@update',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('destroy/{id}', [
            'as' => 'admin.cate.destroy',
            'uses' => 'CategoryController@destroy',
            // 'middleware' => 'can:edit_blog',   
        ]);
    });
    Route::prefix('permission')->group(function () {
        Route::get('index', [
            'as' => 'admin.permission.index',
            'uses' => 'PermissionController@index',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('create', [
            'as' => 'admin.permission.create',
            'uses' => 'PermissionController@create',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('edit/{id}', [
            'as' => 'admin.permission.edit',
            'uses' => 'PermissionController@edit',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('store', [
            'as' => 'admin.permission.store',
            'uses' => 'PermissionController@store',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('update/{id}', [
            'as' => 'admin.permission.update',
            'uses' => 'PermissionController@update',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('destroy/{id}', [
            'as' => 'admin.permission.destroy',
            'uses' => 'PermissionController@destroy',
            // 'middleware' => 'can:edit_blog',   
        ]);
    });
    Route::prefix('role')->group(function () {
        Route::get('index', [
            'as' => 'admin.role.index',
            'uses' => 'RoleController@index',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('create', [
            'as' => 'admin.role.create',
            'uses' => 'RoleController@create',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('edit/{id}', [
            'as' => 'admin.role.edit',
            'uses' => 'RoleController@edit',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('store', [
            'as' => 'admin.role.store',
            'uses' => 'RoleController@store',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('update/{id}', [
            'as' => 'admin.role.update',
            'uses' => 'RoleController@update',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('destroy/{id}', [
            'as' => 'admin.role.destroy',
            'uses' => 'RoleController@destroy',
            // 'middleware' => 'can:edit_blog',   
        ]);
       
    });
    Route::prefix('user')->group(function () {
        Route::get('index', [
            'as' => 'admin.user.index',
            'uses' => 'UserController@index',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('create', [
            'as' => 'admin.user.create',
            'uses' => 'UserController@create',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('edit/{id}', [
            'as' => 'admin.user.edit',
            'uses' => 'UserController@edit',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('store', [
            'as' => 'admin.user.store',
            'uses' => 'UserController@store',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::post('update/{id}', [
            'as' => 'admin.user.update',
            'uses' => 'UserController@update',
            // 'middleware' => 'can:edit_blog',   
        ]);
        Route::get('destroy/{id}', [
            'as' => 'admin.user.destroy',
            'uses' => 'UserController@destroy',
            // 'middleware' => 'can:edit_blog',   
        ]);
       
    });
});
