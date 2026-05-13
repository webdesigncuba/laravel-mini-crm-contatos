<?php

use App\Infrastructure\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


Route::post('/contacts', [ContactController::class, 'store']);
