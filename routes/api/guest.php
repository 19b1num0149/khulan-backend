<?php

use App\Http\Controllers\Client\LoginController;
// Controllers
use Illuminate\Support\Facades\Route;

// Routes
Route::post('/auth', [LoginController::class, 'authenticate']);
