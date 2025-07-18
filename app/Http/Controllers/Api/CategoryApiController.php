<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryApiController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    // GET /api/categories/{id}
    public function show(Category $category)
    {
        $category->load('parent');

        return new CategoryResource($category);
    }
}
