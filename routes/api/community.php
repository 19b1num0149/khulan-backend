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
    Route::get('/{groupid}', [GroupController::class, 'getGroup']);
    Route::get('/{groupid}/about', [GroupController::class, 'about']);
    Route::get('/{groupid}/card', [GroupController::class, 'getGroupCard']);
    Route::get('/{groupid}/contact', [GroupController::class, 'contact']);
    Route::post('/{groupid}/leave', [GroupController::class, 'leave']);

    //MemberController route
    Route::get('/{groupid}/members', [MemberController::class, 'getMembers']);

    //CouponController route
    Route::get('/{groupid}/coupons', [CouponController::class, 'getCoupons']);

    //ContentController route
    Route::get('/{groupid}/contents', [ContentController::class, 'getContents']);
    Route::get('/{groupid}/contents/{id}', [ContentController::class, 'getContent']);
    Route::post('/{groupid}/contents/{id}', [ContentController::class, 'earnPointFromContent']);

    //EventController route
    Route::get('/{groupid}/events', [EventController::class, 'getEvents']);
    Route::get('/{groupid}/events/{id}', [EventController::class, 'getEvent']);
    Route::post('/{groupid}/events/{id}', [EventController::class, 'postEvent']);
});
