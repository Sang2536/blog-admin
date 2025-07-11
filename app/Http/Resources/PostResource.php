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
            'author'        => $this->user->name ?? null,
            'category'      => [
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
