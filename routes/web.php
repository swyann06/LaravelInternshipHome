<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EditAvatarController;
use App\Http\Controllers\EditPasswordController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    
    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Avatar routes
    Route::get('/avatar/edit', [EditAvatarController::class, 'edit'])->name('avatar.edit');
    Route::put('/avatar', [EditAvatarController::class, 'update'])->name('avatar.update');
    
    // Password routes
    Route::get('/password/edit', [EditPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [EditPasswordController::class, 'update'])->name('password.update');
    
    // Post routes
    Route::resource('posts', PostController::class)->except(['show']);
    Route::delete('/posts/image/{imageId}', [PostController::class, 'destroyImage'])->name('posts.image.destroy');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AuthController::class, 'index'])->name('users');
        Route::put('/users/{user}/role', [AuthController::class, 'updateRole'])->name('users.update-role');
        Route::patch('/users/{user}/block', [AuthController::class, 'blockUser'])->name('users.block');
        Route::patch('/users/{user}/unblock', [AuthController::class, 'unblockUser'])->name('users.unblock');
    });
});