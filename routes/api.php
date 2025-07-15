<?php

use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\TagApiController;

// GET Post
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{slug}', [PostApiController::class, 'show']);
Route::get('/posts/author/{name}', [PostApiController::class, 'getPostsByAuthor']);
Route::get('/posts/category/{slug}', [PostApiController::class, 'getPostsByCategory']);
Route::get('/posts/tag/{slug}', [PostApiController::class, 'getPostsByTag']);

// GET Author
Route::get('/authors', [AuthorApiController::class, 'index']);
Route::get('/authors/{id}', [AuthorApiController::class, 'show']);

// GET Category
Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/categories/{id}', [CategoryApiController::class, 'show']);

// GET Tag
Route::get('/tags', [TagApiController::class, 'index']);
Route::get('/tags/{id}', [TagApiController::class, 'show']);
