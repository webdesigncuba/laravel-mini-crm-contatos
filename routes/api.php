<?php

use App\Infrastructure\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


Route::apiResource('contacts', ContactController::class);
Route::post('/contacts/{id}/process-score', [ContactController::class, 'processScore']);
