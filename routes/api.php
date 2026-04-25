<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EditAvatarController;
use App\Http\Controllers\EditPasswordController;
use Illuminate\Support\Facades\Route;

// Public API endpoints
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected API endpoints (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Posts API
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    Route::delete('/posts/image/{imageId}', [PostController::class, 'destroyImage']);
    
    // Profile API
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    
    // Avatar API
    Route::put('/avatar', [EditAvatarController::class, 'update']);
    
    // Password API
    Route::put('/password', [EditPasswordController::class, 'update']);
    
    // Admin API (only for admins)
    Route::get('/admin/users', [AuthController::class, 'index']);
    Route::put('/admin/users/{user}/role', [AuthController::class, 'updateRole']);
    Route::patch('/admin/users/{user}/block', [AuthController::class, 'blockUser']);
    Route::patch('/admin/users/{user}/unblock', [AuthController::class, 'unblockUser']);
});
