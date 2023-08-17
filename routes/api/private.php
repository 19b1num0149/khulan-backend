<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Guest\LoginController;

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [LoginController::class, 'logout']);
});
