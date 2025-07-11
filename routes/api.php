<?php

use App\Http\Controllers\Api\PostApiController;

Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{slug}', [PostApiController::class, 'show']);
Route::get('/posts/featured', [PostApiController::class, 'featured']);
Route::get('/posts/{id}/related', [PostApiController::class, 'related']);
