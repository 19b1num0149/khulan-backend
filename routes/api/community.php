<?php

use App\Http\Controllers\Api\Community\CommunityController;
use Illuminate\Support\Facades\Route;

Route::get('/events', [CommunityController::class, 'getEvent']);
//Route::get('/contents', [CommunityController::class, 'getContents']);
