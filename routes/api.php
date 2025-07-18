<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\RecruitmentController;
use App\Http\Controllers\Api\TagApiController;

// GET Post By Search
Route::get('/search', [PostApiController::class, 'searchPosts']);

// GET Post
Route::prefix('posts')->group(function () {
    Route::get('/', [PostApiController::class, 'index']);
    Route::get('/{slug}', [PostApiController::class, 'show']);
    Route::get('/author/{slug}', [PostApiController::class, 'getPostsByAuthor']);
    Route::get('/category/{slug}', [PostApiController::class, 'getPostsByCategory']);
    Route::get('/tag/{slug}', [PostApiController::class, 'getPostsByTag']);
});

// GET Author
Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorApiController::class, 'index']);
    Route::get('/{author}', [AuthorApiController::class, 'show']);
});

// GET Category
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryApiController::class, 'index']);
    Route::get('/{category}', [CategoryApiController::class, 'show']);
});

// GET Tag
Route::prefix('tags')->group(function () {
    Route::get('/', [TagApiController::class, 'index']);
    Route::get('/{tag}', [TagApiController::class, 'show']);
});

//  GET Activity
Route::prefix('activities')->group(function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::get('/{activity}', [ActivityController::class, 'show']);
});

//  GET Recruitment
Route::prefix('recruitments')->group(function () {
    Route::get('/', [RecruitmentController::class, 'index']);
    Route::get('{recruitment}', [RecruitmentController::class, 'show']);
});
