<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [PostController::class, 'index']);

Route::get('/create', [PostController::class, 'create']);
Route::post('/store', [PostController::class, 'store']);

Route::get('/edit/{id}', [PostController::class, 'edit']);
Route::put('/update/{id}', [PostController::class, 'update']);

Route::get('/show/{id}', [PostController::class, 'show']);
Route::delete('/delete/{id}', [PostController::class, 'destroy']);