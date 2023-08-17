<?php

use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\Api\Guest\LoginController;

// Routes

Route::post('/auth', [LoginController::class, 'authenticate']);
Route::post('/register-by-email', [LoginController::class, 'registerByEmail']);
Route::post('/activate_account', [LoginController::class, 'activate_account']);


Route::post('/logout', [LoginController::class, 'logout']);
