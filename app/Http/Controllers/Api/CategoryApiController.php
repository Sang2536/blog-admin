<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = Category::select('id', 'name', 'slug', 'parent_id')->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = Category::with('parent')
            ->select('id', 'name', 'slug', 'parent_id', 'created_at', 'updated_at')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'parent' => $category->parent ? [
                    'id' => $category->parent->id,
                    'name' => $category->parent->name,
                    'slug' => $category->parent->slug
                ] : null,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ],
        ]);
    }
}
