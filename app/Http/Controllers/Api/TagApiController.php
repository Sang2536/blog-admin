<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagApiController extends Controller
{
    // GET /api/tags
    public function index()
    {
        $tags = Tag::select('id', 'name', 'slug')->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
        ]);
    }

    // GET /api/tags/{id}
    public function show($id)
    {
        $tag = Tag::select('id', 'name', 'slug', 'created_at', 'updated_at')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tag,
        ]);
    }
}
