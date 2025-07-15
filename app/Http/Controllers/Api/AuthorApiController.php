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
        $authors = User::where('is_author', true)
            ->where('is_active', true)
            ->get();

        return AuthorResource::collection($authors);
    }

    // GET /api/authors/{id}
    public function show($id)
    {
        $author = User::where('id', $id)->findOrFail($id);

        return new AuthorResource($author);
    }
}
