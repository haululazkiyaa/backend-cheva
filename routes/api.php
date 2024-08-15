<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\FavoriteEventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/', function () {
    return 'Hello World';
});

Route::get('/user', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');
Route::get('/event-registrations', [EventRegistrationController::class, 'index'])->middleware('auth:sanctum');
Route::get('/event-registrations/{id}', [EventRegistrationController::class, 'show'])->middleware('auth:sanctum');
Route::get('/favorites', [FavoriteEventController::class, 'index'])->middleware('auth:sanctum');

// POST
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/update-profile', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::post('/user-verification', [UserController::class, 'verification'])->middleware('auth:sanctum');
Route::post('/events', [EventController::class, 'store'])->middleware('auth:sanctum');
Route::post('/event-registrations', [EventRegistrationController::class, 'store'])->middleware('auth:sanctum');
Route::post('/favorites', [FavoriteEventController::class, 'store'])->middleware('auth:sanctum');

// DELETE
Route::delete('/favorites/{eventId}', [FavoriteEventController::class, 'destroy'])->middleware('auth:sanctum');
