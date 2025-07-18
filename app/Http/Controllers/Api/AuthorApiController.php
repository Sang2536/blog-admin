<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

class AuthorApiController extends Controller
{
    // GET /api/authors
    public function index()
    {
        $authors = User::with('posts')
            ->withCount('posts')
            ->where('is_author', true)
            ->orderByDesc('posts_count')
            ->get();

        return AuthorResource::collection($authors);
    }

    // GET /api/authors/{id}
    public function show(User $author)
    {
        if (!$author) {
            return response()->json([
                'message' => 'Tác giả không tồn tại.'
            ], 404);
        }

        return new AuthorResource($author);
    }
}
