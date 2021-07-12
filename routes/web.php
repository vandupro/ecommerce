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
// HtmlMinifier xóa bỏ khoảng trắng trong html giúp tăng tốc laravel
Route::prefix('admin',['middleware'=>'HtmlMinifier'])->group(function () {
    Route::prefix('permission')->group(function () {
      Route::get('index', 'PermissionController@index')->name('admin.permission.index');
      Route::get('create', 'PermissionController@create')->name('admin.permission.create');
      Route::get('edit/{id}', 'PermissionController@edit')->name('admin.permission.edit');
      Route::get('destroy/{id}', 'PermissionController@destroy')->name('admin.permission.destroy');
      Route::post('store', 'PermissionController@store')->name('admin.permission.store');
      Route::post('update/{id}', 'PermissionController@update')->name('admin.permission.update');
   
    
    });
    Route::prefix('role')->group(function () {
        Route::get('index', 'RoleController@index')->name('admin.role.index');
      Route::get('create', 'RoleController@create')->name('admin.role.create');
      Route::get('edit/{id}', 'RoleController@edit')->name('admin.role.edit');
      Route::get('destroy/{id}', 'RoleController@destroy')->name('admin.role.destroy');
      Route::post('store', 'RoleController@store')->name('admin.role.store');
      Route::post('update/{id}', 'RoleController@update')->name('admin.role.update');
       
    });
    Route::prefix('user')->group(function () {
        Route::get('index', 'UserController@index')->name('admin.user.index');
        Route::get('ajax', 'UserController@ajax')->name('admin.user.ajax');
        Route::get('create', 'UserController@create')->name('admin.user.create');
        Route::get('edit', 'UserController@edit')->name('admin.user.edit');
        Route::get('destroy', 'UserController@destroy')->name('admin.user.destroy');
        Route::post('store', 'UserController@store')->name('admin.user.store');
        Route::post('update/{id}', 'UserController@update')->name('admin.user.update');  
    });
});
