<?php

use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\TagApiController;

Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{slug}', [PostApiController::class, 'show']);
Route::get('/posts/featured', [PostApiController::class, 'featured']);
Route::get('/posts/{id}/related', [PostApiController::class, 'related']);

Route::get('/authors', [AuthorApiController::class, 'index']);
Route::get('/authors/{id}', [AuthorApiController::class, 'show']);

Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/categories/{id}', [CategoryApiController::class, 'show']);

Route::get('/tags', [TagApiController::class, 'index']);
Route::get('/tags/{id}', [TagApiController::class, 'show']);
