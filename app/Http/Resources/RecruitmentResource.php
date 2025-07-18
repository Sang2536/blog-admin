<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'position'    => $this->position,
            'location'    => $this->location,
            'type'        => $this->type,
            'start_date'  => $this->start_date->toDateString(),
            'end_date'    => $this->end_date->toDateString(),
            'is_active'   => $this->is_active,
            'author'      => new AuthorResource($this->whenLoaded('user')),
            'applications' => ApplicationResource::collection($this->whenLoaded('applications')),
        ];
    }
}
