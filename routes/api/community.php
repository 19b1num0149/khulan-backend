<?php

use App\Http\Controllers\Api\Community\ContentController;
use App\Http\Controllers\Api\Community\CouponController;
use App\Http\Controllers\Api\Community\EventController;
use App\Http\Controllers\Api\Community\GroupController;
use App\Http\Controllers\Api\Community\MemberController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    //GroupController route
    Route::get('/', [GroupController::class, 'getGroups']);
    Route::get('/{group_id}', [GroupController::class, 'getGroup']);
    Route::get('/{group_id}/about', [GroupController::class, 'about']);
    Route::get('/{group_id}/card', [GroupController::class, 'getGroupCard']);
    Route::get('/{group_id}/contact', [GroupController::class, 'contact']);
    Route::post('/{group_id}/leave', [GroupController::class, 'leave']);

    //MemberController route
    Route::get('/{group_id}/members', [MemberController::class, 'getMembers']);

    //CouponController route
    Route::get('/{group_id}/coupons', [CouponController::class, 'getCoupons']);

    //ContentController route
    Route::get('/{group_id}/contents', [ContentController::class, 'getContents']);
    Route::get('/{group_id}/contents/{id}', [ContentController::class, 'getContent']);
    Route::post('/{group_id}/contents/{id}', [ContentController::class, 'earnPointFromContent']);

    //EventController route
    Route::get('/{group_id}/events', [EventController::class, 'getEvents']);
    Route::get('/{group_id}/events/{id}', [EventController::class, 'getEvent']);
    Route::post('/{group_id}/events/{id}', [EventController::class, 'postEvent']);
});
