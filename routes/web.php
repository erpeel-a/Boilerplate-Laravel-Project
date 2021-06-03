<?php

use App\Http\Controllers\Admin\{
    PostController,
    CategoryController,
    ProfileController,
    UserController,
    RoleController
};
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
Route::get('/', function(){
    return view('auth.login');
});
Auth::routes(['register' => false]);
Route::group(['middleware' => 'auth'], function(){
    Route::view('/backup', 'laravel_backup_panel::layout')->middleware('isAdmin');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['prefix' => 'panel'], function(){
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::group(['prefix' => 'konten'], function(){
            Route::resource('categories', CategoryController::class);
            Route::resource('post', PostController::class);
            // trash and restore
            Route::get('post/action/trash', [PostController::class, 'getPostTrash'])->name('post.trash');
            Route::get('post/action/{id}/restore', [PostController::class, 'RestoreTrashedItem'])->name('post.restore');
            Route::get('post/action/restore-all-data', [PostController::class, 'RestoreAllTrashedItem'])->name('post.restore-all');
            Route::delete('post/action/delete-permanent', [PostController::class, 'DeletePermanentAllTrashedItem'])->name('post.delete-all-permanent');
            Route::delete('post/action/{id}/delete-permanent', [PostController::class, 'DeletePermanentTrashedItem'])->name('post.delete-permanent');
            
            Route::get('post/{id}/publish', [PostController::class, 'PublishPost'])->name('publish.post');
            Route::get('post/{id}/archive', [PostController::class, 'ArchivePost'])->name('archive.post');
            
        });
        Route::group(['prefix' => 'settings'], function(){
            //change user profile
            Route::get('change-profile/{id}', [ProfileController::class, 'profile'])->name('user-profile');
            Route::put('change-profile/{id}', [ProfileController::class, 'changeProfile'])->name('user-profile.update');
            //change password
            Route::get('change-password/{id}', [ProfileController::class, 'password'])->name('user-password');
            Route::put('change-password/{id}', [ProfileController::class, 'changePassword'])->name('user-password.update');
        });
    });
});