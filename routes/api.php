<?php

use App\Http\Controllers\{
    EventController, 
    AuthController, 
    UserController, 
    ResetPasswordController,
    ForgotPasswordController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello World';
});

Route::get('events', [EventController::class, 'index']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::put('users/{id}', [UserController::class, 'update']);