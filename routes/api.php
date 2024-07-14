<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// tampilkan data
Route::get('/', function () { return 'Hello World'; });
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/event-registrations', [EventRegistrationController::class, 'index']);
Route::get('/event-registrations/{id}', [EventRegistrationController::class, 'show']);

// tambah data
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/events', [EventController::class, 'store']);

// update data
Route::put('/users/{id}', [UserController::class, 'update']);
Route::post('/edit-events/{id}', [EventController::class, 'update']);

// delete data
