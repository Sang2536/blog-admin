<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'excerpt'       => $this->excerpt,
            'excerpt_short' => $this->excerpt_short,
            'content'       => $this->content,
            'published_at'  => $this->published_at->toDateTimeString(),
            'author'        => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? null,
                'email' => $this->user->email ?? null,
                'slug' => $this->user->slug ?? null,
                'avatar' => $this->user->avatar ?? null,
                'is_active' => $this->user->is_active ?? null,
            ],
            'category'      => [
                'id' => $this->category->id ?? null,
                'name' => $this->category->name ?? null,
                'slug' => $this->category->slug ?? null,
            ],
            'tags' => $this->tags->pluck('name'),
            'media' => $this->media->map(function ($media) {
                return [
                    'url' => $media->url,
                    'name' => $media->name,
                ];
            }),
        ];
    }
}
