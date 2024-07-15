<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/', function () {return 'Hello World';});
Route::get('/user', [UserController::class, 'show'])->middleware('auth:sanctum'); 
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/event-registrations', [EventRegistrationController::class, 'index']);
Route::get('/event-registrations/{id}', [EventRegistrationController::class, 'show']);
Route::middleware('auth:sanctum')->get('profile', [AuthController::class, 'profile']);

// POST
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/update-profile', [UserController::class, 'update'])->middleware('auth:sanctum'); 
Route::post('/events', [EventController::class, 'store']);