<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Community\CommunityController;

Route::get('/events', [CommunityController::class, 'getEvent']);
Route::get('/contents', [CommunityController::class, 'getContents']);

