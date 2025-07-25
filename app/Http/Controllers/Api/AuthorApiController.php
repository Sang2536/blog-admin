<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorApiController extends Controller
{
    // GET /api/authors
    public function index(Request $request)
    {
        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Tổng số author
        $countUsers = User::where('is_author', true)->count();

        $authors = User::with('posts')
            ->withCount('posts')
            ->where('is_author', true)
            ->orderByDesc('posts_count')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Thống kê
        $authorStats = [
            'authors' => $authors->count(),
            'posts' => $authors->sum(fn ($author) => $author->posts->count()),
            'post_views' => $authors->sum(fn ($author) => $author->posts->sum('views')),
        ];

        // Tạo meta
        $meta = [
            "total" => $countUsers,
            "per_page" => $limit,
            "current_page" => $page,
            "last_page" => ceil($countUsers / $limit),
        ];

        return AuthorResource::collection($authors)
            ->additional(['stats' => $authorStats, 'meta' => $meta]);
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
