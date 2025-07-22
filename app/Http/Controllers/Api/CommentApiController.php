<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;

class CommentApiController extends Controller
{
    public function index(Post $post)
    {
        $comments = Comment::with(['user', 'replies.user'])
            ->where('post_id', $post->id)
            ->whereNull('parent_id')
            ->latest()
            ->paginate(20);

        return CommentResource::collection($comments);
    }
}
