<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/book', [BookController::class, 'index']);
Route::post('/book', [BookController::class, 'store']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::post('/book/{id}', [BookController::class, 'update']);
Route::delete('/book/{id}', [BookController::class, 'destroy']);

Route::get('/book-categories', [CategoryController::class, 'index']);
Route::post('/book-categories', [CategoryController::class, 'store']);
Route::get('/book-categories/{id}', [CategoryController::class, 'show']);
Route::put('/book-categories/{id}', [CategoryController::class, 'update']);
Route::delete('/book-categories/{id}', [CategoryController::class, 'destroy']);

Route::patch('/book-categories/{id}/publish', [CategoryController::class, 'publish']);
Route::patch('/book-categories/{id}/unpublish', [CategoryController::class, 'unpublish']);
