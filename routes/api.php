<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/book', [BookController::class, 'index'])->middleware('auth:sanctum');
Route::post('/book', [BookController::class, 'store'])->middleware('auth:sanctum');
Route::get('/book/{id}', [BookController::class, 'show'])->middleware('auth:sanctum');
Route::post('/book/{id}', [BookController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/book/{id}', [BookController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/book-categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::post('/book-categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('/book-categories/{id}', [CategoryController::class, 'show'])->middleware('auth:sanctum');
Route::put('/book-categories/{id}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/book-categories/{id}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');

Route::patch('/book-categories/{id}/publish', [CategoryController::class, 'publish'])->middleware('auth:sanctum');
Route::patch('/book-categories/{id}/unpublish', [CategoryController::class, 'unpublish'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);