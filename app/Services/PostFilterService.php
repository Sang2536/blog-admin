<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Post;

class PostFilterService
{
    public function getFilter(Request $request, int $limit, int $offset, int $page): array|string
    {
        $type = $request->query('type');

        return match ($type) {
            'featured' => [
                'posts' => $this->getFeaturedPosts($limit, $offset),
                'total' => Post::where('is_featured', true)->count(),
            ],
            'newest' => [
                'posts' => $this->getNewestPosts($limit, $offset),
                'total' => Post::count(),
            ],
            'oldest' => [
                'posts' => $this->getOldestPosts($limit, $offset),
                'total' => Post::count(),
            ],
            'popular' => [
                'posts' => $this->getPopularPosts($limit, $offset),
                'total' => Post::count(),
            ],
            'related' => $this->getRelatedPosts($request->query('related_to'), $limit, $offset),
            default => 'default',
        };
    }

    public function baseQuery()
    {
        return Post::with(['user', 'category', 'tags', 'media', 'comments'])
            ->where('status', 'published')
            ->whereNotNull('published_at');
    }

    private function getFeaturedPosts($limit, $offset)
    {
        return $this->baseQuery()
            ->where('is_featured', true)
            ->orderByDesc('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getNewestPosts($limit, $offset)
    {
        return $this->baseQuery()
            ->orderByDesc('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getOldestPosts($limit, $offset)
    {
        return $this->baseQuery()
            ->orderBy('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getPopularPosts($limit, $offset)
    {
        return $this->baseQuery()
            ->orderByDesc('views')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    private function getRelatedPosts($postId, $limit, $offset)
    {
        $currentPost = Post::find($postId);

        if (!$currentPost) {
            return null;
        }

        $tagIds = $currentPost->tags->pluck('id');
        $categoryId = $currentPost->category_id;

        $postsQuery = $this->baseQuery()
            ->where('id', '!=', $currentPost->id)
            ->where('category_id', $categoryId)
            ->whereHas('tags', fn($q) => $q->whereIn('tags.id', $tagIds))
            ->orderByDesc('published_at');

        return [
            'current_post' => $currentPost,
            'posts' => $postsQuery->offset($offset)->take($limit)->get(),
            'total' => $postsQuery->count(),
        ];
    }

    public function searchPosts(Request $request, $limit, $offset)
    {
        $query = $this->searchQuery($request);

        return $query->orderByDesc('published_at')
            ->offset($offset)
            ->take($limit)
            ->get();
    }

    public function countSearchPosts(Request $request)
    {
        return $this->searchQuery($request)->count();
    }

    private function searchQuery(Request $request)
    {
        $query = $this->baseQuery();

        // Lọc theo keyword / search toàn văn
        $keyword = $request->get('keyword') ?? $request->get('q');
        $separator = $request->get('separator', ' ');

        if ($keyword) {
            $keywords = is_string($keyword) ? explode($separator, $keyword) : [$keyword];

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('title', 'like', "%$word%")
                        ->orWhere('excerpt', 'like', "%$word%")
                        ->orWhere('content', 'like', "%$word%")
                        ->orWhereHas('tags', fn($tagQ) => $tagQ->where('name', 'like', "%$word%"))
                        ->orWhereHas('category', fn($catQ) => $catQ->where('name', 'like', "%$word%"));
                }
            });
        }

        // Lọc theo Category[]
        if ($request->filled('categories')) {
            $categories = is_array($request->categories)
                ? $request->categories
                : explode(',', $request->categories);

            $query->whereHas('category', fn($q) => $q->whereIn('slug', $categories));
        }

        // Lọc theo Tag[]
        if ($request->filled('tags')) {
            $tags = is_array($request->tags)
                ? $request->tags
                : explode(',', $request->tags);

            $query->whereHas('tags', fn($q) => $q->whereIn('slug', $tags));
        }

        // Lọc theo khoảng ngày
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        // Lọc theo tác giả
        if ($request->filled('author_id')) {
            $query->where('user_id', $request->author_id);
        }

        // Lọc bài có hình ảnh
        if ($request->has('has_image') && $request->boolean('has_image')) {
            $query->whereHas('media');
        }

        // Lọc bài đã xuất bản
        if ($request->has('is_published')) {
            $isPublished = $request->boolean('is_published');
            if ($isPublished) {
                $query->where('status', 'published')
                    ->whereNotNull('published_at');
            } else {
                $query->where('status', '!=', 'published');
            }
        }

        // Lọc theo lượt xem nhiều / ít
        if ($request->filled('view')) {
            if ($request->view === 'most') {
                $query->orderByDesc('views');
            } elseif ($request->view === 'least') {
                $query->orderBy('views');
            }
        }

        // Lọc theo comment nhiều / ít
        if ($request->filled('comment')) {
            $query->withCount('comments');

            if ($request->comment === 'most') {
                $query->orderByDesc('comments_count');
            } elseif ($request->comment === 'least') {
                $query->orderBy('comments_count');
            }
        }

        // Sắp xếp theo sort + order
        if ($request->filled('sort')) {
            $sort = $request->sort;
            $order = $request->get('order', 'desc');

            match ($sort) {
                'date' => $query->orderBy('published_at', $order),
                'views' => $query->orderBy('views', $order),
                'comments' => $query->withCount('comments')->orderBy('comments_count', $order),
                'default' => $query->orderBy('published_at', 'desc'),
                default => null,
            };
        } else {
            // Mặc định sắp xếp mới nhất
            $query->orderBy('published_at', 'desc');
        }

        return $query;
    }
}
