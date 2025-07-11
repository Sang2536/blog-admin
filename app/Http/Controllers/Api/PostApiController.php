<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags', 'media'])
            ->where('status', 'published');

        // 🔍 Tìm kiếm từ khóa
        if ($request->filled('search')) {
            $keyword = $request->get('search');

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                    ->orWhere('excerpt', 'like', "%$keyword%")
                    ->orWhere('content', 'like', "%$keyword%")
                    ->orWhereHas('tags', fn($tagQ) => $tagQ->where('name', 'like', "%$keyword%"))
                    ->orWhereHas('category', fn($catQ) => $catQ->where('name', 'like', "%$keyword%"));
            });
        }

        // 🔎 Lọc theo category
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) =>
            $q->where('slug', $request->get('category'))
            );
        }

        // 🏷 Lọc theo tags
        if ($request->filled('tags')) {
            $tags = explode(',', $request->get('tags'));
            $query->whereHas('tags', fn ($q) =>
            $q->whereIn('slug', $tags)
            );
        }

        $posts = $query->orderByDesc('published_at')->paginate(10);

        return PostResource::collection($posts);
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'media', 'comments'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return new PostResource($post);
    }

    public function featured()
    {
        $posts = Post::with(['category', 'tags', 'user', 'media'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return PostResource::collection($posts);
    }

    public function related($id)
    {
        $post = Post::with('tags')->findOrFail($id);

        $related = Post::with(['category', 'tags', 'user', 'media'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $tagIds = $post->tags->pluck('id')->toArray();
                if (count($tagIds)) {
                    $query->whereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tags.id', $tagIds);
                    });
                }

                if ($post->category_id) {
                    $query->orWhere('category_id', $post->category_id);
                }
            })
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return PostResource::collection($related);
    }
}

