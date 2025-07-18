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

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        switch ($type) {
            case 'featured':
                $posts = $this->getFeaturedPosts($limit, $offset);
                break;

            case 'newest':
                $posts = $this->getNewestPosts($limit, $offset);
                break;

            case 'oldest':
                $posts = $this->getOldestPosts($limit, $offset);
                break;

            case 'related':
                $postId = $request->query('post_id');
                $posts = $this->getRelatedPosts($postId, $limit, $offset);
                if ($posts === null) {
                    return response()->json(['message' => 'Post not found'], 404);
                }
                break;

            case 'search':
                $posts = $this->searchPosts($request, $limit, $offset);
                break;

            case 'popular':
                $posts = $this->getPopularPosts($limit, $offset);
                break;

            default:
                $posts = $this->getDefaultPosts();

                $countPosts = $posts->count();

                $meta = $this->addMeta($countPosts, $limit, $page);

                return PostResource::collection($posts)
                    ->additional(['meta' => $meta]);
        }

        // Tổng số bài viết
        $countPosts = $posts->count();

        $meta = $this->addMeta($countPosts, $limit, $page);

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta]);
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
    public function getPostsByAuthor(Request $request, $slug)
    {
        $author = User::where('slug', $slug)->first();

        if (!$author) {
            return response()->json([
                'message' => 'Tác giả không tồn tại.'
            ], 404);
        }

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Tổng số bài viết
        $countPosts = Post::where('user_id', $author->id)->count();

        $posts = $this->baseQuery()
            ->where('user_id', $author->id)
            ->orderByDesc('published_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Tạo meta
        $meta = $this->addMeta($countPosts, $limit, $page);

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta]);
    }

    //  GET /posts/category/{slug}
    public function getPostsByCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Danh mục không tồn tại.'
            ], 404);
        }

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Tổng số bài viết
        $countPosts = Post::where('category_id', $category->id)->count();

        // Lấy danh sách bài viết theo phân trang
        $posts = $this->baseQuery()
            ->where('category_id', $category->id)
            ->orderByDesc('published_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Tạo meta
        $meta = $this->addMeta($countPosts, $limit, $page);

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta]);
    }

    //  GET /posts/tag/{slug}
    public function getPostsByTag(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            return response()->json([
                'message' => 'Thẻ không tồn tại.'
            ], 404);
        }

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Tổng số bài viết
        $countPosts = Post::join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->where('post_tag.tag_id', $tag->id)->count();

        $posts = $this->baseQuery()
            ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->where('post_tag.tag_id', $tag->id)
            ->orderByDesc('published_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Tạo meta
        $meta = $this->addMeta($countPosts, $limit, $page);

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta]);
    }

    private function baseQuery()
    {
        return Post::with(['user', 'category', 'tags', 'media'])
            ->where('status', 'published')
            ->whereNotNull('published_at');
    }

    private function getFeaturedPosts($limit, $offset = 0)
    {
        return $this->baseQuery()
            ->where('is_featured', true)
            ->orderByDesc('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getNewestPosts($limit, $offset = 0)
    {
        return $this->baseQuery()
            ->orderByDesc('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getOldestPosts($limit, $offset = 0)
    {
        return $this->baseQuery()
            ->orderBy('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getRelatedPosts($postId, $limit, $offset = 0)
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
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function searchPosts($request, $limit, $offset = 0)
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
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getPopularPosts($limit, $offset = 0)
    {
        return $this->baseQuery()
            ->orderByDesc('views')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getDefaultPosts()
    {
        return $this->baseQuery()
            ->orderByDesc('published_at')
            ->paginate(10);
    }

    private function addMeta(int $countPosts, ?int $limit = 10, ?int $currentPage = 1)
    {
        return $meta = [
            "total" => $countPosts,
            "per_page" => $limit,
            "current_page" => $currentPage,
            "last_page" => ceil($countPosts / $limit),
        ];
    }
}
