<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
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
|login_manage
*/

Route::get('/', function () {
    return view('admin.layout');
});
Route::name('admin.')->prefix('admin/', )->group(function () {
    Route::name('categories.')->prefix('categories/')->group(function () {
        Route::get('',function(){
            return view("hello");
        });
        //Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update', [CategoryController::class, 'update'])->name('update');
        Route::get('delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
    });

    Route::name('products.')->prefix('products/')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update', [ProductController::class, 'update'])->name('update');
        Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('delete');
    });

    Route::name('images.')->prefix('images/')->group(function () {
        Route::get('', [ImageController::class, 'index'])->name('index');
        Route::get('create', [ImageController::class, 'create'])->name('create');
        Route::post('store', [ImageController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ImageController::class, 'edit'])->name('edit');
        Route::post('update', [ImageController::class, 'update'])->name('update');
        Route::get('delete/{id}', [ImageController::class, 'destroy'])->name('delete');
    });

    Route::name('branches.')->prefix('branches/')->group(function () {
        Route::get('', [BranchController::class, 'index'])->name('index');
        Route::get('create', [BranchController::class, 'create'])->name('create');
        Route::post('store', [BranchController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BranchController::class, 'edit'])->name('edit');
        Route::post('update', [BranchController::class, 'update'])->name('update');
        Route::get('delete/{id}', [BranchController::class, 'destroy'])->name('delete');
    });
    Route::prefix('permission')->group(function () {
        Route::get('index', 'PermissionController@index')->name('permission.index');
        Route::get('create', 'PermissionController@create')->name('permission.create');
        Route::get('edit/{id}', 'PermissionController@edit')->name('permission.edit');
        Route::get('destroy/{id}', 'PermissionController@destroy')->name('permission.destroy');
        Route::post('store', 'PermissionController@store')->name('permission.store');
        Route::post('update/{id}', 'PermissionController@update')->name('permission.update');
    });
    Route::prefix('role')->group(function () {
        Route::get('index', 'RoleController@index')->name('role.index');
        Route::get('create', 'RoleController@create')->name('role.create');
        Route::get('edit/{id}', 'RoleController@edit')->name('role.edit');
        Route::get('destroy/{id}', 'RoleController@destroy')->name('role.destroy');
        Route::post('store', 'RoleController@store')->name('role.store');
        Route::post('update/{id}', 'RoleController@update')->name('role.update');
    });
    Route::prefix('user')->group(function () {
        Route::get('index', 'UserController@index')->name('user.index');
        Route::get('ajax', 'UserController@ajax')->name('user.ajax');
        Route::get('create', 'UserController@create')->name('user.create');
        Route::get('edit', 'UserController@edit')->name('user.edit');
        Route::get('destroy', 'UserController@destroy')->name('user.destroy');
        Route::post('store', 'UserController@store')->name('user.store');
        Route::post('update/{id}', 'UserController@update')->name('user.update');
    });
});



Route::prefix('auth')->group(function () {
    Route::get('login', 'Authentication@login_get')->name('auth.login');
    Route::get('logout', 'Authentication@login_out')->name('auth.logout');
    Route::get('forgot', 'Authentication@forgot')->name('auth.forgot');
    Route::get('new_pass', 'Authentication@new_password')->name('auth.new_pass');
    Route::post('strore_pass', 'Authentication@strore_password')->name('auth.strore_pass');
    Route::post('confirm', 'email\SendMailControllers@sendemail')->name('auth.confirm');
    Route::post('login_post', 'Authentication@login_post')->name('authentication.login_post');
});
// HtmlMinifier xóa bỏ khoảng trắng trong html giúp tăng tốc laravel
