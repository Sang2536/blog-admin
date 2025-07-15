<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    //  GET /posts?type=...
    public function index(Request $request)
    {
        $type = $request->query('type');
        $limit = $request->query('limit', 6);

        switch ($type) {
            case 'featured':
                $posts = $this->getFeaturedPosts($limit);
                break;

            case 'newest':
                $posts = $this->getNewestPosts($limit);
                break;

            case 'oldest':
                $posts = $this->getOldestPosts($limit);
                break;

            case 'related':
                $postId = $request->query('post_id');
                $posts = $this->getRelatedPosts($postId, $limit);
                if ($posts === null) {
                    return response()->json(['message' => 'Post not found'], 404);
                }
                break;

            case 'search':
                $posts = $this->searchPosts($request, $limit);
                break;

            case 'popular':
                $posts = $this->getPopularPosts($limit);
                break;

            default:
                $posts = $this->getDefaultPosts();
                return PostResource::collection($posts);
        }

        return PostResource::collection($posts);
    }

    //  GET /posts/{slug}
    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'media', 'comments'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return new PostResource($post);
    }

    //  GET /posts/author/{name}
    public function getPostsByAuthor($name)
    {
        $limit = 10;

        $user = User::where('name', $name)->firstOrFail();

        $posts = $this->baseQuery()
            ->where('user_id', $user->id)
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();

        return PostResource::collection($posts);
    }

    //  GET /posts/category/{slug}
    public function getPostsByCategory($slug)
    {
        $limit = 10;

        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $this->baseQuery()
            ->where('category_id', $category->id)
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();

        return PostResource::collection($posts);
    }

    //  GET /posts/tag/{slug}
    public function getPostsByTag($slug)
    {
        $limit = 10;

        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $this->baseQuery()
            ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->where('post_tag.tag_id', $tag->id)
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();

        return PostResource::collection($posts);
    }

    private function baseQuery()
    {
        return Post::with(['user', 'category', 'tags', 'media'])
            ->where('status', 'published')
            ->whereNotNull('published_at');
    }

    private function getFeaturedPosts($limit)
    {
        return $this->baseQuery()
            ->where('is_featured', true)
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();
    }

    private function getNewestPosts($limit)
    {
        return $this->baseQuery()
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();
    }

    private function getOldestPosts($limit)
    {
        return $this->baseQuery()
            ->orderBy('published_at')
            ->take($limit)
            ->get();
    }

    private function getRelatedPosts($postId, $limit)
    {
        $currentPost = Post::with('tags')->find($postId);

        if (!$currentPost) {
            return null;
        }

        $tagIds = $currentPost->tags->pluck('id');

        return $this->baseQuery()
            ->where('id', '!=', $currentPost->id)
            ->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            })
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();
    }

    private function searchPosts($request, $limit)
    {
        $query = $this->baseQuery();

        // 🔍 Tìm kiếm từ khóa
        if ($request->filled('keyword')) {
            $keyword = $request->get('keyword');

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

        return $query->orderByDesc('published_at')
            ->take($limit)
            ->get();
    }

    private function getPopularPosts($limit)
    {
        return $this->baseQuery()
            ->orderByDesc('views')
            ->take($limit)
            ->get();
    }

    private function getDefaultPosts()
    {
        return $this->baseQuery()
            ->orderByDesc('published_at')
            ->paginate(10);
    }
}
