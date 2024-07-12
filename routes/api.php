<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/', function () {return 'Hello World';});
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/event-registrations', [EventRegistrationController::class, 'index']);
Route::get('/event-registrations/{id}', [EventRegistrationController::class, 'show']);

// POST
Route::post('/events', [EventController::class, 'store']);