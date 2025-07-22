<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostFilterService;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function __construct(protected PostFilterService $filterService) {}

    //  GET /posts?type=related&page=6&limit=10&...
    public function index(Request $request)
    {
        // Thông tin phân trang cơ bản
        $limit = (int) $request->input('limit', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Service xử lý theo SearchParams
        $result = $this->filterService->getFilter($request, $limit, $offset, $page);

        // Nếu là mặc định (trả về paginated object)
        if ($result === 'default') {
            $paginated = $this->filterService->baseQuery()
                ->orderByDesc('published_at')
                ->paginate($limit, ['*'], 'page', $page);

            $meta = $this->addMeta($paginated->total(), $limit, $page);

            $stats = [
                'total' => $paginated->total(),
                'views' => $paginated->sum('views'),
                'comments' => $paginated->sum(fn($p) => $p->comments->count()),
            ];

            return PostResource::collection($paginated)
                ->additional(['meta' => $meta, 'stats' => $stats]);
        }

        // Trường hợp bài viết liên quan không tồn tại
        if ($result === null) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Kết quả lọc:['posts' => ..., 'total' => ...]
        $posts = $result['posts'];
        $total = $result['total'];

        // Tạo meta
        $meta = $this->addMeta($total, $limit, $page);

        // Thống kê
        $stats = [
            'total' => $total,
            'views' => collect($posts)->sum('views'),
            'comments' => collect($posts)->sum(fn($p) => $p->comments->count()),
        ];

        return PostResource::collection(collect($posts))
            ->additional(['meta' => $meta, 'stats' => $stats]);
    }

    //  GET /posts/{slug}
    public function show($post)
    {
        $postDetail = Post::with(['user', 'category', 'tags', 'media', 'comments'])
            ->where('id', $post)
            ->orWhere('slug', $post)
            ->where('status', 'published')
            ->firstOrFail();

        $stats = [
            'views' => $postDetail->views,
            'comments' => $postDetail->comments()->count(),
        ];

        return (new PostResource($postDetail))
            ->additional(['stats' => $stats]);
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

        // Tổng số bài viết của tác giả
        $countPosts = $author->posts()->count();

        $posts = $author->posts()
            ->orderByDesc('published_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Tạo meta
        $meta = $this->addMeta($countPosts, $limit, $page);

        // Thống kê
        $stats = [
            'total' => $countPosts,
            'views' => $author->posts()->sum('views'),
            'comments' => $author->posts()
                ->withCount('comments')
                ->get()
                ->sum('comments_count'),
        ];

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta, 'stats' => $stats]);
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

        // Tổng số bài viết thuộc danh mục
        $countPosts = $category->posts()->count();

        // Lấy danh sách bài viết theo phân trang
        $posts = $category->posts()
            ->orderByDesc('published_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Tạo meta
        $meta = $this->addMeta($countPosts, $limit, $page);

        // Thống kê
        $stats = [
            'total' => $countPosts,
            'views' => $category->posts()->sum('views'),
            'comments' => $category->posts()
                ->withCount('comments')
                ->get()
                ->sum('comments_count'),
        ];

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta, 'stats' => $stats]);
    }

    //  GET /posts/tag/{slug}
    public function getPostsByTag(Request $request, $slug)
    {
        $tag = Tag::where('id', $slug)
            ->orWhere('slug', $slug)
            ->first();

        if (!$tag) {
            return response()->json([
                'message' => 'Thẻ không tồn tại.'
            ], 404);
        }

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Tổng số bài viết có tag tương ứng
        $countPosts = $tag->posts()->count();

        // Lấy bài viết theo điều kiện
        $posts = $tag->posts()
            ->orderByDesc('published_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Tạo meta
        $meta = $this->addMeta($countPosts, $limit, $page);

        // Thống kê
        $stats = [
            'total' => $countPosts,
            'views' => $tag->posts()->sum('views'),
            'comments' => $tag->posts()
                ->withCount('comments')
                ->get()
                ->sum('comments_count'),
        ];

        // Trả về PostResource cùng với meta
        return PostResource::collection($posts)
            ->additional(['meta' => $meta, 'stats' => $stats]);
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
