<?php

use App\Http\Controllers\Client\LoginController;
// Controllers
use Illuminate\Support\Facades\Route;

// Routes

Route::post('/auth', [LoginController::class, 'authenticate']);
Route::post('/register-by-email', [LoginController::class, 'registerByEmail']);
Route::post('/activate_account', [LoginController::class, 'activate_account']);


Route::post('/logout', [LoginController::class, 'logout']);
