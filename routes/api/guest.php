<?php

use App\Http\Controllers\Api\Guest\LoginController;
use App\Http\Controllers\Api\Guest\RegisterController;
use App\Http\Controllers\Api\Guest\CheckTokenController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [LoginController::class, 'authenticate']);
Route::post('/register-by-email', [RegisterController::class, 'registerByEmail']);
Route::post('/register-by-facebook', [RegisterController::class, 'registerByFacebook']);
Route::post('/activate_account', [LoginController::class, 'activate_account']);
Route::get('/checktoken', CheckTokenController::class);