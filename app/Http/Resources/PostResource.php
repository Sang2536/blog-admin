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
            'author'        => new AuthorResource($this->whenLoaded('user')),
            'category'      => new CategoryResource($this->whenLoaded('category')),
            'tags'          => $this->tags->pluck('name'),
            'media'         => $this->media->map(function ($media) {
                return [
                    'url' => $media->url,
                    'name' => $media->name,
                ];
            }),
        ];
    }
}
