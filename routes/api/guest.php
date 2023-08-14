<?php

use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\Client\LoginController;

// Routes
Route::post('/auth', [LoginController::class, 'authenticate']);
