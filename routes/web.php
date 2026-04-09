<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EditAvatarController;
use App\Http\Controllers\EditPasswordController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('home', ['user' => Auth::user()]);
    })->name('home');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/edit-avatar', [EditAvatarController::class, 'edit'])->name('avatar.edit');
    Route::post('/edit-avatar', [EditAvatarController::class, 'update'])->name('avatar.update');

    Route::get('/edit-password', [EditPasswordController::class, 'edit'])->name('password.edit');
    Route::post('/edit-password', [EditPasswordController::class, 'update'])->name('password.update');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/posts/images/{image}', [PostController::class, 'destroyImage'])->name('posts.image.destroy');

    Route::get('/admin/users', [AuthController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/role', [AuthController::class, 'updateRole'])->name('admin.users.role');
    Route::patch('/admin/users/{user}/block', [AuthController::class, 'blockUser'])->name('admin.users.block');
    Route::patch('/admin/users/{user}/unblock', [AuthController::class, 'unblockUser'])->name('admin.users.unblock');
});
