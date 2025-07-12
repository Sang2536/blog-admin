<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorApiController extends Controller
{
    // GET /api/authors
    public function index()
    {
        $authors = User::where('is_author', true)
            ->where('is_active', true)
            ->select('id', 'name', 'avatar', 'email')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $authors,
        ]);
    }

    // GET /api/authors/{id}
    public function show($id)
    {
        $author = User::where('is_author', true)
            ->where('is_active', true)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $author->id,
                'name' => $author->name,
                'avatar' => $author->avatar,
                'email' => $author->email,
                'created_at' => $author->created_at,
            ]
        ]);
    }
}
