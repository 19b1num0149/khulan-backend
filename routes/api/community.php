<?php

use App\Http\Controllers\Api\Community\CommunityController;
use App\Http\Controllers\Api\Community\GroupController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [CommunityController::class, 'getEvent']);
    Route::get('/', [GroupController::class, 'getGroup']);
    
});
