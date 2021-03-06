<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;


Route::apiResource('/question', QuestionController::class);

Route::apiResource('/category', CategoryController::class);

Route::apiResource('/question/{question}/reply', ReplyController::class);

Route::post('/like/{reply}', [LikeController::class, 'LikeIt']);
Route::delete('/like/{reply}', [LikeController::class, 'UnlikeIt']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::post('/notifications', [NotificationController::class, 'index']);
Route::post('/markAsRead', [NotificationController::class, 'markAsRead']);