<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\VideoController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\LikeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('backend.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';

// Admin User Management
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
Route::put('/profile/{id}', [AdminController::class, 'UpdateProfile'])->name('user.profile.update');
Route::get('/get-designations', [AdminController::class, 'getDesignations'])->name('get.designations');

Route::middleware(['auth'])->group(function () {

    // Permission Management
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:permission');
        Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:permission');
        Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:permission');
    });

    // Role Management
    Route::controller(RoleController::class)->group(function () {
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:permission');
        Route::post('/role', [RoleController::class, 'store'])->name('role.store');
        Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:permission');
        Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:permission');
    });

    // RolePermissionController Management
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index')->middleware('permission:permission');
        Route::get('role-permission/create', [RolePermissionController::class, 'create'])->name('role-permission.create')->middleware('permission:permission');
        Route::post('/role-permission/store', [RolePermissionController::class, 'store'])->name('role-permission.store');
        Route::get('role-permission/{id}/edit', [RolePermissionController::class, 'edit'])->name('backend.role-permission.edit')->middleware('permission:permission');
        Route::get('role-permission/create', [RolePermissionController::class, 'create'])->name('role-permission.create')->middleware('permission:permission');
        Route::post('role-permission', [RolePermissionController::class, 'store'])->name('backend.role-permission.store');
        Route::put('backend/role-permission/{id}', [RolePermissionController::class, 'update'])->name('backend.role.permission.update')->middleware('permission:permission');
    });

    // User Management
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/list', [UserController::class, 'list'])->name('user.list');
        Route::get('/admin/list', [UserController::class, 'index'])->name('user.index')->middleware('permission:permission');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:permission');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update')->middleware('permission:permission');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:permission');
        Route::get('/get-designations', [UserController::class, 'getDesignations'])->name('get.designations');
    });

    // Category Management
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create')->middleware('permission:permission');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit')->middleware('permission:permission');
        Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware('permission:permission');
        Route::delete('/category/{id}', [categoryController::class, 'destroy'])->name('category.destroy')->middleware('permission:permission');
    });

    // Video Management
    Route::controller(VideoController::class)->group(function () {
        Route::get('/videos', [VideoController::class, 'index'])->name('video.index');
        Route::get('/video/{id}/show', [VideoController::class, 'show'])->name('video.show');
        Route::get('/video/create', [VideoController::class, 'create'])->name('video.create')->middleware('permission:permission');
        Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit')->middleware('permission:permission');
        Route::post('/video', [VideoController::class, 'store'])->name('video.store');
        Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');
        Route::delete('video/{id}', [VideoController::class, 'destroy'])->name('video.destroy')->middleware('permission:permission');
        Route::post('/videos/{id}/track-view', [VideoController::class, 'trackView'])->name('video.trackView');
        Route::get('/recently-played', [VideoController::class, 'recentlyPlayed'])->name('videos.recent');
    });

    // Review Management
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

    // Like Management
    Route::controller(LikeController::class)->group(function () {
        Route::post('/video/{video}/like', [LikeController::class, 'toggleLike'])->name('video.like');
    });
});
