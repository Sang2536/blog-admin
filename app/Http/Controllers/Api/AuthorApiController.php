<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
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

        $authorStats = [
            'authors' => $authors->count(),
            'posts' => $authors->sum(fn ($author) => $author->posts->count()),
            'post_views' => $authors->sum(fn ($author) => $author->posts->sum('views')),
        ];

        return AuthorResource::collection($authors)
            ->additional(['stats' => $authorStats]);
    }

    // GET /api/authors/{author}
    public function show($author)
    {
        $authorFirst = User::where('id', $author)
                ->orWhere('slug', $author)
                ->first();

        if (!$authorFirst) {
            return response()->json([
                'message' => 'Tác giả không tồn tại.'
            ], 404);
        }

        $authorStats = [
            'posts' => $authorFirst->posts->count(),
            'post_views' => $authorFirst->posts->sum('views'),
        ];

        return (new AuthorResource($authorFirst))
            ->additional(['stats' => $authorStats]);
    }
}
