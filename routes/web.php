<?php

use Illuminate\Support\Facades\Route;

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
});
