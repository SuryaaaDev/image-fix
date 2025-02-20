<?php

use App\Http\Controllers\Api\PostApiContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts', PostApiContoller::class);
// Route::post('/posts/create', [PostApiContoller::class, 'store']);